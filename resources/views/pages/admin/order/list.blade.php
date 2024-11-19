@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container-fluid">
            <div class="col-inner">
                <h2 class="section-title mb-4">Thông tin đơn hàng</h2>
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
                <form id="formSearch" action="{{ route('order.index') }}" method="GET">
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
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-name">
                                Họ và tên
                            </th>
                            <th>Số điện thoại</th>
                            <th class="list-table-creater" scope="col">Địa chỉ</th>
                            <th>Tổng cộng</th>
                            <th>
                                Số điện thoại đặt
                            </th>
                            <th>
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($orders) && count($orders) > 0)
                            @foreach($orders as $order)
                            <tr class="order-{{ $order['id'] }}">
                                <td class="list-table-stt" scope="col">{{ $order['id'] }}</td>
                                <td class="list-table-name">
                                    {{ $order['recipient_name'] }}
                                </td>
                                <td class="list-table-name">
                                    {{ $order['recipient_phone'] }}
                                </td>
                                <td class="list-table-creater" scope="col">
                                    {{ $order['shipping_address'] }}
                                </td>
                                <td class="list-table-time" scope="col">
                                    {{ $order['total'] ?? 0 }}
                                </td>
                                <td class="list-table-progree" scope="col">
                                    {{ $order['status'] }}
                                </td>
                                <td class="list-table-time" scope="col">
                                    {{ $order['telephone'] }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.order.view', $order['id']) }}" class="btn btn-default">Chi tiết</a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <img src="{{ asset('assets/img/no-image.svg') }}" alt="no-data"> <span>{{ __('Chưa có đơn hàng') }}</span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if(!empty($orders) && count($orders) > 0)
                {{ $orders->links('vendor.pagination.custom') }}
                @endif
            </div>
        </div>
    </section>
@endsection