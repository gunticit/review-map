@extends('layouts.app')
@section('content')
    <!-- thong ke -->
    <section class="thong-ke">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                    <div class="thong-ke-item text-center">
                        <div class="thong-ke-head">
                            <span class="material-symbols-outlined">contract</span>
                            <h5>Tổng dự án</h5>
                        </div>
                        <div class="thong-ke-content">
                            <h6 class="text-primary">{{ $total }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                    <div class="thong-ke-item text-center">
                        <div class="thong-ke-head">
                            <span class="material-symbols-outlined">task</span>
                            <h5>Đang thực hiện</h5>
                        </div>
                        <div class="thong-ke-content">
                            <h6 class="text-primary">{{ $working }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                    <div class="thong-ke-item text-center">
                        <div class="thong-ke-head">
                            <span class="material-symbols-outlined">scan_delete</span>
                            <h5>Đã tạm dừng</h5>
                        </div>
                        <div class="thong-ke-content">
                            <h6 class="text-primary">{{ $stopped }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                    <div class="thong-ke-item text-center">
                        <div class="thong-ke-head">
                            <span class="material-symbols-outlined">attach_money</span>
                            <h5>Đã chi tiêu</h5>
                        </div>
                        <div class="thong-ke-content">
                            <h6 class="text-danger">500.000 VND</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end thong ke  -->
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container">
            <div class="col-inner">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="section-title mb-4">Danh sách dự án</h2>
                    </div>
                    <div class="col-sm-4 text-right">
                        {{-- <button type="button" class="btn btn-danger" id="btn-delete">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </button> --}}
                    </div>
                </div>
                <form>
                    <div class="input-group">
                        <button class="input-group-text" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                        <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                    </div>
                </form>
                <div id="list-project">
                    <table class="table list-table">
                        <thead>
                            <tr>
                                <th width="15"></th>
                                <th width="35" class="list-table-stt" scope="col">STT</th>
                                <th class="list-table-title" scope="col">Tên dự án</th>
                                <th class="list-table-link-map" scope="col">URL Google Map</th>
                                <th class="list-table-progree" scope="col">
                                    <a href="#" class="sort">Trạng thái</a>
                                </th>
                                <th class="list-table-status" scope="col">
                                    <a href="#" class="sort">Thao tác </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                                <td width="15" style="padding: 5px">
                                    <input type="checkbox" class="form-check-input" id="check_{{ $project->id }}">
                                </td>
                                <td width="35">{{ $project->id }}</td>
                                <td class="list-table-title">
                                    <a href="{{ route('project.edit', ['id' => $project->id]) }}">{{ $project->name }}</a>
                                </td>
                                <td class="list-table-link-map">
                                    <a class="btn" target="_blank" href="https://www.google.com/maps/place/?q=place_id:{{$project->place_id}}" role="button">
                                        <span class="material-symbols-outlined">link</span>
                                    </a>
                                </td>
                                <td class="list-table-progree">
                                    <a class="{{ checkStatus($project->status)['className'] }}">{{ checkStatus($project->status)['labelStatus'] }}</a>
                                </td>
                                <td class="list-table-status">
                                    @if($project->status == 1)
                                        <a href="javascript:void(0)" style="display: flex;" val-status="{{ $project->status }}" val-id="{{ $project->id }}" class="btn btn-outline-warning btn-change-status" role="button">
                                            <span class="material-symbols-outlined">motion_photos_paused</span> <span>Tạm dừng</span>
                                        </a>
                                    @elseif($project->status == 4)
                                        <a href="javascript:void(0)" style="display: flex;" val-status="{{ $project->status }}" val-id="{{ $project->id }}" class="btn btn-outline-success btn-change-status" role="button">
                                            <span class="material-symbols-outlined"> play_arrow </span> <span>Tiếp tục</span> 
                                        </a>
                                    @elseif($project->status == 5)
                                        <a href="{{ route('page.order.project', ['id' => $project->id]) }}" style="display: flex;" val-status="{{ $project->status }}" val-id="{{ $project->id }}" class="btn btn-outline-primary" role="button">
                                            <span class="material-symbols-outlined"> payments </span> <span>Thanh toán</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $projects->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>
    <!-- end danh-sach-du-an --> 
    <script>
        $('#inputSearch').on('keyup', function() {
            let rs_search = $(this).val();
            $.ajax({
                url: "{{ route('project.search') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: rs_search
                },
                success: function(res) {
                    $('#list-project tbody').html(res);
                }
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.form-check-input').on('change', function() {
                if ($('.form-check-input:checked').length > 0) {
                    $('#btn-delete').hide(); // CHưa làm nếu làm thì đổi thành show()
                } else {
                    $('#btn-delete').hide();
                }
            });
            $('.btn-change-status').on('click', function() {
                if(confirm('Xác nhận lại thay đổi trạng thái dự án')){
                    let currentStatus = $(this).attr('val-status');
                    let status = 1;
                    if(currentStatus == 1){
                        status = 4;
                    }
                    $.ajax({
                        url: "{{ route('project.update.status', ['id' => 'ID_PLACEHOLDER']) }}".replace('ID_PLACEHOLDER', $(this).attr('val-id')),
                        type: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            status: status
                        },
                        success: function(res) {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection