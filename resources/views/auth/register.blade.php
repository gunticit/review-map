@extends('layouts.app')

@section('content')
<style>
    #layoutSidenav #layoutSidenav_content{
        padding-left: 0 !important;
        top: 0 !important;
    }
    .login .img-fluid{
        height: 100%;
        object-fit: cover;
    }
    .alert ul, .alert ul li:last-child{
        margin-bottom: 0;
    }
</style>
<section class="login">
    <div class="row">
        <div class="col-xl-6 col-md-12 col-12">
            <div class="login-wrap">
                <div class="logo">
                    <a href="#">
                        <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="login">
                    </a>
                </div>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="login-form text-center">
                    <h1>{{ __('auth.register') }}</h1>
                    <form method="POST" action="{{ route('auth.registerUser') }}">
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <input id="FullName" placeholder="{{ __('auth.full_name') }}" required type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control" id="phone" name="telephone" placeholder="{{ __('auth.telephone') }}" required />
                            @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="InputEmail" placeholder="{{ __('auth.email') }}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="new_password" type="password" placeholder="{{ __('auth.password') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password-confirm" type="password" placeholder="{{ __('auth.re-password') }}" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">{!! __('auth.terms_and_policy', ['url' => route('terms')]) !!} </label>
                            </div>
                        </div>
                        <input type="hidden" name="role_id" value="2">
                        <input type="hidden" name="permission_id" value="1">
                        <button type="submit" class="btn btn-primary">{{ __('auth.register') }}</button>
                    </form>
                    <div class="login-other">
                        <span>{{ __('auth.login_with') }}</span>
                    </div>
                    <a href="#" class="btn btn-outline-secondary login-with-google">
                        <img src="{{ asset('./assets/img/google-logo.svg') }}" alt="google"> Google </a>
                    <div class="login-link-acount">
                        <span>{{ __('auth.already_have_account') }} </span>
                        <a href="{{ route('login') }}" class="btn-link">{{ __('auth.login') }}</a>
                    </div>
                </div>
                <!-- end login-form -->
                <div class="login-footer">
                    <nav class="navbar navbar-expand">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Điều khoản & Điều kiện</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Chính sách bảo mật</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Trợ giúp</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> English </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{!! route('user.language', ['en']) !!}">English</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{!! route('user.language', ['vi']) !!}">{{ __('auth.vietnamese') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <div class="copy-right text-center">@ 2024 RIVI. All Right Reserved. </div>
                </div>
                <!-- end login-footer -->
            </div>
        </div>
        <div class="col-xl-6 col-md-12 col-12 d-none d-lg-block d-xl-block">
            <img src="{{ asset('./assets/img/r3R0Sr5b8l4vd6rXD2.jpg') }}" class="img-fluid" alt="login">
        </div>
    </div>
</section>
</div>
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Xác thực danh tính</button> -->
<!-- Modal -->
<div class="modal fade " id="verifyModel" tabindex="-1" aria-labelledby="verifyModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-register">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title ">
                    <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="regForm">
                    <div class="tab">
                        <form id="emailForm" action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
                        <h2>Xác thực danh tính</h2>
                        <p>Vui lòng chọn phương thức nhận liên kết thay đổi mật khẩu.</p>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="regFormRadio" id="regFormSms" disabled>
                            <label class="form-check-label" for="regFormSms"> 
                                Nhận mã bằng (SMS) tại: 
                                <span id="smsNumber"></span>
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="regFormRadio" id="regFormEmail" checked>
                            <label class="form-check-label" for="regFormEmail"> 
                                Nhận mã qua email tại: 
                                <span id="emailAddress"></span>
                                <input type="hidden" class="form-control" id="emailOtp" name="email" placeholder="Email" value="" required />
                            </label>
                        </div>
                    </form>
                    </div>
                    <!-- Bước 2: Nhập mã OTP -->
                    <div class="tab">
                        <h2>Nhập mã xác thực</h2>
                        <form id="otpForm" action="{{ route('password.otp') }}" method="POST">
                            @csrf
                            <p id="otpMessage"></p>
                            <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
                            <input type="hidden" class="form-control" id="emailOtp2" name="email" placeholder="Email" value="" required />
                            <input type="hidden" class="form-control" id="otpAttempts" name="otp_attempts" value="0"/>    
                            <div class="d-flex form-check-number">
                                    <div class="p-2">
                                        <input type="number" class="form-control" name="otp[]" id="otp1"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                    </div>
                                    <div class="p-2">
                                        <input type="number" class="form-control" name="otp[]" id="otp2"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                    </div>
                                    <div class="p-2">
                                        <input type="number" class="form-control" name="otp[]" id="otp3"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                    </div>
                                    <div class="p-2">
                                        <input type="number" class="form-control" name="otp[]" id="otp4"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                    </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab">
                        <h2>Thành công!</h2>
                        <p>Chúc mừng! Bạn đã xác thực thành công. Đăng nhập ngay thôi!!</p>
                        <div class="text-center">
                            <button class="btn btn-primary">
                                <a href="{{route('login')}}" class="text-white">Đi tới trang đăng nhập</a>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="nextBtnRegister" type="submit" class="btn btn-primary">
                            <!-- Loading Message -->
                        <div id="loadingMessage" style="display:none;" class="text-center">
                            <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                         <span id="buttonText">Tiếp tục</span>
                    </button>
                    </div>
                    <!-- Circles which indicates the steps of the form: -->
                    <div class="d-none">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Check if there are any session messages
    var email = "{{ session('email', '') }}";
    var telephone = "{{ session('telephone', '') }}";
    // If either session exists, show the modal
    if (email || telephone) {
        if (email) {
            document.getElementById('emailAddress').textContent = email;
            $('#emailOtp').val(email);
        }
        if (telephone) {
            document.getElementById('smsNumber').textContent = telephone;
        }
        var verifyModal = new bootstrap.Modal(document.getElementById('verifyModel'));
        verifyModal.show();
    }
});
</script>