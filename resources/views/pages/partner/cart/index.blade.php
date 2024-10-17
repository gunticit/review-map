@extends('layouts.app')
@section('content')
<!-- danh-sach-du-an -->
<section class="section section-cart mt-5 mb-5">
  <div class="container">
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
    {{-- @php
        echo "<pre>";
        var_dump($errors->all());
        var_dump(session()->all());
        echo "</pre>";
    @endphp --}}
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
                                    <form action="{{ route('cart.delete.item') }}" method="POST">
                                        @csrf
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
                                    <form action="{{ route('cart.update.quantity') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <div class="quantity">
                                            <button type="submit" name="action" value="decrease" class="sub">-</button>
                                            <input type="number" class="quantity-number" value="{{ $product->pivot->quantity }}" min="1"/>
                                            <button type="submit" name="action" value="increase" class="add">+</button>
                                        </div>
                                    </form>
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
                <h2 class="section-title mb-4">Thanh toán</h2>
                <div class="wallet-card">
                    <img src="img/rivi-logo.svg" alt="logo">
                    <p>Số dư của tôi</p>
                    <h3 class="wallet-number text-primary">{{ $wallet->balance_formatted }}</h3>
                </div>
                
                <div class="shipping">
                    <p>Địa chỉ nhận hàng</p>

                    <!-- ho va ten-->
                    <div class="mb-4 inputUsername">
                        <label for="inputUsername">Họ và tên <span class="required">*</span>
                        </label>
                        <input class="form-control" id="inputUsername" type="text" placeholder="Họ và tên người nhận" required value="{{ $user->name }}">
                    </div>


                    <!-- Form Group (phoneNumber)-->
                    <div class="mb-4 phoneNumber">
                        <label for="phoneNumber">Số điện thoại <span class="required">*</span>
                        </label>
                        <input type="tel" class="form-control form-control-lg" 
                            id="phoneNumber" name="phoneNumber" 
                            placeholder="Số điện thoại người nhận" required value="{{ $user->telephone }}" />
                    </div>

                    <!-- Form Group (address)-->
                    <div class="mb-4">
                        <label for="address">Địa chỉ <span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="address" placeholder="Địa chỉ nhận hàng"></textarea>
                    </div>

                </div>
                
                <div class="mb-4 discount">
                    <form action="{{ route('cart.apply.voucher') }}" method="POST">
                        @csrf
                        <label for="voucher">Mã giảm giá</label>
                        <div class="d-flex justify-content-center align-items-center">
                            <input type="text" class="form-control" id="voucher" name="voucher" placeholder="Nhập mã giảm giá" value="{{ old('voucher') }}" aria-label="voucher" aria-describedby="voucher">
                            <input type="hidden" name="total" value="{{ $cart->total }}">
                            <button type="submit" class="btn btn-outline-primary" >Áp dụng</button>
                        </div>
                        @error('error_voucher')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </form>
                </div>

                <div class="mb-4 payment-info">
                    <label for="payment-info">Thống kê đơn hàng</label>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Phí giao hàng</td>
                                <td>15.000 VND</td>
                            </tr>
                            @if (session('voucher_applied'))
                                <tr class="text-warning">
                                    <td>Giảm giá</td>
                                    <td>- {{ $cart->discount_formatted }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-4 total d-flex justify-content-between align-items-center">
                    <label for="total" class="fw-700">Tổng cộng</label>
                    <h4>{{ $cart->total_formatted }}</h4>
                </div>

                <button type="submit"  class="btn btn-primary btn-full" > Thanh toán </button>
                


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


    });

</script>
@endsection
