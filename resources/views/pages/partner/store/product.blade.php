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
                    @if (!empty($products))
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
                                        <span>{{ formatCurrency($product->price) }} VND</span>
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
@section('js')
    <script>
        function filterCategory(id) {
            window.location.href = "{{ route('store.product') }}?category_id=" + id
        }
    </script>
@endsection