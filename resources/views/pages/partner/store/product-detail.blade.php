@extends('layouts.app')
@section('css')
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
@endsection
@section('content')
    <style>
        .increase-quantity{
            right: 5px;
        }
        .decrease-quantity{
            left: 5px;
        }
        .increase-quantity,
        .decrease-quantity{
            position: absolute;
            top: 50%;
            width: 40px;
            height: 40px;
            transform: translateY(-50%);
            z-index: 2;
            background: #fff;
        }
        #description{
            background: #f1f1f1;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
    <div class="container">
        <div id="breadcrumb">
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5 col-xs-12">
                        <div class="product-gallery">
                            <!-- Main Slide (Display the selected image) -->
                            <div class="product-main">
                                <div class="product-main-slide">
                                    @if(!empty($product_info->images))
                                        @foreach ($product_info->images as $image)
                                            <a href="{{ $image->link_image }}"><img src="{!! asset('storage/'.$image->link_image) !!}" alt="{{$product_info->name}}"></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        
                            <!-- Thumbnail Slide -->
                            <div class="product-thumbs">
                                <div class="product-thumb-slide">
                                    @if(!empty($product_info->images))
                                        @foreach ($product_info->images as $image)
                                            <img src="{!! asset('storage/'.$image->link_image) !!}" alt="Thumbnail">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-xs-12">
                        <h1>{{ $product_info->name }}</h1>
                        <p class="price">{{ number_format($product_info->price) }} đ</p>
                        <div id="cart-box" style="display: flex; gap: 20px">
                            <div style="display: inline-block; position: relative">
                                <button class="btn decrease-quantity btn-outline-dark py-2 px-3">-</button>
                                <input type="number" class="form-control d-inline-block" style="width: 220px; text-align: center" readonly id="quantity" min="1" max="100" value="1">
                                <button class="btn increase-quantity btn-outline-dark py-2 px-3">+</button>
                            </div>
                            <button class="add-to-cart btn btn-primary flex-1" style="width: 250px">Mua ngay</button>
                        </div>
                        <div id="description">
                            {{ $product_info->description ?? ''}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="btn-cart">
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
    
<!-- Slick JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!-- Magnific Popup JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script>
    $(document).ready(function(){
        // Main Slide
        $('.product-main-slide').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            asNavFor: '.product-thumb-slide'
        });

        // Thumbnail Slide
        $('.product-thumb-slide').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.product-main-slide',
            dots: false,
            focusOnSelect: true
        });

        // Magnific Popup
        $('.product-main-slide').magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
    $('.decrease-quantity').on('click', function(){
        var quantity = $('#quantity').val();
        if(quantity > 1){
            quantity--;
            $('#quantity').val(quantity);
        }
    })
    $('.increase-quantity').on('click', function(){
        var quantity = $('#quantity').val();
        quantity++;
        $('#quantity').val(quantity);
    })
    $('.add-to-cart').on('click', function(){
        var quantity = $('#quantity').val();
        if(quantity < 1) quantity = 1;
        if(quantity > 100){
            $('#quantity').val(100);
            showAlert('error','Số lượng không được vượt quá 100');
        }
        addToCart({{ $product_info->id }}, this, quantity);
    });
</script>
@endsection