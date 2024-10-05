@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section tao-du-an mb-5 mt-5">
        <div class="loading-section">
            <div class="loading-wave">
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            </div>
        </div>
    </section>
    <section class="section section-wallet mb-5 mt-5">
        <div class="container">
            <div class="row">
                <!-- cot 1 -->
                    <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                        <div class="col-inner">
                        <h2 class="section-title mb-4">Dữ liệu chi tiết</h2>

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
                                    <th class="list-table-time" scope="col">Mã đơn</th>
                                    <th class="list-table-so-tien" scope="col">Nội dung đánh giá</th>
                                    <th class="list-table-content-3" scope="col">Rãi chậm</th>
                                    <th class="list-table-so-du" scope="col">Hình ảnh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($projects))
                                    @foreach($projects as $key => $project)
                                        <tr>
                                            <td class="list-table-stt" scope="col">{{ $key + 1 }}</td>
                                            <td class="list-table-time" scope="col">{{ $project_info->project_code }}</td>
                                            <td class="list-table-so-tien" scope="col">{{ $project->comment }}</td>
                                            <td class="list-table-content-3" scope="col">{{ $project_info->point_slow }}</td>
                                            <td class="list-table-so-du" scope="col">
                                                <span class="material-symbols-outlined">
                                                    wallpaper
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="list-table-footer d-flex justify-content-between align-items-center">
                            {{ $projects->links('vendor.pagination.custom') }}
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
                            <h3 class="wallet-number text-primary">1.000.000 VND</h3>
                            <div class="wallet-btn d-flex justify-content-around align-items-center  ">
                                <a class="btn btn-warning" href="#"><span class="material-symbols-outlined">add_card</span> Nạp thêm </a>
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
                            <label class="d-block" for="depositAmount">Số tiền nạp</span></label>

                            <div class="depositAmount-Row">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount1" value="100000" checked>
                                    <label class="form-check-label" for="depositAmount1"> 100.000 VND </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount2" value="200000" >
                                    <label class="form-check-label" for="depositAmount2"> 200.000 VND </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount3" value="500000" >
                                    <label class="form-check-label" for="depositAmount3"> 500.000 VND </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount4" value="1000000" >
                                    <label class="form-check-label" for="depositAmount4"> 1.000.000 VND </label>
                                </div>
                            </div>
                            
                            <input type="text" class="form-control" name="depositAmount" id="depositAmount5" placeholder="Số tiền khác" />
                            
                        </div>


                        <div class="mb-4 ">
                            <label for="payment-info">Thông tin thanh toán</label>
                        </div>
                        
                        <div class="mb-4 total d-flex justify-content-between align-items-center">
                            <label for="total" class="fw-700">Tổng cộng</label>
                            <h4>1,666,000 VND</h4>
                        </div>

                        <button type="button" id="btn-deposit" class="btn btn-primary btn-full" > Thanh toán </button>
                
                    </div>
                </div>
            </div>
            <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h2 class="modal-title d-block" id="depositModalLabel">Thanh toán</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <p class="text-center"><i style="color: #f00">(Tính năng đang phát triển)</i></p>
                        <div class="modal-body">
                            <div class="depositAmount mb-4">
                                <label class="d-block" for="depositAmount">Số tiền nạp</span></label>
                                <input type="text" readonly class="form-control" name="depositAmount" id="depositAmount5" placeholder="Số tiền khác" />
                            </div>
                            <div class="mb-4">
                                <label for="payment-info">Thống tin thanh toán</label>
                            </div>
                            <div class="mb-4 total d-flex justify-content-between align-items-center">
                                <label for="total" class="fw-700">Tổng cộng</label>
                                <h4>1,666,000 VND</h4>
                            </div>
                            <button type="button" id="btn-deposit" class="btn btn-primary btn-full" > Xác nhận </button>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#btn-deposit').on('click', function(){
                $('#depositModal').modal('show');
            });
        });
    </script>
@endsection