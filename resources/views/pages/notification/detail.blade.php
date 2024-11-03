@extends('layouts.app')
@section('content')
    <section class="section chi-tiet-thong-bao mb-5 mt-5">
        <div class="container">
            <div class="col-inner">
                <h2 class="section-title mb-4 ">Chi tiết thông báo</h2>
                
                <div class="single-post">
                    <div class="single-post-header d-flex justify-content-between align-items-center">

                        <h1 class="single-post-title">{{ $notification->title ?? '' }}</h1>
                        <div class="single-post-meta">
                            <div class="single-post-time d-inline-block"> {!! !empty($notification->created_at) ? date('d/m/Y', strtotime($notification->created_at)) : '' !!} <span>{!! !empty($notification->created_at) ? date('H:i:s', strtotime($notification->created_at)) : '' !!} </span></div>
                            <a  class="btn d-inline-block btn-delete" href="javascript:void(0);" onclick="deleteNotification({{ $notification->id }})"><span class="material-symbols-outlined">delete</span></a>
                        </div>
                    </div>

                    <div class="single-post-description">
                        {{ $notification->content ?? '' }}
                    </div>
                    <div class="file-download text-right">
                        @if(isset($notification->file_path))
                            <a href="{{ url('storage/'.$notification->file_path) }}" class="btn btn-outline-primary fw-300 mt-3 py-2 px-4" target="_blank">
                                <span class="material-symbols-outlined">
                                    download
                                </span>
                                <span>Tải file đính kèm</span>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script>
        function deleteNotification(id) {
            if(confirm('Bạn có chắc muốn xoá ?')) {
                $.ajax({
                    url: '/notification-delete/'+id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            showAlert('success', 'Xóa thông báo thành công','/notification');
                        }else{
                            showAlert('error', response.message);
                        }
                    }
                })
            }
        }
    </script>
@endsection