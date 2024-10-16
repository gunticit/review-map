@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section section-wallet mb-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- cot 1 -->
                <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                    <h2 class="section-title mb-4">Dữ liệu chi tiết</h2>

                    <div class="input-group">
                        <button class="input-group-text" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                        <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                    </div>

                    <table class="table list-table">
                        <thead>
                            <tr>
                            <th class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-time" scope="col">Thời gian</th>
                            <th class="list-table-so-tien" scope="col">Số tiền</th>
                            <th class="list-table-content-3" scope="col">Nội dung</th>
                            <th class="list-table-so-du" scope="col">Số dư</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($transaction_histories))
                            @php $stt = 1; @endphp
                                @foreach ($transaction_histories as $transaction_history)
                                    <tr class="recharge">
                                        <td>{{$stt}}</td>
                                        <td class="list-table-time">
                                            <a href="javascript:void(0);">{{ date('d/m/Y H:i', strtotime($transaction_history->created_at)) }}</a> <a href="javascript:void(0);"></a>
                                        </td>
                                        <td class="list-table-so-tien"><a href="javascript:void(0)">{!! $transaction_history->type == 'deposit'?'+':'-'; !!} {{ formatCurrency($transaction_history->amount) }} VND</a>
                                        </td>
                                        <td class="list-table-content-3"><a href="javascript:void(0)">{!! $transaction_history->type == 'deposit'?'Nạp tiền':($transaction_history->type == 'payment'?'Thanh toán':'Rút tiền'); !!}</a></td>
                                        <td class="list-table-so-du">
                                            <a href="javascript:void(0)">{{ formatCurrency($transaction_history->temp_balance) }} VND</a>
                                        </td>
                                    </tr>
                                    @php $stt++; @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $transaction_histories->links('vendor.pagination.custom') }}
                </div>
            </div>

            <!-- cot 2 -->
            <div class="col-xl-4 col-md-12 col-12 ">
                <div class="col-inner wallet-col">
                    <h2 class="section-title mb-4">Ví của tôi</h2>
                    <div class="wallet-card">
                        <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                        <p>Số dư của tôi</p>
                        <h3 class="wallet-number text-primary">{{ $balance }}</h3>
                        <div class="wallet-btn d-flex justify-content-around align-items-center  ">
                            <a class="btn btn-warning" href="javascript:void(0);"><span class="material-symbols-outlined">add_card</span> Nạp thêm </a>
                            <a class="btn btn-light" href="{{ route('wallet') }}"><span class="material-symbols-outlined">restart_alt</span> Làm mới </a>
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
                    <form action="{{ route('wallet.deposit') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="depositAmount mb-4">
                            <label class="d-block" for="depositAmount">Số tiền nạp</span></label>
                            <div class="depositAmount-Row">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount1" value="100000" checked>
                                    <label class="form-check-label" for="depositAmount1"> 100.000 ₫ </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount2" value="200000" >
                                    <label class="form-check-label" for="depositAmount2"> 200.000 ₫ </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount3" value="500000" >
                                    <label class="form-check-label" for="depositAmount3"> 500.000 ₫ </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="depositAmount" id="depositAmount4" value="1000000" >
                                    <label class="form-check-label" for="depositAmount4"> 1.000.000 ₫ </label>
                                </div>
                            </div>
                            <input type="text" class="form-control" name="money" value="{{formatCurrency(100000, '₫')}}" id="depositAmount5" placeholder="Nhập số tiền muốn nạp" />
                        </div>


                        <div class="mb-4 ">
                            <label for="payment-info">Thông tin thanh toán</label>
                        </div>
                        
                        <div class="mb-4 total d-flex justify-content-between align-items-center">
                            <label for="total" class="fw-700">Tổng cộng</label>
                            <h4 id="confirm-money">100.000 ₫</h4>
                        </div>

                        <button type="submit"  class="btn btn-primary btn-full" > Thanh toán </button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    </section>

    <script src="{{ asset('js/helper/helper.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#depositAmount5').on('change', function(){
                $('input[name="depositAmount"]').prop('checked', false);
            })
            $('input[name="depositAmount"]').on('change', function(){
                if($('input[name="depositAmount"]:checked')){
                    let money = $(this).val();
                    money = formatCurrency(money, 'VND');
                    $('#depositAmount5').val(money);
                    $('#confirm-money').text(money);
                }
            })
        });
    </script>
@endsection