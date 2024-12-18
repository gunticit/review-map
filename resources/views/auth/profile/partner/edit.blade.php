@extends('layouts.app')

@section('content')
<style>
    .img-cccd{
        text-align: center;
        box-shadow: 5px 5px 15px #cbcbcb;
        border-radius: 8px;
        overflow: hidden;
    }
    .img-cccd img{
        width: 100%;
        object-fit: cover;
    }
</style>
<!-- tai khoan -->
<section class="accout mb-5 mt-5">
    <div class="container-fluid">
        <div class="row">
            <!-- cot 1 -->
            <div class="col-xl-6 col-md-12 col-12 mb-4 mb-xl-0">
                <form>
                    <div class="card">
                        <div class="card-header d-xl-flex justify-content-between align-items-center">
                            <h2 class="card-title">Thông tin cá nhân</h2>
                            <button class="btn btn-primary" id="btn-edit-info" type="button">Chỉnh sửa</button>
                            <button class="btn btn-outline-primary" id="btn-save-info" type="button">Lưu thông tin</button>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-4">
                                    <label for="inputUsername">Ảnh đại diện</label>
                                    <div class="position-relative">
                                        <img src="{{ $profile['avatar'] ?? asset('./assets/img/acount-img.svg') }}" id="avatar" onclick="document.getElementById('inputAvatar').click()" alt="account img">
                                        <a class="btn btn-primary position-absolute bottom-0 btn-edit-profile" href="#" role="button">
                                            <span class="material-symbols-outlined">border_color</span>
                                        </a>
                                        <input type="file" name="avatar" class="d-none" id="inputAvatar">
                                    </div>
                                    @if(!empty($levelDetails))
                                    <div class="info-level">
                                        <p>{{ __('Cấp độ') }}: {{ $levelDetails->name }}</p>
                                        <p>{{ __('Thời gian nhận task') }}: {{ $levelDetails->time_limit . __('giờ') }}</p>
                                        <p>{{ __('Trả thưởng') }}: {{ number_format($levelDetails->reward, 0) }} VND/task</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <!-- Form Group (username)-->
                                    <div class="mb-4">
                                        <label for="inputUsername">Họ và tên <span class="required">*</span>
                                        </label>
                                        <input class="form-control" id="inputUsername" type="text" value="{{ $profile['name'] }}" disabled>
                                    </div>
                                    <!-- Form Group (email address)-->
                                    <div class="mb-4">
                                        <label for="inputEmailAddress">Email <span class="required">*</span>
                                        </label>
                                        <input class="form-control form-control-lg" id="inputEmailAddress" type="email" value="{{ $profile['email'] }}" disabled>
                                    </div>
                                    <!-- Form Group (phone)-->
                                    <div class="mb-4">
                                        <label for="inputPhone">Số điện thoại <span class="required">*</span>
                                        </label>
                                        <input type="tel" class="form-control form-control-lg" id="telephone" name="telephone" placeholder="Số điện thoại" value="{{ $profile['telephone'] }}" disabled />
                                    </div>
                                    <!-- Form Group (country)-->
                                    <div class="mb-4">
                                        <label for="inputcountry">Quốc gia <span class="required">*</span>
                                        </label>
                                        <select class="form-control form-select form-select-lg" name="country_id" id="countryCode" disabled>
                                            <option value="">--- Chọn ---</option>
                                            <option {!! $profile['country_code'] == 'vi'? 'selected': '' !!} value="vi">Việt Nam</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- cot 2 -->
            <div class="col-xl-6 col-md-12 col-12 mb-4 mb-xl-0">
                <div class="card">
                    <div class="card-header d-xl-flex justify-content-between align-items-center">
                        <h2 class="card-title">Tài khoản nhận thưởng</h2>
                        <button class="btn btn-primary" id="btn-edit" type="button">Chỉnh sửa</button>
                        <button class="btn btn-outline-primary" id="btn-company" type="button">Lưu thông tin</button>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 payment">
                            <label for="payment" class="form-label">Phương thức thanh toán</label>
                            <select class="form-select form-select-js form-control" name="payment_method" id="payment_method" disabled>
                                <option value="">Lựa chọn</option>
                                <option value="momo" {!! !empty($accountPayment->payment_method) && old('payment_method', $accountPayment->payment_method) == 'momo' ? 'selected' : '' !!}>Thanh toán qua ví điện tử Momo</option>
                                <option value="bank" {!! !empty($accountPayment->payment_method) && old('payment_method', $accountPayment->payment_method) == 'bank' ? 'selected' : '' !!}>Chuyển khoản ngân hàng</option>
                                {{-- <option value="vnpay" {{ !empty($accountPayment->payment_method) && old('payment_method', $accountPayment->payment_method) == 'vnpay' ? 'selected' : '' }}>Quét mã VNPAY-QR</option>
                                <option value="atm" {{ !empty($accountPayment->payment_method) && old('payment_method', $accountPayment->payment_method) == 'atm' ? 'selected' : '' }}>Thẻ ngân hàng ATM</option>
                                <option value="visa" {{ !empty($accountPayment->payment_method) && old('payment_method', $accountPayment->payment_method) == 'visa' ? 'selected' : '' }}>Thẻ thanh toán quốc tế</option> --}}
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tax">Họ và tên</label>
                            <input class="form-control " id="account_name" name ="account_name" type="text" placeholder="Nguyen Van A" value="{{ $accountPayment->account_name ?? '' }}" disabled>
                        </div>
                        <div class="mb-4">
                            <label for="company_email">Số điện thoại
                            </label>
                            <input class="form-control mb-1" id="phone_number" type="text" name="phone_number" placeholder="0123456789" value="{{$accountPayment->phone_number ?? '' }}" disabled>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <label for="company_address">Tên ngân hàng </label>
                                <input class="form-control form-control-lg" id ="bank_name" name="bank_name" type="text" placeholder="VietCombank" value="{{$accountPayment->bank_name ?? '' }}" disabled>
                            </div>
                            <div class="col-7">
                                <label for="company_address">Số tài khoản </label>
                                <input class="form-control" id="account_number" name="account_number" type="text" placeholder="Số tài khoản" value="{{$accountPayment->account_number ?? '' }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($profile['contract']))
        <div class="card mt-4">
            <div class="card-header d-xl-flex justify-content-between align-items-center">
                <h2 class="card-title">Thông tin xác thực</h2>
                @if(!empty($profile->contract))
                <p>
                    <span class="material-symbols-outlined text-success">
                        bookmark_check
                    </span>
                    <span> Tài khoản đã xác thực</span></p>
                @endif
            </div>
            <div class="card-body">
                <div class="row my-2">
                    <div class="col-sm-2 d-none d-sm-block"></div>
                    <div class="col-sm-4 col-xs-12">
                        @if(!empty($profile['front_id_image']))
                            <div class="img-cccd mb-3">
                                <img src="{{ asset('storage/'.$profile['front_id_image']) }}" style="height: 400px" class="img-fluid" />
                            </div>
                            <h5 class="text-center mt-2 mb-4">Mặt trước CCCD</h5>
                        @endif
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        @if(!empty($profile['back_id_image']))
                            <div class="img-cccd mb-3">
                                <img src="{{ asset('storage/'.$profile['back_id_image']) }}" style="height: 400px" class="img-fluid" />
                            </div>
                            <h5 class="text-center mt-2 mb-4">Mặt sau CCCD</h5>
                        @endif
                    </div>
                    <div class="col-sm-2 d-none d-sm-block"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3 d-none d-sm-block"></div>
                    <div class="col-sm-6 col-xs-12">
                        @if(!empty($profile['contract']))
                        <embed
                            src="{{ asset('storage/'.$profile['contract']) }}#toolbar=0&navpanes=0&scrollbar=0"
                            type="application/pdf"
                            frameBorder="0"
                            scrolling="auto"
                            height="550px"
                            width="100%"
                        ></embed>
                        <h5 class="text-center mt-2 mb-4">Hợp đồng</h5>
                        <p class="text-center">
                            <a class="btn btn-primary px-4" href="{{ asset('storage/'.$profile['contract']) }}">
                                <span class="material-symbols-outlined">
                                    cloud_download
                                </span>
                                <span class="ml-2">Tải hợp đồng</span>
                            </a>
                        </p>
                        @endif
                    </div>
                    <div class="col-sm-3 d-none d-sm-block"></div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- end tai khoan -->
