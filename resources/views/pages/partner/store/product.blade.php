@extends('layouts.app')
@section('css')
    <style>
        .btn-cart{
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            right: 10px;
            background: #0059a6;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            cursor: pointer;
        }
        .btn-cart > span{
            position: relative;
            top: 5px;
        }
        .btn-cart > span{
            position: relative;
            top: 5px;
        }
        .btn-cart > span.count{
            position: absolute;
            top: 8px;
            right: 8px;
            height: 20px;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 50%;
            color: #1364ef;
            font-weight: bold;
            font-size: 12px;
        }
        .info-cart{
            width: 480px;
            height: 500px;
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            right: -200%;
            visibility: hidden;
            background: #fff;
            box-shadow: -5px -2.5px 10px #cdd0e2;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            padding: 10px;
            transition: all 0.4s ease;
        }
        .bg-cart{
            position: relative;
            height: 100%;
            width: 100%;
        }
        .info-cart.show-cart{
            right: 0%;
            visibility: visible;
        }
        .info-cart ul{
            list-style: none;
            overflow: auto;
            height: 100%;
            width: 100%;
            padding-left: 0;
            position: relative;
        }
        .info-cart ul > li{
            display: flex;
            gap: 12px;
            margin-bottom: 10px;
        }
        .info-cart ul > li:last-child{
            margin-bottom: 70px
        }
        .info-cart ul > li img{
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            object-fit: cover;
        }
        .info-cart ul > li .info{
            flex: 1;
        }
        .info-cart ul > li .info p{
            font-size: 16px;
            margin-bottom: 5px;
        }
        .cart-item .quantity{
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
        }
        .info-cart ul > li .btn-remove-item{
            display: flex;
            border: none;
            transition: all 0.4s ease;
        }
        .info-cart ul > li .btn-remove-item > span{    
            font-size: 18px;
            color: #737373;
        }
        .info-cart ul > li .btn-remove-item:hover{
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            background: #f74848;
        }
        .info-cart ul > li .btn-remove-item:hover span{
            color: #fff;
        }
        .total-cart{
            position: absolute;
            background: #fff;
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding-top: 10px;
            bottom: 0;
            left: 0;
            border-top: 1px solid #c2c2c2;
        }
        #cart-total-formatted{
            margin: 0;
            font-weight: bold;
            color: #e61313;
        }
    </style>
@endsection
@section('content')
    <section class="section shop mb-5 mt-5">
        <div class="container-fluid">
            <div class="col-inner">

                <div class="shop-head d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-4">Sản phẩm</h2>
                    <div class="mb-3 filter-group skeleton">
                        <div class="form-group">
                            <select class="form-select form-select-lg" onChange="filterCategory(this.value)" aria-label="Default select example">
                                <option selected value="">Tất cả</option>
                                @if(!empty($categories))
                                    @foreach($categories as $category)
                                        <option {!! isset($filter_data['category_id']) && $category->id == $filter_data['category_id'] ? 'selected' : '' !!} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                </div>

                <div class="product row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 skeleton">
                    @if (!empty($products) && count($products) > 0)
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="product-box">
                                    <div class="product-image">
                                        <a href="{{ route('detail.product.partner', ['slug' => $product->slug]) }}">
                                            <img src="{!! !empty($product->images[0]) ? asset('storage/'.$product->images[0]->link_image) : asset('assets/img/image-54.jpg') !!}" alt="">
                                        </a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="{{ route('detail.product.partner', ['slug' => $product->slug]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <div class="product-price">
                                        <span>{{ formatCurrency($product->price) }}</span>
                                    </div>
                                    <button onclick="addToCart({{ $product->id }})" class="add-to-cart btn btn-primary">Thêm vào giỏ</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col" style="margin: auto">
                            <div class="product-box">
                                <div class="product-image">
                                    <a href="#">
                                        <img src="{!! asset('assets/img/empty_cart.jpeg') !!}" alt="">
                                    </a>
                                </div>
                                <h3 class="product-title text-center">
                                    Hiện tại chưa có sản phẩm nào!
                                </h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <span class="btn-cart">
            <span class="material-symbols-outlined">
                shopping_cart
            </span>
            <span class="count">0</span>
        </span>
        <div id="cart" class="info-cart">
            <div class="bg-cart">
                <ul>
                    @for($i = 0; $i < 15; $i++)
                    <li class="cart-item">
                        <img src="{{ asset('./assets/img/Rectangle-22794.jpg') }}" alt="image">
                        <div class="info">
                            <p class="name">Sản phẩm</p>
                            <p class="price">Giá</p>
                        </div>
                        <div class="quantity">
                            x 1
                        </div>
                        <div>
                            <button class="btn-remove-item" onclick="removeItem(this)">
                                <span class="material-symbols-outlined">
                                    backspace
                                </span>
                            </button>
                        </div>
                    </li>
                    @endfor
                </ul>

                <div class="total-cart">
                    <div class="total">
                        <span class="fw-700">Tổng cộng</span>
                        <span id="cart-total-formatted">0 VND</span>
                    </div>
                    <div class="btn-checkout">
                        <button class="btn btn-primary">Thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        function filterCategory(id) {
            window.location.href = "{{ route('store.product') }}?category_id=" + id
        }
        function addToCart(id) {
            $.ajax({
                url: "{{ route('ajax.cart.add') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'product_id': id,
                    'quantity': 1
                },
                dataType: 'json',
                success: function(data) {
                    if(data.success){
                        showAlert('success',data.message);
                    }else{
                        showAlert('error',data.message);
                    }
                }
            });
        }
        function removeItem(element) {
            
        }
        $(document).ready(function() {
            $('.btn-cart').on('click', function(e){
                e.stopPropagation();
                $(this).fadeOut();
                $('#cart').addClass('show-cart');
                $(this).delay(1000).fadeIn();
            });
            $('.info-cart').on('click', function(e){
                e.stopPropagation();
            });
            $('body').on('click', function(){
                $('.info-cart').removeClass('show-cart');
            });
        })
    </script>
@endsection