@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5ad6bf3d69.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<style>
    #map{
        width: 100%;
        height: 530px;
    }
    .stars i {
        color: #ccc;
    }

    .stars i.filled {
        color: gold;
    }

    .stars i.half {
        background: linear-gradient(90deg, gold 50%, #ccc 50%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .row-coordinate{
        display: flex;
    }
    .relative{
        position: relative
    }
    .row-coordinate{
        position: absolute;
        top: 0;
        right: 0;
        direction: rtl;
        width: 220px;
        z-index: -1;
    }
    .row-coordinate.show{
        z-index: 1;
    }
    .rating-row{
        display: flex;
        gap: 12px
    }
    .map-info{
        position: relative
    }
    #detail-video{
        position: relative;
    }
    #detail-video .btn-play-video{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        background: transparent;
        border: none;
        display: none;
        transition: all ease .4s;
        opacity: 0;
        animation: showBtnVideo 1s ease forwards;
    }
    #detail-video:hover .btn-play-video{
        display: block;
    }
    #detail-video .btn-play-video span{
        font-size: 50px;
        color: #1b1b1b;
    }
    .Tagslist-wrap{
        display: flex;
        flex-wrap: wrap;
    }
    .Tagslist-wrap span {
        border-radius: 8px;
        background-color: #FAFAFA;
        color: #96A3BE;
        padding: 6px 8px;
        margin-right: 6px;
        margin-bottom: 6px;
        font-size: 12px;
        border:transparent 1px solid;
    }
    .Tagslist-wrap span.active, .Tagslist-wrap span:hover{
        background-color: #eaeaea;
        color: #3d3e3f;
        border: 1px solid #ccc;
    }
    .list-star{
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }
    .list-star p{
        margin-bottom: 0 !important;
    }
    .list-star svg{
        color: #cacaca;
    }
    .list-star svg.active{
        color: #ffa400
    }
    .tags-input-wrapper{
        background: transparent;
        background-color: #FAFAFA;
        border-radius: 8px;
        min-height: 54px;
        box-shadow: unset;
        line-height: 1.3;
        border: 1px solid transparent;
        width: 100%;
        padding: 0.875rem 1.125rem;
        font-size: 0.875rem;
    }
    .tags-input-wrapper input{
        border: none;
        background: transparent;
        outline: none;
        width: 250px;
        margin-left: 0;
    }
    .bs-popover-auto{
        z-index: 1;
    }
    .tags-input-wrapper .tag{
        display: inline-block;
        background-color: #FAFAFA;
        color: #000000;
        border-radius: 5px;
        padding: 2px 3px 2px 10px;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .tags-input-wrapper .tag a {
        margin: 0 7px;
        display: inline-block;
        cursor: pointer;
    }
        /* Đảm bảo ô search có z-index cao hơn modal */
    #search-places {
        position: relative;
        z-index: 1050; /* Số z-index cao hơn modal */
        right: 0;
        width: 80%;
    }

    /* Đảm bảo kết quả tìm kiếm không bị che mất */
    #map {
        position: relative;
        z-index: 1050; /* Số z-index cao hơn modal */
    }
    .pac-container{
        z-index: 9999;
    }
    #infowindow-content{
        text-align: center;
    }
    #infowindow-content p{
        margin-bottom: 5px;
    }
    #place-name{
        margin: 10px 0;
        text-align: center;
    }
    #info-map-reviews h3{
        margin-bottom: 5px;
    }
    #info-map-reviews p{
        margin-bottom: 5px;
    }
    .border-error{
        border: 1px solid #f00 !important;
    }
    .btn-check-map{
        background: #b0b0b0;
        color: #3c3b3b;
        border: transparent;
        cursor: pointer;
        transition: all ease .4s
    }
    .btn-check-map:hover{
        background: #c1c1c1;
        color: #3c3b3b;
    }
    .btn-check-map.border-error{
        border: 1px solid #f00;
        background: #f1f1f1;
    }
    @keyframes showBtnVideo{
        from{
            opacity: 0;
        }
        to{
            opacity: 1;
        }
    }
