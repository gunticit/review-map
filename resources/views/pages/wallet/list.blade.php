@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section section-wallet mb-5 mt-5">
        <div class="container-fluid">
            <div class="row">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <!-- cot 1 -->
                <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                        <h2 class="section-title mb-4">Dữ liệu chi tiết</h2>

                        <form>
                            <div class="input-group">
                                <button class="input-group-text" type="submit">
                                    <span class="material-symbols-outlined">search</span>
                                </button>
                                <input type="text" placeholder="Tìm kiếm" class="form-control" name="keyword" id="inputSearch">
                            </div>
                        </form>
                        <div class="group-table-list">
                            <table class="table list-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Thời gian</th>
                                        <th scope="col">Số tiền</th>
                                        <th scope="col">Nội dung</th>
                                        <th scope="col">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($transaction_histories))
                                        @foreach ($transaction_histories as $transaction_history)
                                            @php
                                                $text_color = $transaction_history->status ? 'text-success' : 'text-danger';
                                                $text_status = $transaction_history->status ? 'Thành công ' : 'Thất bại';
                                            @endphp
                                            <tr class="recharge">
                                                <td>{{ $transaction_history->reference_id }}</td>
                                                <td class="list-table-time">
                                                    <a
                                                        href="javascript:void(0);">{{ date('d/m/Y', strtotime($transaction_history->created_at)) }}</a>
                                                    <a
                                                        href="javascript:void(0);"><span>{{ date('H:i', strtotime($transaction_history->created_at)) }}</span></a>
                                                </td>
                                                <td class="list-table-so-tien {{ $text_color }}">
                                                    <a href="javascript:void(0)">{!! $transaction_history->type == 'deposit' ? '+' : '-' !!}
                                                        {{ formatCurrency($transaction_history->amount) }}</a>
                                                </td>
                                                <td class="list-table-content-3 {{ $text_color }}">
                                                    @if($transaction_history->type == 'deposit')
                                                        <span class="badge px-4 py-2 text-bg-success">Nạp tiền</span>
                                                    @elseif($transaction_history->type == 'payment')
                                                        <span class="badge px-4 py-2 text-bg-warning">Thanh toán</span>
                                                    @elseif($transaction_history->type == 'withdraw')
                                                        <span class="badge px-4 py-2 text-bg-danger">Rút tiền</span>
                                                    @endif
                                                </td>
                                                <td class="list-table-so-du {{ $text_color }}">
                                                    <a href="javascript:void(0)">{{ $text_status }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($transaction_histories)
                            {{ $transaction_histories->links('vendor.pagination.custom') }}
                        @endif
                    </div>
                </div>

                <!-- cot 2 -->
                <div class="col-xl-4 col-md-12 col-12 ">
                    <div class="col-inner wallet-col">
                        <h2 class="section-title mb-4">Ví của tôi</h2>
                        <div class="wallet-card">
                            <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                            <p>Số dư của tôi</p>
                            <h3 class="wallet-number text-primary">{{ formatCurrency($balance) }}</h3>
                            {{-- <div class="wallet-btn d-flex justify-content-around align-items-center  ">
                                <a class="btn btn-warning" href="javascript:void(0);"><span
                                        class="material-symbols-outlined">add_card</span> Nạp thêm </a>
                                <a class="btn btn-light" href="javascript:void(0);"><span
                                        class="material-symbols-outlined">restart_alt</span> Làm mới </a>
                            </div> --}}
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('wallet.setup') }}" id="form-setup-wallet" method="post">
                            {{ csrf_field() }}
                            <div class="mb-4 payment">
                                <label for="payment" class="form-label">Phương thức thanh toán</label>
                                <select class="form-select form-select-js" name="method_payment" id="payment">
                                    <option value="">Lựa chọn</option>
                                    <option value="momo" selected>Thanh toán qua ví điện tử Momo</option>
                                    <option value="onepay">Thanh toán qua Onepay</option>
                                    {{-- <option value="vnpay">Quét mã VNPAY-QR</option>
                                    <option value="atm">Thẻ ngân hàng ATM</option>
                                    <option value="visa">Thẻ thanh toán quốc tế</option> --}}
                                </select>
                            </div>

                            <!-- Deposit Amount Options -->
                            <div class="depositAmount mb-4">
                                <label class="d-block" for="depositAmount">Số tiền nạp</label>
                                <div class="depositAmount-Row">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="depositAmount"
                                            id="depositAmount1" value="100000" checked>
                                        <label class="form-check-label" for="depositAmount1"> 100.000 VND </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="depositAmount"
                                            id="depositAmount2" value="200000">
                                        <label class="form-check-label" for="depositAmount2"> 200.000 VND </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="depositAmount"
                                            id="depositAmount3" value="500000">
                                        <label class="form-check-label" for="depositAmount3"> 500.000 VND </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="depositAmount"
                                            id="depositAmount4" value="1000000">
                                        <label class="form-check-label" for="depositAmount4"> 1.000.000 VND </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="depositAmount"
                                            id="depositAmountOther" value="other">
                                        <label class="form-check-label" for="depositAmountOther"> Khác </label>
                                    </div>
                                </div>
                                <input type="text" class="form-control mt-3" name="depositAmountCustom"
                                    id="depositAmountCustom" value="0" placeholder="Số tiền khác" style="display:none;">
                                <p id="alert-amount-check" class="text-danger mt-2"></p>
                            </div>
                            <div class="mb-4 ">
                                <label for="payment-info">Thông tin thanh toán</label>
                            </div>

                            <!-- Total Amount -->
                            <div class="mb-4 total d-flex justify-content-between align-items-center">
                                <label for="total" class="fw-700">Tổng cộng</label>
                                <h4 id="totalAmount">0 VND</h4>
                            </div>

                            <button type="submit" id="btn-deposit" class="btn btn-primary btn-full"> Thanh toán </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#btn-deposit').on('click', function(e){
                e.stopPropagation();
                e.preventDefault();
                let depositAmount = $('input[name="depositAmount"]:checked').val();
                if(depositAmount == 'other'){
                    let depositAmountCustom = $('input[name="depositAmountCustom"]').val();
                    if(parseInt(depositAmountCustom) < 50000){
                        $('#depositAmountCustom').focus();
                        $('#depositAmountCustom').css('border', '1px solid red');
                        $('#alert-amount-check').text('Số tiền tối thiểu là 50.000 VND');
                        return;
                    }else{
                        $('#depositAmountCustom').css('border', '1px solid transparent');
                        $('#alert-amount-check').text('');
                    }
                }
                $('#form-setup-wallet').submit();
            });
        });
    </script>
    <!-- end danh-sach-du-an -->
@endsection
