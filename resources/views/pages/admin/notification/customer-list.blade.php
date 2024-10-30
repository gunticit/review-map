@extends('layouts.app')
@section('content')
    <section class="section notificate-customer mb-5 mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="clear col-sm-12 text-right">
                    <button class="btn btn-primary my-3" type="button" onclick="window.location.href='{{ route('create.notificate.customer') }}'">
                        <i class="fas fa-plus"></i> Tạo thông báo
                    </button>
                </div>
            </div>
            <div class="col-inner">
                <h2 class="section-title mb-4">Danh sách thông báo</h2>
                <div id="group-alert">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success') || session('error'))
                        <script>
                            $('.alert').setTimeout(() => {
                                $('.alert').remove();
                            }, 5000);
                        </script>
                    @endif
                </div>
                <form id="formSearch" action="{{ route('list.notificate.customer') }}" method="GET">
                    <div class="input-group group-search">
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" value="{{ request()->name }}" placeholder="Tìm kiếm" name="name" class="form-control" id="inputSearch">
                        </div>
                        <button class="btn btn-default btn-filter" type="button" onclick="filter()">
                            <img src="{{ asset('./assets/img/filter.svg') }}" alt="filter"> <span>Tìm kiếm</span>
                        </button>
                    </div>
                </form>
                <div class="group-table-list">
                    <table class="table list-table">
                        <thead>
                            <tr>
                                <th class="list-table-stt" scope="col">STT</th>
                                <th class="list-table-code">Thời gian</th>
                                <th class="list-table-name" scope="col">Tiêu đề</th>
                                <th class="list-table-description" scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($notifications))
                                @foreach($notifications as $key => $notificate)
                                    <tr class="notificate-{{ $notificate->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td class="list-table-stt">{!! date('d/m/Y H:i:s', strtotime($notificate->created_at)) !!}</td>
                                        <td class="list-table-code">
                                            <a href="{{ route('edit.notificate.customer', $notificate->id) }}" class="text-primary">{{ $notificate->title }}</a>
                                        </td>
                                        <td class="list-table-actions">
                                            <form action="{{ route('delete.notificate.customer', $notificate->id) }}" method="POST" style="display:inline-block;">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <button type="submit" class="btn text-default" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                    <span class="material-symbols-outlined">
                                                        delete
                                                    </span>
                                                    Thu hồi
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center">Chưa có thông báo nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{ $notifications->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>
@endSection