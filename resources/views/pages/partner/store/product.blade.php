@extends('layouts.app')
@section('content')
    <style>
        .no-data{
            text-align: center;
            padding: 150px 0;
        }
        .no-data .material-symbols-outlined{
            font-size: 150px;
            display: block;
        }
    </style>
    <!-- danh-sach-du-an -->
    <section class="section section-wallet mb-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- cot 1 -->
                <div class="col-xl-12 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                    <div class="section-title row">
                        <h2 class="section-title mb-4 col-sm-8">Sản phẩm</h2>
                        <div class="col-sm-4">
                            <select class="form-control">
                                <option value="*">Tất cả</option>
                                @if(!empty($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="list-table">
                        @if(!empty($products))
                            @foreach($products as $product)
                                <div class="list-table-row d-flex">
                                    <div class="list-table-img">
                                        <img src="{{ asset($product->image) }}" alt="image">
                                    </div>
                                    <div class="list-table-info">
                                        <h3 class="list-table-name"><a href="{{ route('admin.product.edit', $product->id) }}">{{ $product->name }}</a></h3>
                                    </div>
                                    <div class="list-table-price">
                                        {!! $product->price ? formatVND($product->price) : '' !!}
                                    </div>
                                    <div class="list-table-handle">
                                        <a href="javascript:void(0);" onclick="handleAddCart()" class="btn btn-outline-primary">Thêm vào giỏ</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-data">
                                <span class="material-symbols-outlined">
                                    production_quantity_limits
                                </span>
                                Không tìm thấy sản phẩm
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    </section>
@endsection