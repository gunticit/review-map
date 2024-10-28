@extends('layouts.app')

@section('content')
<!-- tai khoan -->
<section class="accout mb-5 mt-5">
    <div class="container-fluid">
        <div class="row">
            <!-- cot 1 -->
            <div class="col-xl-6 col-md-12 col-12 mb-4 mb-xl-0">
                <form>
                    <div class="card mb-4">
                        <div class="card-header d-xl-flex justify-content-between align-items-center">
                            <h2 class="card-title">Thông tin cá nhân</h2>
                            <button class="btn btn-primary" type="button">Chỉnh sửa</button>
                            <button class="btn btn-outline-primary" id="btn-save-info" type="button">Lưu thông tin</button>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-4">
                                    <label for="inputUsername">Ảnh đại diện</label>
                                    <div class="position-relative">
                                        <img src="{{ $profile['avatar'] ?? asset('./assets/img/acount-img.svg') }}" id="avatar" onclick="document.getElementById('inputAvatar').click()" alt="account img">
                                        <a class="btn btn-primary position-absolute bottom-0 btn-edit-profile" href="javascript:void(0);" role="button">
                                            <span class="material-symbols-outlined">border_color</span>
                                        </a>
                                        <input type="file" name="avatar" class="d-none" id="inputAvatar">
                                    </div>
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
                <div class="card mb-4">
                    <div class="card-header d-xl-flex justify-content-between align-items-center">
                        <h2 class="card-title">Thông tin công ty</h2>
                        <button class="btn btn-primary" type="button">Chỉnh sửa</button>
                        <button class="btn btn-outline-primary" id="btn-company" type="button">Lưu thông tin</button>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="company_name">Tên công ty </label>
                            <input class="form-control" id="company_name" type="text" placeholder="Tên công ty" value="{{ $company->name ?? '' }}" disabled>
                        </div>
                        <div class="mb-4">
                            <label for="tax">Mã số thuế </label>
                            <input class="form-control " id="tax" type="number" placeholder="Mã số thuế" value="{{ $company->tax ?? '' }}" disabled>
                        </div>
                        <div class="mb-4">
                            <label for="company_email">Email <span class="required">*</span>
                            </label>
                            <input class="form-control mb-1" id="company_email" type="email" name="email" placeholder="Email" value="{{ $company->email ?? '' }}" disabled>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <input type="checkbox" disabled {!! isset($company->is_receive) && $company->is_receive == 1 ? 'checked' : '' !!} class="form-check-input" id="is_receive">
                                    <label class="form-check-label" for="is_receive">Tôi muốn nhận hóa đơn qua email này</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="company_address">Địa chỉ </label>
                            <input class="form-control" id="company_address" type="text" placeholder="Địa chỉ công ty" value="{{ $company->address ?? '' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end tai khoan -->
<script>
    $('#btn-save-info').on('click', function(e) {
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
                Toastify({
                    text: "Thay đổi thông tin thành công!",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", 
                    position: "center", 
                    stopOnFocus: true,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
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
    $('#btn-company').on('click', function(e) {
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('company_name', $('#company_name').val());
        formData.append('company_email', $('#company_email').val());
        formData.append('tax', $('#tax').val());
        formData.append('is_receive', $('#is_receive').is(":checked") ? 1 : 0);
        formData.append('company_address', $('#company_address').val());
        $.ajax({
            url: '{{ route("profile.update.company") }}',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(res) {
                Toastify({
                    text: "Thay đổi thông tin thành công!",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", 
                    position: "center", 
                    stopOnFocus: true,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
            },
            error: function() {
            }
        })
    })
</script>
@endsection
