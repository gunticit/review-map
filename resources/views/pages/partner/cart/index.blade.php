@extends('layouts.app')
@section('content')
<!-- danh-sach-du-an -->
<section class="section section-cart mt-5 mb-5">
  <div class="container-fluid">
    @if (($errors->any() && !$errors->has('error_voucher')) || session('error'))
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    @if ($error !== $errors->first('error_voucher'))
                        <li>{{ $error }}</li>
                    @endif
                @endforeach
                @if (session('error'))
                    <li>{{ session('error') }}</li>
                @endif
            </ul>
        </div>
    @endif
    <div class="row">
        <!-- cot 1 -->
            <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                <div class="col-inner">
                <h2 class="section-title mb-4">Giỏ hàng</h2>
                <table class="table align-middle">
                <thead>
                    <tr>
                    <th class="list-table-product" colspan="3">Sản phẩm</th>
                    <th class="list-table-price" >Đơn giá</th>
                    <th class="list-table-quantity">Số lượng</th>
                    <th class="list-table-subtotal">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cart->products->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">Giỏ hàng trống</td>
                        </tr>
                    @else
                        @foreach ($cart->products as $product)
                            <tr>
                                <td class="list-table-product-remove">
                                    <input type="hidden" id="product_id" value="{{ $product->id }}">
                                    <form action="{{ route('cart.delete.item') }}" method="POST">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-outline"><span class="material-symbols-outlined">cancel</span></button>
                                    </form>
                                </td>
                                <td class="list-table-product-img">
                                    <a href="4.1.chi-tiet-san-pham.php">
                                        <img src="{{ asset($product->image) }}" alt="Ảnh">
                                    </a>
                                </td>
                                <td class="list-table-product-title">
                                    <a href="4.1.chi-tiet-san-pham.php">{{ $product->name }}</a>
                                </td>
                                <td class="list-table-price">
                                    <div class="price">
                                        <span>{{ $product->price_formatted }}</span>
                                    </div>
                                </td>
                                <td class="list-table-quantity">
                                    <input type="hidden" name="quantity" value="1">
                                    <div class="quantity">
                                        <button type="button" id="cart-quantity-decrease">-</button>
                                        <input type="number" class="quantity-number" id="product_quantity" value="{{ $product->pivot->quantity }}" min="1"/>
                                        <button type="button" id="cart-quantity-increase">+</button>
                                    </div>
                                </td>
                                <td class="list-table-subtotal">
                                    {{ $product->subtotal_formatted }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                </table>

            </div>
        </div>

        

        <!-- cot 2 -->
        
        <div class="col-xl-4 col-md-12 col-12 ">
            <div class="col-inner wallet-col">
                <input type="hidden" id="cart_id" value="{{ $cart->id }}">
                <input type="hidden" id="cart_total" value="{{ $cart->total }}">
                <input type="hidden" id="cart_total_original" value="{{ $cart->total }}">
                <input type="hidden" id="voucher_id" value="">
            
                <h2 class="section-title mb-4">Thanh toán</h2>
                <div class="wallet-card">
                    <img src="img/rivi-logo.svg" alt="logo">
                    <p>Số dư của tôi</p>
                    <h3 class="wallet-number text-primary">{{ $wallet->balance_formatted }}</h3>
                </div>
                
                <div class="shipping">
                    <p>Địa chỉ nhận hàng</p>

                    <!-- ho va ten-->
                    <div class="mb-4 recipient_name">
                        <label for="recipient_name">Họ và tên <span class="required">*</span>
                        </label>
                        <input class="form-control" id="recipient_name" name="recipient_name" type="text" placeholder="Họ và tên người nhận" required value="{{ $user->name }}">
                        <p class="text-danger d-none">Vui lòng nhập họ và tên người nhận</p>
                    </div>


                    <!-- Form Group (recipient_phone)-->
                    <div class="mb-4 recipient_phone">
                        <label for="recipient_phone">Số điện thoại <span class="required">*</span>
                        </label>
                        <input type="tel" class="form-control form-control-lg" 
                            id="recipient_phone" name="recipient_phone" 
                            placeholder="Số điện thoại người nhận" required value="{{ $user->telephone }}"/>
                        <p class="text-danger d-none">Vui lòng nhập số điện thoại người nhận</p>
                    </div>

                    <!-- Form Group (shipping_address)-->
                    <div class="mb-4">
                        <label for="shipping_address">Địa chỉ <span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="shipping_address" name="shipping_address" placeholder="Địa chỉ nhận hàng">{{ $user->shipping_address }}</textarea>
                        <p class="text-danger d-none">Vui lòng nhập địa chỉ nhận hàng</p>
                    </div>

                </div>
                
                <div class="mb-4 discount">
                    <label for="voucher_code">Mã giảm giá</label>
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="text" class="form-control" id="voucher_code" name="voucher_code" placeholder="Nhập mã giảm giá" value="" aria-label="voucher_code" aria-describedby="voucher_code">
                        <button type="button" class="btn btn-outline-primary" id="cart-apply-voucher-btn">Áp dụng</button>
                    </div>
                    <small class="text-danger d-none" id="cart-apply-voucher-error">Mã giảm giá không hợp lệ</small>
                </div>

                <div class="mb-4 payment-info">
                    <label for="payment-info">Thống kê đơn hàng</label>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Phí giao hàng</td>
                                <td>15.000 VND</td>
                            </tr>
                            <tr class="text-warning d-none" id="cart-discount">
                                <td>Giảm giá</td>
                                <td>- 10.000 VND</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-4 total d-flex justify-content-between align-items-center">
                    <label for="total" class="fw-700">Tổng cộng</label>
                    <h4 id="cart-total-formatted">{{ $cart->total_formatted }}</h4>
                    <input type="hidden" name="total" value="{{ $cart->total }}">
                </div>

                <p class="text-danger d-none" id="order-store-error">Số dư tài khoản không đủ</p>

                <button type="submit" id="order-store-btn" class="btn btn-primary btn-full"> Thanh toán </button>
                </form>
            </div>
        </div>
    </div>
    
  </div>
</section>


<script>
    // Jquery
    jQuery(document).ready(function($){
        // quatity number
        // $('.add').click(function () {
        //     $(this).prev().val(+$(this).prev().val() + 1);
        // });

        // $('.sub').click(function () {
        //     if ($(this).next().val() > 1) {
        //         if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        //     }
        // });
        
        $('#cart-quantity-increase').click(function () {
            const productId = $('#product_id').val();
            const currentQuantity = $('#product_quantity').val();

            $.ajax({
                url: '{{ route("cart.update.quantity") }}',
                method: 'PATCH',
                data: {
                    id: productId,
                    quantity: 1,
                    action: 'increase',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                }
            });
        });

        $('#cart-quantity-decrease').click(function () {
            const productId = $('#product_id').val();
            const currentQuantity = $('#product_quantity').val();

            $.ajax({
                url: '{{ route("cart.update.quantity") }}',
                method: 'PATCH',
                data: {
                    id: productId,
                    quantity: 1,
                    action: 'decrease',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                }
            });
        });

        $('#product_quantity').on('change', function () {
            const productId = $('#product_id').val();
            let quantity = $(this).val();
            
            if (quantity < 1) quantity = 1;

            $.ajax({
                url: '{{ route("cart.update.quantity") }}',
                method: 'PATCH',
                data: {
                    id: productId,
                    quantity: quantity,
                    action: 'change',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                }
            });
        });

        $('#cart-apply-voucher-btn').click(function () {
            const voucherCode = $('#voucher_code');
            const cartTotal = $('#cart_total');
            const voucherId = $('#voucher_id');
            const cartTotalOriginal = $('#cart_total_original');

            $.ajax({
                url: '{{ route("cart.apply.voucher") }}',
                method: 'POST',
                data: {
                    voucher_code: voucherCode.val(),
                    total: cartTotal.val(),
                    total_original: cartTotalOriginal.val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        voucherId.val(response.voucher_id);
                        cartTotal.val(response.total_after_discount);
                        $('#cart-apply-voucher-error').addClass('d-none');
                        $('#cart-discount')
                            .html(`
                                <td>Giảm giá</td>
                                <td>- ${response.discount_formatted}</td>
                            `)
                            .removeClass('d-none');
                        $('#cart-total-formatted').text(response.total_after_discount_formatted);
                    } else {
                        voucherId.val('');
                        cartTotal.val(cartTotalOriginal.val());
                        $('#cart-discount').addClass('d-none');
                        $('#cart-apply-voucher-error').text(response.message).removeClass('d-none');
                        $('#cart-total-formatted').text(response.total_original_formatted);
                    }
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                }
            });
        });

        $('#order-store-btn').click(function () {
            $.ajax({
                url: '{{ route("order.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_id: $('#cart_id').val(),
                    voucher_id: $('#voucher_id').val(),
                    total: $('#cart_total').val(),
                    recipient_name: $('#recipient_name').val(),
                    recipient_phone: $('#recipient_phone').val(),
                    shipping_address: $('#shipping_address').val(),
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = '{{ route("store.product") }}';
                    } else {
                        if (response.validated == false) {
                            const fields = ['recipient_name', 'recipient_phone', 'shipping_address'];
                            const message = response.message;
                            for (const field of fields) {
                                $(`#${field}`).removeClass('is-invalid');
                                $(`#${field}`).next().text('');
                                $(`#${field}`).next().addClass('d-none');
                            }
                            for (const key in message) {
                                if (fields.includes(key)) {
                                    $(`#${key}`).addClass('is-invalid');
                                    $(`#${key}`).next().text(message[key]);
                                    $(`#${key}`).next().removeClass('d-none');
                                }
                            }
                        } else {
                            $('#order-store-error').text(response.message).removeClass('d-none');
                        }
                    }
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                }
            });
        });
    });

</script>
@endsection