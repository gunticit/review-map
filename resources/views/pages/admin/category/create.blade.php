@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('./assets/css/admin/category.css') }}">
@endsection

@section('content')
<!-- tao-du-an -->
<section class="section tao-du-an mb-5 mt-5">
    <div class="loading-section">
        <div class="loading-wave">
          <div class="loading-bar"></div>
          <div class="loading-bar"></div>
          <div class="loading-bar"></div>
          <div class="loading-bar"></div>
        </div>
    </div>
    <form action="{{ route('category.store') }}" id="form-create-project" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
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

@endsection

@section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5ad6bf3d69.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script src="{{ asset('./js/admin/category.js') }}"></script>
@endsection