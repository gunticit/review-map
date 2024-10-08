@extends('layouts.app')
@section('content')
<!-- danh-sach-du-an -->
<section class="section section-cart mt-5 mb-5">
  <div class="container">
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
                    <tr>
                        <td class="list-table-product-remove">
                            <a href="#"><span class="material-symbols-outlined">cancel</span></a>
                        </td>
                        <td class="list-table-product-img">
                            <a href="4.1.chi-tiet-san-pham.php"><img src="assets/image-54.jpg" alt=""></a>
                        </td>
                        <td class="list-table-product-title">
                            <a href="4.1.chi-tiet-san-pham.php">Lacus suspendisse faucibus interdum</a>
                            <div class="d-flex justify-content-between align-items-center d-block d-md-none">
                                <div class="price">
                                    <span>100.000 VND</span>
                                    <del>200.000 VND</del>
                                </div>
                                <div class="quantity" >
                                    <button type="button" class="sub">-</button>
                                    <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                    <button type="button" class="add">+</button>
                                </div>
                            </div>
                        </td>
                        <td class="list-table-price">
                            <div class="price">
                                <span>100.000 VND</span>
                                <del>100.000 VND</del>
                            </div>
                        </td>
                        <td class="list-table-quantity">
                            <div class="quantity" >
                                <button type="button" class="sub">-</button>
                                <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                <button type="button" class="add">+</button>
                            </div>
                        </td>
                        <td class="list-table-subtotal">100.000 VND</td>
                    </tr>
                    
                    <tr>
                        <td class="list-table-product-remove">
                            <a href="#"><span class="material-symbols-outlined">cancel</span></a>
                        </td>
                        <td class="list-table-product-img">
                            <a href="4.1.chi-tiet-san-pham.php"><img src="assets/image-54.jpg" alt=""></a>
                        </td>
                        <td class="list-table-product-title">
                            <a href="4.1.chi-tiet-san-pham.php">Lacus suspendisse faucibus interdum</a>
                            <div class="d-flex justify-content-between align-items-center d-block d-md-none">
                                <div class="price">
                                    <span>100.000 VND</span>
                                </div>
                                <div class="quantity" >
                                    <button type="button" class="sub">-</button>
                                    <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                    <button type="button" class="add">+</button>
                                </div>
                            </div>
                        </td>
                        <td class="list-table-price">
                            <div class="price">
                                <span>100.000 VND</span>
                                <!-- <del>100.000 VND</del> -->
                            </div>
                        </td>
                        <td class="list-table-quantity">
                            <div class="quantity" >
                                <button type="button" class="sub">-</button>
                                <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                <button type="button" class="add">+</button>
                            </div>
                        </td>
                        <td class="list-table-subtotal">100.000 VND</td>
                    </tr>
                    
                    <tr>
                        <td class="list-table-product-remove">
                            <a href="#"><span class="material-symbols-outlined">cancel</span></a>
                        </td>
                        <td class="list-table-product-img">
                            <a href="4.1.chi-tiet-san-pham.php"><img src="assets/image-54.jpg" alt=""></a>
                        </td>
                        <td class="list-table-product-title">
                            <a href="4.1.chi-tiet-san-pham.php">Lacus suspendisse faucibus interdum</a>
                            <div class="d-flex justify-content-between align-items-center d-block d-md-none">
                                <div class="price">
                                    <span>100.000 VND</span>
                                </div>
                                <div class="quantity" >
                                    <button type="button" class="sub">-</button>
                                    <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                    <button type="button" class="add">+</button>
                                </div>
                            </div>
                        </td>
                        <td class="list-table-price">
                            <div class="price">
                                <span>100.000 VND</span>
                                <!-- <del>100.000 VND</del> -->
                            </div>
                        </td>
                        <td class="list-table-quantity">
                            <div class="quantity" >
                                <button type="button" class="sub">-</button>
                                <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                <button type="button" class="add">+</button>
                            </div>
                        </td>
                        <td class="list-table-subtotal">100.000 VND</td>
                    </tr>
                    
                    <tr>
                        <td class="list-table-product-remove">
                            <a href="#"><span class="material-symbols-outlined">cancel</span></a>
                        </td>
                        <td class="list-table-product-img">
                            <a href="4.1.chi-tiet-san-pham.php"><img src="assets/image-54.jpg" alt=""></a>
                        </td>
                        <td class="list-table-product-title">
                            <a href="4.1.chi-tiet-san-pham.php">Lacus suspendisse faucibus interdum</a>
                            <div class="d-flex justify-content-between align-items-center d-block d-md-none">
                                <div class="price">
                                    <span>100.000 VND</span>
                                </div>
                                <div class="quantity" >
                                    <button type="button" class="sub">-</button>
                                    <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                    <button type="button" class="add">+</button>
                                </div>
                            </div>
                        </td>
                        <td class="list-table-price">
                            <div class="price">
                                <span>100.000 VND</span>
                                <!-- <del>100.000 VND</del> -->
                            </div>
                        </td>
                        <td class="list-table-quantity">
                            <div class="quantity" >
                                <button type="button" class="sub">-</button>
                                <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                <button type="button" class="add">+</button>
                            </div>
                        </td>
                        <td class="list-table-subtotal">100.000 VND</td>
                    </tr>
                    

                    <tr>
                        <td class="list-table-product-remove">
                            <a href="#"><span class="material-symbols-outlined">cancel</span></a>
                        </td>
                        <td class="list-table-product-img">
                            <a href="4.1.chi-tiet-san-pham.php"><img src="assets/image-54.jpg" alt=""></a>
                        </td>
                        <td class="list-table-product-title">
                            <a href="4.1.chi-tiet-san-pham.php">Lacus suspendisse faucibus interdum</a>
                            <div class="d-flex justify-content-between align-items-center d-block d-md-none">
                                <div class="price">
                                    <span>100.000 VND</span>
                                </div>
                                <div class="quantity" >
                                    <button type="button" class="sub">-</button>
                                    <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                    <button type="button" class="add">+</button>
                                </div>
                            </div>
                        </td>
                        <td class="list-table-price">
                            <div class="price">
                                <span>100.000 VND</span>
                                <!-- <del>100.000 VND</del> -->
                            </div>
                        </td>
                        <td class="list-table-quantity">
                            <div class="quantity" >
                                <button type="button" class="sub">-</button>
                                <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                <button type="button" class="add">+</button>
                            </div>
                        </td>
                        <td class="list-table-subtotal">100.000 VND</td>
                    </tr>
                    

                    <tr>
                        <td class="list-table-product-remove">
                            <a href="#"><span class="material-symbols-outlined">cancel</span></a>
                        </td>
                        <td class="list-table-product-img">
                            <a href="4.1.chi-tiet-san-pham.php"><img src="assets/image-54.jpg" alt=""></a>
                        </td>
                        <td class="list-table-product-title">
                            <a href="4.1.chi-tiet-san-pham.php">Lacus suspendisse faucibus interdum</a>
                            <div class="d-flex justify-content-between align-items-center d-block d-md-none">
                                <div class="price">
                                    <span>100.000 VND</span>
                                </div>
                                <div class="quantity" >
                                    <button type="button" class="sub">-</button>
                                    <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                    <button type="button" class="add">+</button>
                                </div>
                            </div>
                        </td>
                        <td class="list-table-price">
                            <div class="price">
                                <span>100.000 VND</span>
                                <!-- <del>100.000 VND</del> -->
                            </div>
                        </td>
                        <td class="list-table-quantity">
                            <div class="quantity" >
                                <button type="button" class="sub">-</button>
                                <input type="number" class="quantity-number" name="quantity" value="1" min="1"/>
                                <button type="button" class="add">+</button>
                            </div>
                        </td>
                        <td class="list-table-subtotal">100.000 VND</td>
                    </tr>
                    


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
                    <h3 class="wallet-number text-primary">1.000.000 VND</h3>
                </div>
                
                <div class="shipping">
                    <p>Địa chỉ nhận hàng</p>

                    <!-- ho va ten-->
                    <div class="mb-4 inputUsername">
                        <label for="inputUsername">Họ và tên <span class="required">*</span>
                        </label>
                        <input class="form-control" id="inputUsername" type="text" placeholder="Họ và tên người nhận" required>
                    </div>


                    <!-- Form Group (phoneNumber)-->
                    <div class="mb-4 phoneNumber">
                        <label for="phoneNumber">Số điện thoại <span class="required">*</span>
                        </label>
                        <input type="tel" class="form-control form-control-lg" 
                            id="phoneNumber" name="phoneNumber" 
                            placeholder="Số điện thoại người nhận" required />
                    </div>

                    <!-- Form Group (address)-->
                    <div class="mb-4">
                        <label for="address">Địa chỉ <span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="address" placeholder="Địa chỉ nhận hàng"></textarea>
                    </div>

                </div>
                
                <div class="mb-4 discount">
                    <label for="discount">Mã giảm giá</label>
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="text" class="form-control" id="discount" placeholder="Nhập mã giảm giá" value="RIVIWELCOME" aria-label="discount" aria-describedby="discount">
                        <button type="button" class="btn btn-outline-primary" >Áp dụng</button>
                    </div>
                </div>

                <div class="mb-4 payment-info">
                    <label for="payment-info">Thống kê đơn hàng</label>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Phí giao hàng</td>
                                <td>15.000 VND</td>
                            </tr>
                            <tr class="text-warning">
                                <td>Giảm giá</td>
                                <td>- 50.000 VND</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-4 total d-flex justify-content-between align-items-center">
                    <label for="total" class="fw-700">Tổng cộng</label>
                    <h4>1,666,000 VND</h4>
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
        $('.add').click(function () {
            $(this).prev().val(+$(this).prev().val() + 1);
        });

        $('.sub').click(function () {
            if ($(this).next().val() > 1) {
                if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
            }
        });


    });

</script>
@endsection