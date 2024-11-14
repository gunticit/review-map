@extends('layouts.app')
@section('content')
<section class="section thong-bao mb-5 mt-5">
    <div class="container-fluid">
        <div class="col-inner">
            <h2 class="section-title mb-4">Danh sách thông báo</h2>
            <form>
                <div class="input-group">
                    <button class="input-group-text" type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                </div>
            </form>
            <div class="group-table-list">
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" scope="col">STT2</th>
                            <th class="list-table-title" scope="col">Tiêu đề</th>
                            <th class="list-table-creator" scope="col">Người tạo</th>
                            <th class="list-table-progree" scope="col">Trạng thái</th>
                            <th class="list-table-time" scope="col">Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $index => $notification)
                        <tr>
                            <td>{{ $notification->id }}</td>
                            <td class="list-table-title">
                                <a href="{{ route('notification.show', ['id' => $notification->id]) }}">{{ $notification->title }}</a>
                            </td>
                            <td class="list-table-creator">
                                {{ $notification->user->name }}
                            </td>
                            <td class="list-table-progree">
                                <a class="btn btn-{{ $notification->status == 1 ? 'success' : 'danger' }}">
                                    {{
                                    __(config('constants.status_notification')[$notification->status]) 
                                    }}
                                </a>
                            </td>
                            <td class="list-table-time">
                                <a href="javascript:void(0);">{{ $notification->created_at->format('d/m/Y') }} <span>{{
                                        $notification->created_at->format('H:i') }}</span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $notifications->links('vendor.pagination.custom') }}
        </div>
    </div>
</section>
<script>
    $('document').ready(function(){
        $('#inputSearch').on('keypress', function(e){
            if(e.which === 13){
                e.preventDefault();
                const keyword = $(this).val();
                if(!keyword){
                    return;
                }
                try{
                    const url = `/notification?keyword=${encodeURIComponent(keyword)}`;
                    window.location.href = url;
                }catch(error){
                    console.error(error);
                }
            }
        });
    })
</script>
@endsection