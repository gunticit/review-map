@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section section-wallet mb-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- cot 1 -->
                <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                    <h2 class="section-title mb-4">Lịch sử rút tiền</h2>

                    <form>
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                        </div>
                    </form>

                    <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-time" scope="col">Thời gian</th>
                            <th class="list-table-so-tien" scope="col">Mã giao dịch</th>
                            <th class="list-table-phuong-thuc" scope="col">Phương thức rút</th>
                            <th class="list-table-tai-khoan-nhan" scope="col">Tài khoản nhận</th>
                            <th class="list-table-so-tien-rut" scope="col">Số tiền rút</th>
                            <th class="list-table-trang-thai" scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($withdraws))
                            @foreach ($withdraws as $key => $withdraw)
                                <tr class="recharge">
                                    <td class="list-table-stt" scope="col">1</td>
                                    <td class="list-table-time" scope="col">24/05/2022 09:09</td>
                                    <td class="list-table-so-tien" scope="col">RIVI_RT_NV1_01</td>
                                    <td class="list-table-phuong-thuc" scope="col">MOMO</td>
                                    <td class="list-table-tai-khoan-nhan" scope="col">0123123123</td>
                                    <td class="list-table-so-tien-rut" scope="col">10.000.000 VND</td>
                                    <td class="list-table-trang-thai" scope="col"><span class="text-success">Thành công</span></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">Chưa có lịch sử rút tiền</td>
                            </tr>
                        @endif
                    </tbody>
                    </table>

                    <div class="list-table-footer d-flex justify-content-between align-items-center">
                        <div class="list-table-per-page">
                            <span class="form-label">Hiển thị kết quả</span>
                            <select
                                class="form-select d-inline-block"
                                name=""
                                id=""
                            >
                                <option selected>10</option>
                                <option value="">20</option>
                                <option value="">30</option>
                                <option value="">40</option>
                            </select>
                        </div>

                        <nav aria-label="Page navigation" >
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </a>
                                </li>
                                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    

                </div>
            </div>

            <!-- cot 2 -->
            <div class="col-xl-4 col-md-12 col-12 ">
                <div class="col-inner wallet-col">
                    <h2 class="section-title mb-4">Ví của tôi</h2>
                    <div class="wallet-card">
                        <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                        <p>Số dư của tôi</p>
                        <h3 class="wallet-number text-primary">0 VND</h3>
                        <div class="wallet-btn d-flex justify-content-around align-items-center  ">
                            <a class="btn btn-warning" href="#"><span class="material-symbols-outlined">add_card</span> Rút thêm </a>
                            <a class="btn btn-light" href="#"><span class="material-symbols-outlined">restart_alt</span> Làm mới </a>
                        </div>
                    </div>

                    <div class="mb-4 payment">
                        <label for="payment" class="form-label">Phương thức thanh toán</label>
                        <select class="form-select form-select-js" name="" id="payment" >
                            <option value="momo" selected>Thanh toán qua ví điện tử Momo</option>
                            <option value="vnpay">Quét mã VNPAY-QR</option>
                            <option value="atm">Thẻ ngân hàng ATM</option>
                            <option value="visa">Thẻ thanh toán quốc tế</option>
                        </select>
                    </div>

                    <!-- Form Group (Deposit Amount)-->
                    <div class="depositAmount mb-4">
                        <label class="d-block" for="depositAmount">Số tiền rút</span></label>
                        <input type="text" class="form-control" name="depositAmount" id="depositAmount5" placeholder="Số tiền khác" />
                        <div class="mt-3 form-check-inline">
                            <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount4" value="1000000" >
                            <label class="form-check-label" for="depositAmount4"> Rút toàn bộ </label>
                        </div>
                    </div>


                    <div class="mb-4 ">
                        <label for="payment-info">Thông tin thanh toán</label>
                    </div>
                    
                    <div class="mb-4 total d-flex justify-content-between align-items-center">
                        <label for="total" class="fw-700">Tổng cộng</label>
                        <h4>0 VND</h4>
                    </div>
                    <button type="submit"  class="btn btn-primary btn-full" > Rút tiền </button>
                </div>
            </div>
        </div>
        
    </div>
    </section>
@endsection