@extends('layouts.app')
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
                                    <button onclick="addToCart({{ $product->id }}, this)" class="add-to-cart btn btn-primary">Thêm vào giỏ</button>
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
    </section><span class="btn-cart">
        <span class="material-symbols-outlined">
            shopping_cart
        </span>
        <span class="count">{{ $cart_info['total_quantity'] ?? 0 }}</span>
    </span>
    <div id="cart" class="info-cart">
        <div class="bg-cart">
            @if (!empty($cart_info['data']))
                <ul>
                    @if(!empty($cart_info['data']))
                        @foreach ($cart_info['data'] as $product)
                            <li class="cart-item" id="cart-item-{{ $cart_info['cart_id'] }}-{{ $product['product_id'] }}">
                                @if(!empty($product['product_image']))
                                    <img src="{!! $product['product_image'] ? asset('storage/'.$product['product_image']) : '' !!}" alt="image">
                                @endif
                                <div class="info">
                                    <p class="name"> {{ $product['product_name'] }}</p>
                                    <p class="price">{{ formatCurrency($product['product_price']) }}</p>
                                    <div>
                                        <div style="position: relative;">
                                            <button val-price="{{ $product['product_price'] }}" style="position: absolute; left: 0" class="btn btn-minus-item"
                                                onclick="minusProductCart(this)"><span
                                                    class="material-symbols-outlined">remove</span></button>
                                            <input class="cart-quantity" type="number" name="quantity" min="1" max="100"
                                                value="{{ $product['quantity'] }}" class="quantity" readonly>
                                            <button val-price="{{ $product['product_price'] }}" style="position: absolute; right: 0; top: 0" class="btn btn-plus-item"
                                                onclick="plusProductCart(this)">
                                                <span class="material-symbols-outlined">
                                                    add
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="quantity" style="width:80px">
                                    x {{ $product['quantity'] }}
                                </div>
                                <div>
                                    <button class="btn-remove-item" onclick="removeItem({{$product['product_id']}}, {{$cart_info['cart_id']}})">
                                        <span class="material-symbols-outlined">
                                            backspace
                                        </span>
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <div class="total-cart">
                    <div class="total">
                        <span class="fw-700">Tổng cộng</span>
                        <span id="cart-total-formatted" val-html="{{ $cart_info['total_price'] }}">{{ formatCurrency($cart_info['total_price']) }}</span>
                    </div>
                    <div class="btn-checkout">
                        <button class="btn btn-primary" onclick="window.location.href = '{{ route('checkout.page') }}'">Thanh toán</button>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <img src="{!! asset('assets/img/empty_cart.jpeg') !!}" alt="" style="max-width: 350px">
                    <p>Chưa có sản phẩm trong giỏ hàng</p>
                </div>
            @endif
        </div>
    </div>
    
    <style>
        .cart-quantity{
            width: 100%;
            border: 1px solid #ccc;
            text-align: center;
            height: 40px;
            border-radius: 5px;
        }
        .btn-cart {
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
            z-index: 3;
        }
    
        .cart-item .name {
            font-weight: bold
        }
    
        .btn-cart>span {
            position: relative;
            top: 5px;
        }
    
        .btn-cart>span {
            position: relative;
            top: 5px;
        }
    
        .btn-cart>span.count {
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
    
        .info-cart {
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
            z-index: 3;
        }
    
        .bg-cart {
            position: relative;
            height: 100%;
            width: 100%;
        }
    
        .info-cart.show-cart {
            right: 0%;
            visibility: visible;
        }
    
        .info-cart ul {
            list-style: none;
            overflow: auto;
            height: 100%;
            width: 100%;
            padding-left: 0;
            position: relative;
            overflow-y: auto;
        }
    
        .info-cart ul>li {
            display: flex;
            gap: 12px;
            margin-bottom: 10px;
            padding-top: 10px;
        }

        .info-cart ul>li + li{
            border-top: 1px solid #ccc;
        }
    
        .info-cart ul>li:last-child {
            margin-bottom: 70px
        }
    
        .info-cart ul>li img {
            width: 100px;
            max-height: 100px;
            border-radius: 8px;
            overflow: hidden;
            object-fit: cover;
        }
    
        .info-cart ul>li .info {
            flex: 1;
        }
    
        .info-cart ul>li .info p {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .info-cart ul>li .info p.price{
            font-weight: bold;
            color: #0d8ce5;
        }
    
        .cart-item {
            display: flex;
            gap: 10px;
        }
    
        .cart-item>img {
            width: 33%;
        }
    
        .cart-item>.info {
            flex: 1;
        }
    
        .cart-item .quantity {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
        }
    
        .info-cart li .btn-remove-item {
            display: flex;
            border: none;
            transition: all 0.4s ease;
        }
    
        .info-cart li .btn-remove-item>span {
            font-size: 18px;
            color: #737373;
        }
    
        .info-cart li .btn-remove-item:hover {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            background: #f74848;
        }
    
        .info-cart li .btn-remove-item:hover span {
            color: #fff;
        }
        .btn-minus-item, .btn-plus-item{
            position: absolute;
            padding: 0;
            height: 40px;
            border-radius: 8px;
            width: 40px;
        }
        .btn-minus-item{
            left: 0;
        }
        .btn-plus-item{
            right: 0;
        }
        .total-cart {
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
    
        #cart-total-formatted {
            margin: 0;
            font-weight: bold;
            color: #e61313;
        }
    </style>
    <script>
        function addToCart(id, button, quantity = 1) {
            button.disabled = true;
            button.textContent = 'Đang thêm...';
            $.ajax({
                url: "{{ route('ajax.cart.add') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'product_id': id,
                    'quantity': quantity,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        showAlert('success', data.message);
                        $('#cart *').remove();
                        const listProduct = data?.data?.list_product;
                        $('.btn-cart .count').text(data.data.total_quantity);
                        let productHTML = `<div class="bg-cart">
                                                <ul>`;
                        listProduct.forEach((product) => {
                            productHTML += `<li class="cart-item" id="cart-item-9-1">
                                <img src="${product.image}" alt="image">
                                <div class="info">
                                    <p class="name">${product.name}</p>
                                    <p class="price">${product.price} VND</p>
                                    <div>
                                        <div style="position: relative;">
                                            <button val-price="${product.price}" style="position: absolute; left: 0" class="btn btn-minus-item" onclick="minusProductCart(this)"><span class="material-symbols-outlined">remove</span></button>
                                            <input class="cart-quantity" type="number" name="quantity" min="1" max="100" value="${product.quantity}" readonly="">
                                            <button val-price="${product.price}" style="position: absolute; right: 0; top: 0" class="btn btn-plus-item" onclick="plusProductCart(this)">
                                                <span class="material-symbols-outlined">
                                                    add
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="quantity" style="width:80px">
                                    x ${product.quantity}
                                </div>
                                <div>
                                    <button class="btn-remove-item" onclick="removeItem(${ product.product_id }, ${data.data.cart_id})">
                                        <span class="material-symbols-outlined">
                                            backspace
                                        </span>
                                    </button>
                                </div>
                            </li>`;
                        });
                        productHTML += `
                            </ul>
                            <div class="total-cart">
                                <div class="total">
                                    <span class="fw-700">Tổng cộng</span>
                                    <span id="cart-total-formatted" val-html="${data.data.price_value}">${data.data.total_price}</span>
                                </div>
                                <div class="btn-checkout">
                                    <button class="btn btn-primary" onclick="window.location.href = '{{ route('checkout.page') }}'">Thanh toán</button>
                                </div>
                            </div>
                        </div>`;
                        $('#cart.info-cart').html(productHTML);
                    } else {
                        showAlert('error', data.message);
                    }
                },
                complete: function() {
                    button.disabled = false;
                    button.textContent = 'Thêm vào giỏ';
                }
            });
        }
    
        function removeItem(product_id, cart_id) {
            $.ajax({
                url: "{{ route('ajax.cart.remove') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'product_id': product_id,
                    'cart_id': cart_id,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#cart-item-'+cart_id+'-'+product_id).remove();
                        $('.btn-cart .count').text(data.total_cart);
                        if(parseInt(data.total_cart) == 0){
                            $('#cart.info-cart > .bg-cart').html(`<div class="text-center">
                                <img src="{!! asset('assets/img/empty_cart.jpeg') !!}" alt="" style="max-width: 350px">
                                <p>Chưa có sản phẩm trong giỏ hàng</p>
                            </div>`);
                        }
                    }
                }
            });
        }
        $(document).ready(function() {
            $('.btn-cart').on('click', function(e) {
                e.stopPropagation();
                $(this).fadeOut();
                $('#cart').addClass('show-cart');
                $(this).delay(1000).fadeIn();
            });
            $('.info-cart').on('click', function(e) {
                e.stopPropagation();
            });
            $('body').on('click', function() {
                $('.info-cart').removeClass('show-cart');
            });
        })
        function minusProductCart(element) {
            let minusBtn = $(element);
            let quantityInput = minusBtn.closest('.cart-item').find('.cart-quantity');
            let quantity = parseInt(quantityInput.val());   
            if (quantity > 1) {
                quantityInput.val(quantity - 1);
            }
            minusBtn.closest('.cart-item').find('.quantity').html('x ' + quantityInput.val());
            let price = minusBtn.attr('val-price');
            let total = $('#cart-total-formatted').attr('val-html'); // đang tính total
        }
        function plusProductCart(element) {
            let plusBtn = $(element);
            let quantityInput = plusBtn.closest('.cart-item').find('.cart-quantity');
            let quantity = parseInt(quantityInput.val());
            quantityInput.val(quantity + 1);
            plusBtn.closest('.cart-item').find('.quantity').html('x ' + quantityInput.val());
        }
    </script>    
@endsection
@section('js')
    <script>
        function filterCategory(id) {
            window.location.href = "{{ route('store.product') }}?category_id=" + id
        }
    </script>
@endsection