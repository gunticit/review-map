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
        width: 140px;
        margin-left: 8px;
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
    <form action="{{ route('category.store') }}" id="form-create-project" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row">
                <!-- cot 1 -->
                <div class="col-xl-12 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                        <h2 class="section-title mb-4">Tạo danh mục</h2>
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
                            <label for="inputlist-table">Tên danh mục <span class="required">*</span>
                            </label>
                            <input class="form-control require" id="inputlist-table" name="name" type="text" placeholder="Tên danh mục" value="" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="inputlist-table">Thuộc danh mục <span>(nếu có)</span></label>
                            <select class="form-select form-control" name="parent" id="parent" data-placeholder="Thuộc danh mục"></select>
                        </div>
                        <div class="mb-4">
                            <label for="inputlist-table">Mô tả <span>(nếu có)</span></label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-4">
                            <label>Hình ảnh <span>(nếu có)</span></label>
                            <input class="form-control" id="image" name="image" type="file" placeholder="Hình ảnh" />
                        </div>
                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Thêm mới</button>
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
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="confirm-url-map">Xác nhận</button>
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
@endsection