@include('layouts.header')
<style>
    .g-recaptcha{
        text-align: center;
        display: flex;
        justify-content: center;
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
                success: function(response){
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            $('#error-message').append('<p class="text-danger">'+errors[key]+'</p>');
                        }
                    } else {
                        $('#error-message').append('<p class="text-danger">'+errors[key]+'</p>');
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