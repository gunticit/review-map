@extends('layouts.app')
@section('content')
<style>
    #layoutSidenav #layoutSidenav_content{
        padding-left: 0 !important;
        top: 0 !important;
    }
    .btn{
        padding: 1rem 1.5rem;
    }
    .form-check-number{
        justify-content: space-evenly;
        margin-bottom: 20px;
    }
    @media(max-width: 992px){
        #layoutSidenav #layoutSidenav_content{
            margin-left: 0 !important;
        }
        #remember-group{
            padding-left: 0;
        }
    }
</style>
<section class="login">
    <div class="row g-0">
    <div class="col-xl-6 col-md-12 col-12">
        <div class="login-wrap">
        <div class="logo">
            <a href="javascript:void(0);">
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
                    <div class="form-check" id="remember-group">
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
                @if(session('wrong_path'))
                    <div class="alert alert-danger">
                       Vui lòng điền đúng đường dẫn <a href="{{ session('wrong_path') }}"><strong>{{ session('wrong_path') }}</strong></a>
                    </div> 
                @endif

            </form>
            <div class="login-other">
                <span>Hoặc đăng nhập với</span>
            </div>
                <a href="javascript:void(0);" class="btn btn-outline-secondary login-with-google" data-bs-toggle="modal" data-bs-target="#confirmModal">
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
                <a class="nav-link" href="javascript:void(0);">Điều khoản & Điều kiện</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);">Chính sách bảo mật</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);">Trợ giúp</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false"> English </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{!! route('user.language', ['vi']) !!}">{{ __('auth.vietnamese') }}</a>
                    </li>
                    {{-- <li>
                        <a class="dropdown-item" href="{!! route('user.language', ['en']) !!}">English</a>
                    </li> --}}
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

<x-confirm-otp email=""></x-confirm-otp>
<x-login-by-google message="Bạn có chắc chắn muốn đăng nhập bằng Google với vai trò đối tác không?" />
@endsection