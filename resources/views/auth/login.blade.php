@extends('layouts.app')
@section('content')
<style>
    #layoutSidenav #layoutSidenav_content{
        padding-left: 0 !important;
        top: 0 !important;
    }
</style>
<section class="login">
    <div class="row g-0">
    <div class="col-xl-6 col-md-12 col-12">
        <div class="login-wrap">
        <div class="logo">
            <a href="#">
            <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="login">
            </a>
        </div>
        <div class="login-form text-center">
            <h1>{{ __('auth.login') }}</h1>
            @error('login')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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
            <form method="POST" action="{{ route('auth.authenticate') }}">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input id="username" type="text" placeholder="{{ __('auth.username') }}" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input id="InputPassword" placeholder="{{ __('auth.password') }}" type="password" class="form-control @error('password') password is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('auth.remember') }}
                            </label>
                        </div>
                    </div>
                    <div class="form-login-forget">
                            <a class="btn btn-link" data-bs-toggle="modal" data-bs-target="#forgotModal">
                                {{ __('auth.forgot') }}
                            </a>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
              @error('login')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </form>
            <div class="login-other">
                <span>Hoặc đăng nhập với</span>
            </div>
                <a href="#" class="btn btn-outline-secondary login-with-google" data-bs-toggle="modal" data-bs-target="#confirmModal">
                    <img src="{{ asset('./assets/img/google-logo.svg') }}" alt="google"> Google
                </a>
                <div class="login-link-acount">
                <span>Bạn chưa có tài khoản? </span>
                <a href="{{ route('register') }}" class="btn-link">Tạo tài khoản</a>
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

<!-- Popup Chọn phương thức nhận OTP (chỉ sử dụng Email) -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-register">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="regForm">
                    <!-- Bước 1: Nhập email để nhận OTP -->
                    <div class="tab">
                        <h2>Xác thực danh tính</h2>
                        <p>Vui lòng chọn phương thức nhận liên kết thay đổi mật khẩu.</p>
                        <div class="mb-3">
                            <form id="emailForm" action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" required />
                            </form>
                        </div>
                        <a href="#" class="btn-link fw-700 text-decoration-underline mb-3 d-inline-block" data-bs-dismiss="modal" aria-label="Close">Trở về trang đăng nhập</a>
                    </div>

                    <!-- Bước 2: Nhập mã OTP -->
                    <div class="tab">
                        <h2>Nhập mã xác thực</h2>
                        <form id="otpForm" action="{{ route('password.otp') }}" method="POST">
                            @csrf
                            <p id="otpMessage"></p>
                            <input type="hidden" class="form-control" id="emailOtp" name="email" placeholder="Email" value="" required />
                            <input type="hidden" class="form-control" id="otpAttempts" name="otp_attempts" value="0"/>    
                            <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
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

                    <!-- Bước 3: Đổi mật khẩu mới -->
                    <div class="tab">
                        <h2>Tạo mật khẩu mới</h2>
                        
                        <form id="passwordForm" action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" id="emailResetPass" name="email" placeholder="Email" value="" required />
                            <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
                            <div class="input-group mb-3 input-group-password">
                                <span class="input-group-text"><span class="material-symbols-outlined">lock</span></span>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu mới" required />
                            </div>
                            <div class="input-group mb-3 input-group-password">
                                <span class="input-group-text"><span class="material-symbols-outlined">lock</span></span>
                                <input type="password" class="form-control" name="confirmPassword" placeholder="Xác nhận mật khẩu" required />
                            </div>
                        </form>
                    </div>

                    <!-- Bước 4: Thành công -->
                    <div class="tab">
                        <h2>Thành công!</h2>
                        <p>Chúc mừng! Bạn đã thay đổi mật khẩu thành công.</p>
                    </div>

                    <div class="text-center">
                        <button id="nextBtn" type="submit" class="btn btn-primary">
                            <!-- Loading Message -->
                        <div id="loadingMessage" style="display:none;" class="text-center">
                            <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                         <span id="buttonText">Tiếp tục</span>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- confirm đăng nhập bằng google --}}
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Xác nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="confirmModalBody" class="modal-body">
                Bạn có chắc chắn muốn đăng nhập bằng Google không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="{{ route('auth.google') }}" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    var url = window.location.href;
    var role = url.split('.')[0].split('//')[1];
    
    var roleMap = {
        doitac: 'Đối tác',
        khachhang: 'Khách hàng',
        quantri: 'Quản trị'
    };
        if (role && roleMap[role]) {
        var newMessage = 'Bạn có chắc chắn muốn đăng nhập bằng Google với vai trò ' + roleMap[role] + ' không?';
        document.getElementById('confirmModalBody').textContent = newMessage;
    }
});
</script>