@extends('layouts.app')
@section('css')
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
@endsection
@section('content')
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
                                    @if(!empty($product->images))
                                        @foreach ($product->images as $image)
                                            <a href="{{ $image->link_image }}"><img src="{!! asset('storage/'.$image->link_image) !!}" alt="{{$product->name}}"></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        
                            <!-- Thumbnail Slide -->
                            <div class="product-thumbs">
                                <div class="product-thumb-slide">
                                    @if(!empty($product->images))
                                        @foreach ($product->images as $image)
                                            <img src="{!! asset('storage/'.$image->link_image) !!}" alt="Thumbnail">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-xs-12">
                        <h1>{{ $product->name }}</h1>
                        <p class="price">{{ number_format($product->price) }} đ</p>
                        <div id="cart-box">
                            <button class="decrease-quantity">-</button>
                            <input type="number" id="quantity" value="1">
                            <button class="increase-quantity">+</button>
                            <button class="add-to-cart btn btn-primary">Mua ngay</button>
                        </div>
                        <div id="description">
                            {{ $product->description ?? ''}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
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
        window.location.href = "{{ route('cart.to.add') }}?product_id={{ $product->id }}&quantity=" + quantity;
    })
</script>
@endsection