@extends('layouts.app')
@section('content')
    <section class="section shop mb-5 mt-5">
        <div class="container">
            <div class="col-inner">

                <div class="shop-head d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-4">Sản phẩm</h2>
                    <div class="mb-3">
                        <select class="form-select form-select-lg" name="" id="">
                            <option selected>Tất cả</option>
                            @if(!empty($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                </div>

                <div class="product row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3">
                    @if (!empty($products))
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="product-box">
                                    <div class="product-image">
                                        <a href="4.1.chi-tiet-san-pham.php"><img
                                                src="{{ asset('assets/img/image-54.jpg') }}" alt=""></a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="4.1.chi-tiet-san-pham.php">
                                            Lacus suspendisse faucibus interdum
                                        </a>
                                    </h3>
                                    <div class="product-price">
                                        <span>100.000 VND</span>
                                    </div>
                                    <button class="add-to-cart btn btn-primary">Thêm vào giỏ</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
