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
                    <input id="new_password" placeholder="{{ __('auth.password') }}" type="password" class="form-control @error('password') password is-invalid @enderror" name="password" required autocomplete="current-password">
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
                        @if (Route::has('password.request'))
                            <!--  href="{{ route('password.request') }}" -->
                            <a class="btn btn-link" data-bs-toggle="modal" data-bs-target="#forgotModal">
                                {{ __('auth.forgot') }}
                            </a>
                        @endif
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
                <a href="#" class="btn btn-outline-secondary login-with-google">
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

<!-- Modal -->
<div class="modal fade " id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
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
                <h2>Xác thực danh tính</h2>
                <p>Vui lòng chọn phương thức nhận liên kết thay đổi mật khẩu.</p>
                <div class="mb-3">
                {{-- <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="" required /> --}}
                <input type="email"  class="form-control" id="email" name="email" placeholder="Email" value="" required />
                </div>
                <a href="#" class="btn-link fw-700 text-decoration-underline mb-3 d-inline-block" data-bs-dismiss="modal" aria-label="Close">Trở về trang đăng nhập</a>
            </div>
            <div class="tab">
                <h2>Nhập mã xác thực</h2>
                <p>Vui lòng nhập mã xác minh gồm 4 chữ số đã được gửi đến tin nhắn điện thoại của bạn.</p>
                <p class="fw-500 text-dark mb-0">Gửi mã xác thực đến:</p>
                <h5 class="btn btn-link fw-500 ">+84 123 45 67 89</h5>
                <form action="">
                <div class="d-flex form-check-number">
                    <div class="p-2">
                    <input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="4" />
                    </div>
                    <div class="p-2">
                    <input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="4" />
                    </div>
                    <div class="p-2">
                    <input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="4" />
                    </div>
                    <div class="p-2">
                    <input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="4" />
                    </div>
                </div>
                </form>
            </div>
            <div class="tab">
                <h2>Tạo mật khẩu mới</h2>
                <p>Vui lòng nhập mã xác minh gồm 4 chữ số đã được gửi đến tin nhắn điện thoại của bạn.</p>

                <div class="input-group mb-3 input-group-password">
                <span class="input-group-text" id="pass"><span class="material-symbols-outlined">lock</span></span>
                <input type="text" class="form-control" placeholder="Mật khẩu mới" aria-label="Mật khẩu mới" aria-describedby="pass">
                </div>

            </div>
            <div class="tab">
                <h2>Thành công!</h2>
                <p>Chúc mừng! Bạn đã thay đổi mật khẩu thành công. Việc thiết lập tài khoản sẽ chưa mất đến 1 phút.</p>
            </div>
            <div class="text-center">
                <a type="button" id="nextBtn" onclick="nextPrev(1)" class="btn btn-primary">Tiếp tục <span class="material-symbols-outlined">arrow_forward</span>
                </a>
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
