@extends('layouts.app')
@section('content')
    <style>
        .color-grey {
            color: #718096;
        }
    </style>
    <!-- danh-sach-du-an -->
    <section class="section section-wallet mb-5 mt-5">
        @if ($errors->any())
            <div class="alert alert-danger fw-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger fw-400">
                {{ session('error') }}
            </div>
        @endif
        <div class="container-fluid">
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
                        @if(!empty($withdraws))
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
                                    @foreach ($withdraws as $key => $withdraw)
                                        <tr class="recharge">
                                            <td class="list-table-stt" scope="col">{{ $withdraw->id }}</td>
                                            <td class="list-table-time" scope="col">{{ date('d/m/Y H:i', strtotime($withdraw->created_at)) }}</td>
                                            <td class="list-table-so-tien" scope="col">{{ $withdraw->transaction_code ?? '' }}</td>
                                            <td class="list-table-phuong-thuc" scope="col">{{ $withdraw->payment_method->name ?? '' }}</td>
                                            <td class="list-table-tai-khoan-nhan" scope="col">{{ $withdraw->bank_number ?? '' }}</td>
                                            <td class="list-table-so-tien-rut" scope="col">{{ $withdraw->amount }} VND</td>
                                            <td class="list-table-trang-thai" scope="col">
                                                <span class="text-success">{{ $withdraw->status == 'pending' ? 'Đang xử lý' : ($withdraw->status == 'completed' ? 'Thành công' : 'Thất bại') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="list-table-footer d-flex justify-content-between align-items-center">
                                {{ $withdraws->links('vendor.pagination.custom') }}
                            </div>
                        @else
                            <div class="col-sm-12 mt-4">
                                <p class="text-center">Chưa có lịch sử rút tiền</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- cot 2 -->
                <div class="col-xl-4 col-md-12 col-12 ">
                    <div class="col-inner wallet-col">
                        <form action="{{ route('withdraw.wallet.store') }}" method="POST" id="form-withdraw">
                            {{ csrf_field() }}
                            <h2 class="section-title mb-4">Ví của tôi</h2>
                            <div class="wallet-card">
                                <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                                <p>Số dư của tôi</p>
                                <h3 class="wallet-number text-primary">{{ moneyFormat($balance) }} VND</h3>
                                {{-- <div class="wallet-btn d-flex justify-content-around align-items-center  ">
                                    <a class="btn btn-warning" href="#"><span
                                            class="material-symbols-outlined">add_card</span> Rút thêm </a>
                                    <a class="btn btn-light" href="#"><span
                                            class="material-symbols-outlined">restart_alt</span> Làm mới </a>
                                </div> --}}
                            </div>

                            <div class="mb-4 payment">
                                <label for="payment" class="form-label">Phương thức thanh toán</label>
                                <select class="form-select form-select-js" name="payment_method_id" id="payment">
                                    <option value="{{ \App\Enums\PaymentMethod::MOMO->value }}" selected>Thanh toán qua ví điện tử Momo</option>
                                    <option value="{{ \App\Enums\PaymentMethod::VNPAY->value }}">Quét mã VNPAY-QR</option>
                                    <option value="{{ \App\Enums\PaymentMethod::ATM->value }}">Thẻ ngân hàng ATM</option>
                                    <option value="{{ \App\Enums\PaymentMethod::VISA->value }}">Thẻ thanh toán quốc tế</option>
                                    <option value="{{ \App\Enums\PaymentMethod::VISA->value }}">Thẻ thanh toán quốc tế</option>
                                </select>
                            </div>

                            <!-- Form Group (Deposit Amount)-->
                            <div class="depositAmount mb-4">
                                <label class="d-block" for="amount">Số tiền rút</span></label>
                                <input type="text" class="form-control" name="amount" id="amount" placeholder="Số tiền khác" />
                                <div class="mt-3 form-check-inline">
                                    <input class="form-check-input" type="radio" name="all_amount" id="all_amount">
                                    <label class="form-check-label" for="all_amount"> Rút toàn bộ </label>
                                </div>
                            </div>
                            <div class="mb-4 ">
                                <label for="payment-info">Thông tin thanh toán</label>
                            </div>

                            <div class="mb-4 total d-flex justify-content-between align-items-center">
                                <label for="total" class="fw-700">Tổng cộng</label>
                                <h4>0 VND</h4>
                            </div>
                            <button type="submit" class="btn btn-primary btn-full" id="button-submit"> Rút tiền </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div class="modal fade" tabindex="-1" id="modalVerifyWallet">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('wallet.verify.create') }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header mt-4 pb-1">
                        <h5 class="modal-title text-center">Thông báo</h5>
                    </div>
                    <div class="modal-body text-center">
                        <p class="mb-0"><small class="color-grey">Bạn cần xác minh tài khoản để tiếp tục thực hiện</small></p>
                        <p class="mb-0"><small class="color-grey">thao tác Rút tiền. Bạn chỉ cần xác minh 1 lần duy nhất.</small></p>
                    </div>
                    <div class="modal-footer mb-4">
                        <button type="submit" class="btn btn-primary fw-500">Đến trang xác minh tài khoản</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const certificationAccount = @json($certificationAccount);
            if (!certificationAccount) {
                const modalVerifyWallet = new bootstrap.Modal('#modalVerifyWallet');
                modalVerifyWallet.show();
            }

            $('.button-submit').on('click', function(e){
                e.preventDefault();
                $('#form-withdraw').submit();
            });

        });
    </script>
@endsection