</style>
<!-- tao-du-an -->
<section class="section tao-du-an mb-5 mt-5">
    <form action="{{ route('product.update', ['product' => $product->id]) }}" id="form-create-product" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <!-- cot 1 -->
                <div class="col-xl-12 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                        <h2 class="section-title mb-4">Chỉnh sửa sản phẩm</h2>
                        <!-- Form Group (list-table)-->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-4"><!-- class: invalid -->
                            <div class="row">
                                <div class="col-sm-4" id="product-code-area">
                                    <label for="product-code">Mã sản phẩm <span class="required">*</span>
                                    </label>
                                    <input class="form-control require" id="product-code" name="product_code" type="text" placeholder="Mã sản phẩm" value="{{ $product->product_code }}" required>
                                    @error('product_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-8">
                                    <label for="product-name">Tên sản phẩm <span class="required">*</span>
                                    </label>
                                    <input class="form-control require" id="product-name" name="name" type="text" placeholder="Tên sản phẩm" value="{{ $product->name }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="inputlist-table">Thuộc danh mục <span>(nếu có)</span></label>
                            <select class="form-select form-control" name="category_id" id="category_id" data-placeholder="Thuộc danh mục">
                                <option value="">Chọn thuộc danh mục</option>
                                @if(!empty($categories))
                                    @foreach($categories as $category)
                                        <option {!! isset($product->category_id) && $category->id == $product->category_id ? 'selected' : '' !!} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="inputlist-table">Mô tả <span>(nếu có)</span></label>
                            <textarea id="description" placeholder="Mô tả sản phẩm" name="description" class="form-control">{{ $product->description }}</textarea>
                        </div>
                        <div class="mb-4 row">
                            <div class="col-sm-8">
                                <label for="inputlist-table">Giá sản phẩm</label>
                                <input class="form-control" id="price" name="price" type="number" placeholder="Giá sản phẩm" value="{{ $product->price }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="inputlist-table">Số lượng trong kho</label>
                                <input class="form-control" id="stock" name="stock" type="number" placeholder="Số lượng trong kho" value="{{ $product->stock }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label>Hình ảnh ( Gồm: Ảnh đầu tiên là ảnh đại diện và ảnh chi tiết)</label>
                            <label for="inputFile" class="custom-file-upload">
                                <span class="material-symbols-outlined">link</span> Tải hình lên
                            </label>
                            <input class="form-control" id="inputFile" name="image[]" type="file" placeholder="Hình ảnh" multiple />
                            <div id="fileError" class="alert alert-danger" style="display: none;">Tệp quá lớn hoặc không được hỗ trợ.</div>
                            <!-- Khu vực hiển thị tên tệp -->
                            <div id="fileList" class="mb-4 col-6"></div>
                        </div>
                        <div class="mb-4">
                            <button class="btn btn-primary" id="btn-submit" type="submit">Chỉnh sửa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<!-- end list-table -->
<!-- Modal Change Password -->
<div class="modal fade CheckUrl" id="CheckUrl" tabindex="-1" aria-labelledby="CheckUrlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="map-info">
                    <input id="search-places" placeholder="Nhập theo cú pháp: Cửa hàng + Địa chỉ" type="text" class="controls form-control" >
                    <div id="map"></div>
                    <div id="infowindow-content">
                        <h2 id="place-name" class="title"></h2>
                        <p id="place-address"></p>
                        <p id="place-telephone"></p>
                        <p id="place-rate"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">{{ __('common.text_button.close') }}</button>
                <button type="button" class="btn btn-primary" id="confirm-url-map">{{ __('common.text_button.confirm') }}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#parent').select2( {
        theme: 'bootstrap-5',
        ajax: {
            url: "{{ route('categories.list') }}",
            dataType: "json",
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    name: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                if(data.data.data && data.data.data.length > 0){
                    return {
                        results: $.map(data.data.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                            })
                    };
                }
                return {
                    results: [
                        {
                            text: 'Không có kết quả',
                            id: ''
                        }
                    ]
                }
            },
            results: function (data) {
                if(data.data.data && data.data.data.length > 0){
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
                return {
                    results: [
                        {
                            text: 'Không có kết quả',
                            id: ''
                        }
                    ]
                }
            }
        }
    } );
</script> 
<script>
    $(document).ready(function () {
        const getSelectedFiles = setupFileInput('#inputFile', '#fileList', '#fileError', 2);
        
        $('#inputFile').on('change', function () {
            const selectedFiles = getSelectedFiles(); // Get the array of selected files
            console.log('Currently selected files:', selectedFiles); // Log the files
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#product-code').on('change', function(){
            var product_code = $(this).val();
            $.ajax({
                url: "{{ route('product.check.code', ['product_code' => 'PRD_CODE']) }}".replace('PRD_CODE', product_code),
                method: "GET",
                data: {
                    product_code: product_code,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    if(!data.status){
                        $('#product-code').addClass('is-valid');
                        $('#product-code').removeClass('is-invalid');
                        $('#btn-submit').removeAttr('disabled');
                        $('#product-code-area .invalid-feedback').remove();
                    }else{
                        $('#product-code').addClass('is-invalid');
                        $('#product-code').removeClass('is-valid');
                        $('#btn-submit').attr('disabled','disabled');
                        $('#product-code-area').append(`<span class="invalid-feedback" role="alert">
                            <strong>Mã sản phẩm đã được sử dụng.</strong>
                        </span>`);
                    }
                }
            });
        })
    });
</script>
@endsection