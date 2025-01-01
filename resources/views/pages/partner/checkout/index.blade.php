@extends('layouts.app')
@section('content')
<style>
    #thank-you{
        display: none
    }
    .border-error{
        border: 1px solid #f00;
    }
</style>
<section class="section checkout-page mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="section-title">
                                <h2>Thông tin thanh toán</h2>
                            </div>
                            <div class="checkout-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Ho ten</label>
                                            <input type="text" class="form-control" id="name" placeholder="Ho ten">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone">So dien thoai</label>
                                            <input type="text" class="form-control" id="phone" placeholder="So dien thoai">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Dia chi</label>
                                            <input type="text" class="form-control" id="address" placeholder="Dia chi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title">
                                <h2>Thông tin người nhận</h2>
                            </div>
                            <div class="checkout-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Ho ten</label>
                                            <input type="text" class="form-control" id="name" placeholder="Ho ten">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone">So dien thoai</label>
                                            <input type="text" class="form-control" id="phone" placeholder="So dien thoai">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Dia chi</label>
                                            <input type="text" class="form-control" id="address" placeholder="Dia chi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="section-title">
                                <h2>Thông tin đơn hàng</h2>
                            </div>
                            <div class="checkout-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Ho ten</label>
                                            <input type="text" class="form-control" id="name" placeholder="Ho ten">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone">So dien thoai</label>
                                            <input type="text" class="form-control" id="phone" placeholder="So dien thoai">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Dia chi</label>
                                            <input type="text" class="form-control" id="address" placeholder="Dia chi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="section-title">
                                <input type="checkbox" id="check-confirm" /><label for="check-confirm">Tôi đã đọc và đồng ý với <a href="#">điều khoản</a> của chúng tôi</label>
                            </div>
                            <div class="d-block text-right w-100">
                                <button class="pull-right btn btn-success">
                                    Xác nhận đơn hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection