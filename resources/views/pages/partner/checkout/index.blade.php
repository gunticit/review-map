@extends('layouts.app')
@section('content')
<style>
    #thank-you{
        display: none
    }
    .border-error{
        border: 1px solid #f00;
    }
    .disabled{
        display: none
    }
    .font-weight-bold{
        font-weight: bold;
    }
    .has-error{
        color: #f00;
    }
</style>
<section class="section checkout-page mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('partner.checkout.store') }}" method="POST" id="form-partner-checkout" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-5">
                                {{ csrf_field() }}
                                <div class="section-title">
                                    <h2>Thông tin thanh toán</h2>
                                    <input class="hidden" type="hidden" name="cart_id" value="{{ $cart_info['id'] }}">
                                </div>
                                <div class="checkout-form" id="form-sender">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label for="name">Họ tên <span class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" value="{{ $user_info->name }}" id="send-name" placeholder="Họ tên">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" value="{{ $user_info->email }}" id="send-email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label for="phone">Số điện thoại <span class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" value="{{ $user_info->telephone }}" id="send-phone" placeholder="Số điện thoại">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label for="address">Địa chỉ <span class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" value="{{ $user_info->address }}" id="send-address" placeholder="Địa chỉ">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mt-2 mb-2">
                                                <input type="checkbox" id="btn-check-receiver" checked> <label for="btn-check-receiver">Thông tin người nhận giống người gửi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="disabled" id="form-receiver">
                                    <div class="section-title">
                                        <h2>Thông tin người nhận</h2>
                                    </div>
                                    <div class="checkout-form">
                                        <div class="row">
                                            <div class="col-md-12  mt-2">
                                                <div class="form-group">
                                                    <label for="name">Họ tên <span class="text-danger">(*)</span></label>
                                                    <input type="text" name="name" class="form-control" id="name" placeholder="Họ tên" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <label for="phone">Số điện thoại <span class="text-danger">(*)</span></label>
                                                    <input type="text" name="telephone" class="form-control" id="phone" placeholder="Số điện thoại" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <label for="address">Địa chỉ <span class="text-danger">(*)</span></label>
                                                    <input type="text" name="address" class="form-control" id="address" placeholder="Địa chỉ" required>
                                                </div>  
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
                                            @if(!empty($cart_info['products']))
                                            <div class="form-group table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Số</th>
                                                            <th>Tên sản phẩm</th>
                                                            <th>Hình ảnh</th>
                                                            <th>Giá</th>    
                                                            <th>Số lượng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($cart_info['products'] as $product)
                                                        <tr>
                                                            <td>{{ $product['id'] }}</td>
                                                            <td>{{ $product['name'] }}</td>
                                                            <td class="text-center"><img width="80" src="{{ asset('/storage/'.$product['images'][0]['link_image']) }}" alt="image" /></td>
                                                            <td>{{ formatVND($product['price'] ?? 0) }}</td>
                                                            <td><input style="max-width:100px" min="1" type="number" value="{{ $product['pivot']['quantity'] }}" id="quantity-{{ $product['id'] }}" class="form-control" /></td>
                                                        </tr>
                                                        @endforeach 
                                                    </tbody>
                                                </table>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" placeholder="Ghi chú (nếu có)"></textarea>
                                                    <p class="text-right font-weight-bold">
                                                        Tổng cộng: <span class="text-danger">{{ formatVND($cart_info['total']); }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" id="group-check-confirm">
                                <div class="section-title mt-2">
                                    <input type="checkbox" id="check-confirm" /><label for="check-confirm"> Tôi đã đọc và đồng ý với <a href="#">điều khoản</a> của chúng tôi</label>
                                </div>
                                <div class="d-block text-right w-100">
                                    <button type="button" class="pull-right btn btn-success" id="btn-checkout">
                                        Xác nhận đơn hàng
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('#btn-check-receiver').on('click', function() {
        if ($(this).is(':checked')) {
            $(this).prop('checked', true);
            $('#form-receiver').addClass('disabled');
            $('#name').val($('#send-name').val());
            $('#email').val($('#send-email').val());
            $('#phone').val($('#send-phone').val());
            $('#address').val($('#send-address').val());
        } else {
            $(this).prop('checked', false);
            $('#form-receiver').removeClass('disabled');
        }
    });
    $('#btn-checkout').on('click', function(e) {
        e.stopPropagation();
        if(!$('#check-confirm').is(':checked')) {
            $('#check-confirm').focus();
            $('#group-check-confirm').addClass('has-error');
            return;
        }else{
            $('#group-check-confirm').removeClass('has-error');
        }
        if($('#btn-check-receiver').is(':checked')) {
            let name = $('#send-name').val();
            let phone = $('#send-phone').val();
            let address = $('#send-address').val();
            if(!name) {
                $('#send-name').addClass('border-error');
                return;
            } else {
                $('#send-name').removeClass('border-error');
            }
            if(!phone) {
                $('#send-phone').addClass('border-error');
                return;
            } else {
                $('#send-phone').removeClass('border-error');
            }
            if(!address) {
                $('#send-address').addClass('border-error');
                return;
            } else {
                $('#send-address').removeClass('border-error');
            }
        }else{
            let name = $('#name').val();
            let phone = $('#phone').val();
            let address = $('#address').val();
            if(!name) {
                $('#send-name').addClass('border-error');
                return;
            } else {
                $('#send-name').removeClass('border-error');
            }
            if(!phone) {
                $('#send-phone').addClass('border-error');
                return;
            } else {
                $('#send-phone').removeClass('border-error');
            }
            if(!address) {
                $('#send-address').addClass('border-error');
                return;
            } else {
                $('#send-address').removeClass('border-error');
            }
        }
        $.ajax({
            url: "{{ route('partner.checkout.store') }}",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                recipient_name: name,
                recipient_phone: phone,
                shipping_address: address,
            },
            success: function(res) {
                if(res.status == 'success') {
                    window.location.href = res.data;
                }
            }
        })
    });
</script>
@endsection