<script>
    $('body').on('click', '#btn-save-info', function(e) {
        e.preventDefault();
        const file = document.getElementById('inputAvatar').files[0];
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('avatar', file);
        formData.append('name', $('#inputUsername').val());
        formData.append('email', $('#inputEmailAddress').val());
        formData.append('telephone', $('#telephone').val());
        formData.append('country_code', $('#countryCode').val());
        $.ajax({
            url: '{{ route("profile.update") }}',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(res) {
                if(res.status){
                    showAlert('success',res.message);
                    $('#btn-save-info').hide();
                    $('#btn-edit-info').show();
                    $('input, select').attr('disabled', 'disabled');
                }else{
                    showAlert('error',res.message);
                }
            },
            error: function() {
            }
        })
    });
    document.getElementById('inputAvatar').addEventListener('change', function() {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            const imageData = event.target.result;
            const img = document.getElementById('avatar');
            img.src = imageData;
        };

        reader.readAsDataURL(file);
    });
    $('body').on('click', '#btn-company', function(e) {
        e.preventDefault();
        let formData = new FormData();
        let payment_method = $('#payment_method').val();
        let bank_name = (payment_method == 'bank') ? $('#bank_name').val() : '';
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('payment_method', payment_method);
        formData.append('account_name', $('#account_name').val());
        formData.append('phone_number', $('#phone_number').val());
        formData.append('account_number', $('#account_number').val());
        formData.append('bank_name', bank_name);
        $.ajax({
            url: '{{ route("profile.partner.update.payment", $profile['id']) }}',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(res) {
                if(res.status){
                    showAlert('success',res.message);
                    $('#btn-company').hide();
                    $('#btn-edit').show();
                    $('input, select').attr('disabled', 'disabled');
                }else{
                    showAlert('error',res.message);
                }
            },
            error: function() {
            }
        })
    })
    $('body #payment_method').on('change', function() {
        if ($(this).val() != 'bank') {
            $('#bank_name').attr('disabled', true);
            $('#bank_name').val('');
        }else{
            $('#bank_name').attr('disabled', false);
        }
    });
</script>
@endsection
