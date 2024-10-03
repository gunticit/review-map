@extends('layouts.app')
@section('content')
<section class="section edit-voucher mb-5">
    <div class="container">
        <h2 class="section-title">Sửa mã giảm giá</h2>
        <form action="{{ route('voucher.update', $voucher->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="code">Mã giảm giá</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ $voucher->code }}">
            </div>
            <div class="form-group">
                <label for="name">Tên mã</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $voucher->name }}">
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea class="form-control" id="description" name="description">{{ $voucher->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="discount_value">Số tiền giảm (%)</label>
                <input type="number" class="form-control" id="discount_value" name="discount_value" value="{{ $voucher->discount_value }}">
            </div>
            <div class="form-group">
                <label for="max_uses">Số lượng</label>
                <input type="number" class="form-control" id="max_uses" name="max_uses" value="{{ $voucher->max_uses }}">
            </div>
            <div class="form-group">
                <label for="start_date">Ngày bắt đầu</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $voucher->start_date }}">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</section>
@endsection
