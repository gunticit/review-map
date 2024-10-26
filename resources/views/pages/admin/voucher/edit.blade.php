@extends('layouts.app')
@section('content')
<section class="section edit-voucher mb-5">
    <div class="container-fluid">
        <h2 class="section-title">Sửa mã giảm giá</h2>
        <div id="group-alert">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success') || session('error'))
                <script>
                    $('.alert').setTimeout(() => {
                        $('.alert').remove();
                    }, 5000);
                </script>
            @endif
        </div>
        <form action="{{ route('voucher.update', $voucher->id) }}" method="POST">
            {{ csrf_field() }}
            @method('PUT')
            
            <div class="mb-4">
                <label for="code">Mã giảm giá <span class="required">*</span></label>
                <div class="row">
                    <div class="col-sm-4">
                        <select class="form-select form-control" id="codeSelect" name="codeSelect">
                            <option value="0" {{ $voucher->code == '0' ? 'selected' : '' }}>Nhập thủ công</option>
                            <option value="1" {{ $voucher->code == '1' ? 'selected' : '' }}>Tự động tạo mã</option>
                        </select>
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" id="codeInput" name="code" type="text" placeholder="Nhập mã giảm giá" value="{{ $voucher->code }}" required>
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
                    value="{{$voucher->name}}" required>
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
                    placeholder="Nhập mô tả">{{ $voucher->description }}</textarea>
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
                        <option value="percent" {{ $voucher->discount_type =='percent' ? 'selected' : '' }}>Giảm
                            theo %</option>
                        <option value="fixed" {{ $voucher->discount_type =='fixed' ? 'selected' : '' }}>Giảm theo số
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
                        value="{{ $voucher->discount_value }}" placeholder="Nhập giá trị giảm" required>
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
                    <input type="date" name="start_date" class="form-control" value="{{ $voucher->start_date }}">
                    @error('start_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- Ngày kết thúc -->
                <div class="col-sm-6">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $voucher->end_date }}">
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
                    <input type="number" name="max_uses" class="form-control" value="{{ $voucher->max_uses }}"
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
                        value="{{ $voucher->min_order_value }}" placeholder="Nhập giá trị tối thiểu đơn hàng">
                    @error('min_order_value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group text-end mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</section>
@endsection
