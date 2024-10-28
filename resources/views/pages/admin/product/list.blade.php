@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="clear col-sm-12 text-right">
                    <button class="btn btn-primary my-3" type="button" onclick="window.location.href='{{ route('product.create') }}'">
                        <i class="fas fa-plus"></i> Đăng sản phẩm
                    </button>
                </div>
            </div>
            <div class="col-inner">
                <h2 class="section-title mb-4">Danh sách dự án</h2>
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
                <form>
                    <div class="input-group group-search">
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
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
                            <th class="list-table-customer-code" scope="col">Mã khách hàng</th>
                            <th class="list-table-product-name" scope="col">Tên sản phẩm</th>
                            <th class="list-table-product-code" scope="col">
                                Mã sản phẩm
                            </th>
                            <th class="list-table-image" scope="col">   
                                Hình đại diện
                            </th>
                            <th class="list-table-product">
                                Danh mục
                            </th>
                            <th class="list-table-price">
                                Giá sản phẩm
                            </th>
                            <th class="list-table-handle">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="list-table-product-name" scope="col">{{ $product->id }}</td>
                                <td class="list-table-product-code" scope="col">
                                   
                                </td>
                                <td class="list-table-product-code" scope="col">
                                   {{ $product->name }}
                                </td>
                                <td class="list-table-product-code" scope="col">
                                   {{ $product->product_code }}
                                </td>
                                <td class="list-table-image" scope="col">   
                                    <img src="{{ asset($product->image) }}" alt="image" width="100px">
                                </td>
                                <td class="list-table-product">
                                    
                                </td>
                                <td class="list-table-price">
                                    {!! $product->price ? formatVND($product->price) : '' !!}
                                </td>
                                <td class="list-table-handle">
                                    {{$product->id}}
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                {{ $products->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>
    <!-- end danh-sach-du-an --> 
@endsection