@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                                <h1>{{ __('auth.register') }}</h1>
                                <form method="POST" action="{{ route('register') }}">
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
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="{{ __('auth.telephone') }}" required />
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
                                        <span class="input-group-text togglePassword">
                                            <span class="material-symbols-outlined">visibility_off</span>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">{!! __('auth.terms_and_policy', ['url' => route('terms')]) !!} </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('auth.register') }}</button>
                                </form>
                                <div class="login-other">
                                    <span>{{ __('auth.login_with') }}</span>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-outline-secondary login-with-google">
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
            <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="regFormRadio" id="regFormSms">
                                        <label class="form-check-label" for="regFormSms"> Nhận mã bằng (SMS) tại: <span>+84 123 ****678</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="regFormRadio" id="regFormEmail">
                                        <label class="form-check-label" for="regFormEmail"> Nhận mã qua email tại: <span>part*******01@gmail.com</span>
                                        </label>
                                    </div>
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
        </div>
    </div>
</div>
@endsection
