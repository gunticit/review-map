@extends('layouts.app')

@section('content')
<section class="section create-voucher mb-5 mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-12 mb-4 mb-xl-0">
                <div class="col-inner">
                    <h2 class="section-title mb-4">Tạo mã giảm giá</h2>

                    <!-- Hiển thị lỗi -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Form tạo mã giảm giá -->
                    <form action="{{ route('voucher.store') }}" id="form-create-voucher" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="mb-4">
                            <label for="code">Mã giảm giá <span class="required">*</span></label>
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-select form-control" id="codeSelect" name="codeSelect">
                                        <option value="0" {{ old('codeSelect') == '0' ? 'selected' : '' }}>Nhập thủ công</option>
                                        <option value="1" {{ old('codeSelect') == '1' ? 'selected' : '' }}>Tự động tạo mã</option>
                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <input class="form-control" id="codeInput" name="code" type="text" placeholder="Nhập mã giảm giá" value="{{ old('code') }}" required>
                                </div>
                            </div>
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <!-- Tên giảm giá -->
                        <div class="mb-4">
                            <label for="name">Tên giảm giá <span class="required">*</span></label>
                            <input class="form-control" name="name" type="text" placeholder="Nhập Tên"
                                value="{{ old('name') }}" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Mô tả -->
                        <div class="col-sm-12 mb-4">
                            <label for="description">Mô tả</label>
                            <textarea id="description" name="description" class="form-control"
                                placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <!-- Hình thức giảm giá -->
                            <div class="col-sm-4">
                                <label for="discount_type">Hình thức giảm</label>
                                <select name="discount_type" class="form-select form-control">
                                    <option value="percent" {{ old('discount_type')=='percent' ? 'selected' : '' }}>Giảm
                                        theo %</option>
                                    <option value="fixed" {{ old('discount_type')=='fixed' ? 'selected' : '' }}>Giảm theo số
                                        tiền</option>
                                </select>
                                @error('discount_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
    
                            <!-- Giá trị giảm -->
                            <div class="col-sm-8">
                                <label for="discount_value">Giá trị giảm <span class="required">*</span></label>
                                <input type="number" name="discount_value" class="form-control"
                                    value="{{ old('discount_value') }}" placeholder="Nhập giá trị giảm" required>
                                @error('discount_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Ngày bắt đầu -->
                            <div class="col-sm-6">
                                <label for="start_date">Ngày bắt đầu</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
    
                            <!-- Ngày kết thúc -->
                            <div class="col-sm-6">
                                <label for="end_date">Ngày kết thúc</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Số lượng voucher -->
                            <div class="col-sm-8">
                                <label for="max_uses">Số lượng voucher</label>
                                <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses') }}"
                                    placeholder="Nhập số lượng voucher">
                                @error('max_uses')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Giá trị tối thiểu đơn hàng -->
                            <div class="col-sm-4">
                                <label for="min_order_value">Giá trị tối thiểu đơn hàng</label>
                                <input type="number" name="min_order_value" class="form-control"
                                    value="{{ old('min_order_value') }}" placeholder="Nhập giá trị tối thiểu đơn hàng">
                                @error('min_order_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Nút thêm mới -->
                        <div class="mt-4">
                            <button class="btn btn-primary" type="submit">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{ asset('./js/admin/voucher.js') }}"></script>
@endsection