@include('layouts.header')
<div id="layoutSidenav">
    @auth
        @include('layouts.sidebar')
    @endauth

    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>
    </div>
</div>
<!-- Modal Change Password -->
<div class="modal fade ChangePassoword" id="ChangePassoword" tabindex="-1" aria-labelledby="ChangePassowordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title" id="ChangePassowordLabel">Đổi mật khẩu</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="">
                    <!-- Form Group (OlderPassword)-->
                    <div class="mb-4">
                        <label  for="inputOlderPassword">Mật khẩu cũ <span class="required">*</span></label>
                        <div class="input-group">
                            <input class="form-control password" id="inputOlderPassword" type="password" name="password" placeholder="Mật khẩu cũ" required />
                            <span class="input-group-text togglePassword">
                                <span class="material-symbols-outlined">visibility_off</span>
                            </span>
                        </div>
                    </div>

                    <!-- Form Group (Password)-->
                    <div class="mb-4">
                        <label  for="inputPassword">Mật khẩu mới <span class="required">*</span></label>
                        <div class="input-group">
                            <input class="form-control password" id="inputPassword" type="password" name="password" placeholder="Mật khẩu mới" required />
                            <span class="input-group-text togglePassword">
                                <span class="material-symbols-outlined">visibility_off</span>
                            </span>
                        </div>
                    </div>

                    <!-- Form Group (PasswordConfirm)-->
                    <div class="mb-4">
                        <label  for="inputPasswordConfirm">Xác nhận mật khẩu mới <span class="required">*</span></label>
                        <div class="input-group">
                            <input class="form-control password" id="inputPasswordConfirm" type="password" name="password" placeholder="Xác nhận mật khẩu mới" required />
                            <span class="input-group-text togglePassword">
                                <span class="material-symbols-outlined">visibility_off</span>
                            </span>
                        </div>
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-outline-primary btn-lg">Lưu thông tin</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')