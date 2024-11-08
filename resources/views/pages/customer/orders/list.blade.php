@extends('layouts.app')
@section('content')
    <!-- thong ke -->
    <section class="thong-ke skeleton">
        <div class="container-fluid">
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
        <div class="container-fluid">
            <div class="col-inner">
                <h2 class="section-title mb-4">Danh sách dự án</h2>
                <form>
                    <div class="input-group">
                        <button class="input-group-text" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                        <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                    </div>
                </form>
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-title" scope="col">Tên dự án</th>
                            <th class="list-table-link-map" scope="col">URL Google Map</th>
                            <th class="list-table-progree" scope="col">
                                <a href="javascript:void(0);" class="sort">Trạng thái</a>
                            </th>
                            <th class="list-table-status" scope="col">
                                <a href="javascript:void(0);" class="sort">Thao tác </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td class="list-table-title">
                                <a href="{{ route('project.edit', ['id' => $project->id]) }}">{{ $project->name }}</a>
                            </td>
                            <td class="list-table-link-map">
                                <a class="btn" target="_blank" href="{{ route('project.edit', ['id' => $project->id]) }}" role="button">
                                    <span class="material-symbols-outlined">link</span>
                                </a>
                            </td>
                            <td class="list-table-progree">
                                <a class="btn {{ checkStatus($project->status)['className'] }}">{{ checkStatus($project->status)['labelStatus'] }}</a>
                            </td>
                            <td class="list-table-status">
                                <a class="btn" href="{{ route('project.update.status', ['id' => $project->id]) }}" role="button">
                                    <span class="material-symbols-outlined">motion_photos_paused</span> Tạm dừng 
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $projects->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>
    <!-- end danh-sach-du-an --> 
@endsection