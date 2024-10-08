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
<div class="modal fade ChangePassoword" id="ChangePassoword" tabindex="-1" aria-labelledby="ChangePassowordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title" id="ChangePassowordLabel">Đổi mật khẩu</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="form-change-password">
                <div class="mb-4">
                    <label  for="inputOlderPassword">Mật khẩu cũ <span class="required">*</span></label>
                    <div class="input-group">
                        <input class="form-control password" id="inputOlderPassword" type="password" name="password" placeholder="Mật khẩu cũ" required />
                        <span class="input-group-text togglePassword">
                            <span class="material-symbols-outlined">visibility_off</span>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label  for="inputPassword">Mật khẩu mới <span class="required">*</span></label>
                    <div class="input-group">
                        <input class="form-control password" id="inputPassword" type="password" name="password" placeholder="Mật khẩu mới" required />
                        <span class="input-group-text togglePassword">
                            <span class="material-symbols-outlined">visibility_off</span>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label  for="inputPasswordConfirm">Xác nhận mật khẩu mới <span class="required">*</span></label>
                    <div class="input-group">
                        <input class="form-control password" id="inputPasswordConfirm" type="password" name="password" placeholder="Xác nhận mật khẩu mới" required />
                        <span class="input-group-text togglePassword">
                            <span class="material-symbols-outlined">visibility_off</span>
                        </span>
                    </div>
                    <div id="error-message"></div>
                </div>
                <div class="text-center"><button type="button" id="btn-save-change" class="btn btn-outline-primary btn-lg">Lưu thông tin</button></div>
            </div>
        </div>
    </div>
</div>
<script>
    $('document').ready(function(){
        $('#btn-save-change').on('click', function(){
            let current_password = $('#inputOlderPassword').val();
            let new_password = $('#inputPassword').val();
            let confirm_password = $('#inputPasswordConfirm').val();
            $.ajax({
                url: "{{ route('profile.change.password') }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "current_password": current_password,
                    "new_password": new_password
                },
                dataType: 'json',
                success: function(response){
                    Toastify({
                        text: "Đổi mật khẩu thành công!",
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", 
                        position: "center", 
                        stopOnFocus: true,
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                Toastify({
                                    text: errors[key][0],
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top", 
                                    position: "center", 
                                    stopOnFocus: true,
                                    style: {
                                        background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                    }
                                }).showToast();
                            }
                        }
                    } else {
                        Toastify({
                            text: "Đã xảy ra lỗi. Vui lòng thử lại sau.",
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top", 
                            position: "center", 
                            stopOnFocus: true,
                            style: {
                                background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                            }
                        }).showToast();
                    }
                }
            });
        });
    })
</script>
@include('layouts.footer')