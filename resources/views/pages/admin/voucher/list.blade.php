@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="clear col-sm-12 text-right">
                    <button class="btn btn-primary my-3" type="button" onclick="window.location.href='{{ route('voucher.create') }}'">
                        <i class="fas fa-plus"></i> Tạo mã giảm giá
                    </button>
                </div>
            </div>
            <div class="col-inner">
                <h2 class="section-title mb-4">Danh sách mã giảm giá</h2>
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
                <form id="formSearch" action="{{ route('voucher.index') }}" method="GET">
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
                            <th class="list-table-code">Mã</th>
                            <th class="list-table-name" scope="col">Tên mã</th>
                            <th class="list-table-description" scope="col">Mô tả</th>
                            <th class="list-table-money" scope="col">Số tiền giảm</th>
                            <th class="list-table-number" scope="col">Số lượng</th>
                            <th class="list-table-date" scope="col">Ngày bắt đầu</th>
                            <th class="list-table-actions" scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($vouchers))
                            @foreach($vouchers as $voucher)
                                <tr class="voucher-{{ $voucher->id }}">
                                    <td class="list-table-stt">{{ $voucher->id }}</td>
                                    <td class="list-table-code">{{ $voucher->code }}</td>
                                    <td class="list-table-name">{{ $voucher->name }}</td>
                                    <td class="list-table-description">{{ $voucher->description }}</td>
                                    <td class="list-table-money">{{ number_format($voucher->discount_value) }} {{ $voucher->discount_type == 'fixed' ? 'VNĐ' : '%' }}</td>
                                    <td class="list-table-money">{{ number_format($voucher->max_uses) }}</td>
                                    <td class="list-table-date">{{ date('d/m/Y', strtotime($voucher->start_date)) }}</td>
                                    <td class="list-table-actions">
                                        <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center">Không có mã giảm giá nào được tìm thấy</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
