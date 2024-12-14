@include('layouts.header')
<style>
    .g-recaptcha{
        text-align: center;
        display: flex;
        justify-content: center;
    }
    #form-change-password .input-group-text.togglePassword{
        z-index: 1;
    }
    div#form-change-password.loading:before {
        pointer-events: all;
        content: "";
        display: flex;
        flex: 1;
        width: 100%;
        height: 100%;
        z-index: 2;
        position: absolute;
        left: 0;
        top: 0;
        background: rgb(0 0 0 / 30%);
    }
    div#form-change-password.loading:after{
        content: '';
        position: absolute;
        top: calc(50% - 40px);
        left: calc(50% - 40px);
        width: 40px;
        height: 40px;
        transform: translate(-50%, -50%);
        border: 3px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 2;
    }
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>
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
<div class="modal fade change-password-form" id="change-password-form" tabindex="-1" aria-labelledby="change-password-formLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title" id="change-password-formLabel">Đổi mật khẩu</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="form-change-password">
                <div class="mb-4">
                    <label  for="old_password">Mật khẩu cũ <span class="required">*</span></label>
                    <div class="input-group">
                        <input class="form-control password w-100" id="old_password" type="password" name="password" placeholder="Mật khẩu cũ" required />
                        <span class="input-group-text togglePassword">
                            <span class="material-symbols-outlined">visibility_off</span>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label  for="new_password">Mật khẩu mới <span class="required">*</span></label>
                    <div class="g-new_password">
                        <div class="input-group">
                            <input class="form-control password w-100" id="new_password" type="password" name="password" placeholder="Mật khẩu mới" required />
                            <span class="input-group-text togglePassword">
                                <span class="material-symbols-outlined">visibility_off</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label  for="confirm_password">Xác nhận mật khẩu mới <span class="required">*</span></label>
                    <div class="input-group g-confirm_password">
                        <input class="form-control password w-100" id="confirm_password" type="password" name="password" placeholder="Xác nhận mật khẩu mới" required />
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
            $('.g-new_password .text-danger').remove();
            $('.g-confirm_password .text-danger').remove();
            $('#old_password .text-danger').remove();
            $('#error-message .text-danger').remove();
            $('#new_password').removeClass('border-danger');
            $('#confirm_password').removeClass('border-danger');
            let current_password = $('#old_password').val();
            let new_password = $('#new_password').val();
            let confirm_password = $('#confirm_password').val();
            if(new_password != confirm_password){
                $('#confirm_password').addClass('border-danger');
                $('.g-confirm_password').append('<p class="text-danger">Mật khẩu mới không trùng khớp. Vui lòng thử lại.</p>');
                return;
            }
            if(current_password == new_password){
                $('#new_password').addClass('border-danger');
                $('.g-new_password').append('<p class="text-danger">Mật khẩu mới không được trùng lặp mật khẩu cũ.</p>');
                return;
            }
            $.ajax({
                url: "{{ route('profile.change.password') }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "current_password": current_password,
                    "new_password": new_password
                },
                dataType: 'json',
                beforeSend: function(){
                    $('#btn-save-change').prop('disabled', true);
                    $('#form-change-password').addClass('loading');
                },
                success: function(response){
                    if(response.status){
                        $('#change-password-form').modal('hide');
                        showAlert('success', response.message);
                    }
                },
                complete: function(){
                    $('#btn-save-change').prop('disabled', false);
                    $('#form-change-password').removeClass('loading');
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if(errors){
                        if(errors.current_password && errors.current_password.length > 0){
                            $('#old_password').addClass('border-danger');
                            errors.current_password.forEach(error => {
                                $('#old_password').parent().append('<p class="text-danger">' + error + '</p>');
                            });
                        }
                        if(errors.new_password && errors.new_password.length > 0){
                            $('#new_password').addClass('border-danger');
                            errors.new_password.map(error => {
                                $('#new_password').parent().append('<p class="text-danger">' + error + '</p>');
                            })
                        }
                        if(errors){
                            for (let key in errors) {
                                if(key != 'new_password' && key != 'current_password'){
                                    $('#error-message').append('<p class="text-danger">' + errors[key] + '</p>');
                                }
                            }
                        }
                    }else{
                        $('#error-message').append('<p class="text-danger">Có lỗi xảy ra! Vui lòng thử lại.</p>');
                    }
                }
            });
        });
        $('#confirm_password').on('change', function(){
            $('#confirm_password').removeClass('border-danger');
            $('.g-confirm_password .text-danger').remove();
        })

        $('#new_password').on('change', function(){
            $('.g-new_password .text-danger').remove();
            $('#new_password').removeClass('border-danger');
        });
    })
</script>

@include('layouts.footer')