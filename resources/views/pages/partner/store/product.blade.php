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
                    'quantity': 1,
                },
                dataType: 'json',
                success: function(data) {
                    if(data.success){
                        showAlert('success',data.message);
                        $('#cart.info-cart').append(`<li class="cart-item">
                            <img src="https://doitac.rivi.com.vn/./assets/img/Rectangle-22794.jpg" alt="image">
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
                        </li>`);
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