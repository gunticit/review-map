@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/js/flag-icon.min.js"></script>
    <style>
        .nav-link{
            padding: 20px 0;
        }
        .iti--inline-dropdown{
            width: 100% !important;
        }
        select option {
            padding-left: 25px;
            background-position: left center;
            background-repeat: no-repeat;
        }
        .flag-icon {
            margin-right: 8px;
        }
        .btn-default{
            border: 2px solid #0061f2;
            color: #0061f2;
            transition: all ease .4s;
        }
        .btn-default:hover{
            background-color: #0061f2;
            color: #fff;
        }
        .active .form-control, .active .datatable-input{
            border-color: #fff !important;
        }
        #company-email{
            margin-bottom: 15px;
        }
    </style>
    <div class="list-manage-customer">
        <div class="container-fluid">
            <nav class="nav nav-pills flex-column flex-sm-row mt-5 gap-4">
                <a class="flex-sm-fill text-sm-center nav-link active" id="information-tab" data-bs-toggle="tab" data-bs-target="#information" type="button" role="tab" aria-controls="information" aria-selected="true" aria-current="page">
                    Thông tin cơ bản
                </a>
                <a class="flex-sm-fill text-sm-center nav-link border" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">
                    Lịch sử số dư
                </a>
                <a class="flex-sm-fill text-sm-center nav-link border" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                    Quản lý dự án
                </a>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
                    <section class="mt-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">contract</span>
                                            <h5>Tổng dự án</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">task</span>
                                            <h5>{{ __('common.doing') }}</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total_working'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">scan_delete</span>
                                            <h5>Dự án tạm ngừng</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">scan_delete</span>
                                            <h5>Dự án y/c bảo hành</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">contract</span>
                                            <h5>Tổng nạp</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">task</span>
                                            <h5>Số dư hiện tại</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total_working'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">scan_delete</span>
                                            <h5>Đã chi tiêu</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
                                    <div class="thong-ke-item text-center">
                                        <div class="thong-ke-head">
                                            <span class="material-symbols-outlined">scan_delete</span>
                                            <h5>Ticket đã gửi</h5>
                                        </div>
                                        <div class="thong-ke-content">
                                            <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="du-an-cua-ban">
                        <div class="col-12">
                            <div class="row">
                                <div id="info-customer" class="col-sm-6 col-xs-12 mt-4">
                                    <div class="col-inner">
                                        <div class="col-md-12 col-12">
                                            <div class="section-title">
                                                <h4>Thông tin cá nhân</h4>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-3">
                                            <label>Mã khách hàng</label>
                                            <input class="form-control" type="text" name="username" placeholder="Mã khách hàng" disabled>
                                        </div>
                                        <div class="col-md-12 col-12 mt-3">
                                            <label>Tên khách hàng</label>
                                            <input class="form-control" type="text" name="name" placeholder="Tên khách hàng" disabled>
                                        </div>
                                        <div class="col-md-12 col-12 mt-3">
                                            <label>Email</label>
                                            <input class="form-control" type="text" name="email" placeholder="Email" disabled>
                                        </div>
                                        <div class="col-md-12 col-12 mt-3">
                                            <label>Số điện thoại</label>
                                            <div class="input-group">
                                                <input type="tel" id="phone" name="phone" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-3">
                                            <div class="form-group">
                                                <label for="country">Chọn quốc gia:</label>
                                                <select id="country" class="form-control" disabled>
                                                    <option {!! $profile['country_code'] == 'vi'? 'selected': '' !!} value="vi"><span class="flag-icon flag-icon-vn"></span> Vietnam</option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="col-md-12 col-12 mt-3 text-right">
                                            <button type="button" id="btn-save-edit" class="btn btn-outline-primary">Chỉnh sửa</button>
                                            <button type="button" id="btn-save-info" style="display:none" class="btn btn-primary">Lưu thông tin</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 mt-4">
                                    <div class="col-inner">
                                        <div class="col-md-12 col-12">
                                            <div class="section-title">
                                                <h4>Thông tin công ty</h4>
                                                <hr>
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
                                                            <input disabled type="checkbox" {!! isset($company->is_receive) && $company->is_receive == 1 ? 'checked' : '' !!} class="form-check-input" id="is_receive">
                                                            <label class="form-check-label" for="is_receive">Tôi muốn nhận hóa đơn qua email này</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="company_address">Địa chỉ </label>
                                                    <input class="form-control" id="company_address" type="text" placeholder="Địa chỉ công ty" value="{{ $company->address ?? '' }}" disabled>
                                                </div>

                                                <button class="btn btn-outline-primary" id="btn-company-edit" type="button">Chỉnh sửa</button>
                                                <button class="btn btn-primary" style="display:none" id="btn-company-save" type="button">Lưu thông tin</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <div class="col-inner mt-4">
zxc
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="col-inner mt-4">
zxc2
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js", // Cần để tính hợp lệ số
                initialCountry: "vn",  // Quốc gia mặc định
                preferredCountries: ['vn', 'us', 'gb'], // Các quốc gia ưu tiên
                separateDialCode: true // Tách mã vùng ra riêng
            });

            // Lấy dữ liệu số điện thoại đầy đủ bao gồm mã vùng
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault(); // Ngăn submit để demo
                var fullPhoneNumber = iti.getNumber(); // Lấy số điện thoại đầy đủ với mã vùng
                console.log(fullPhoneNumber);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.querySelector('#country');

            countrySelect.addEventListener('change', function() {
                const selectedCountry = this.options[this.selectedIndex].text;
                console.log(`Quốc gia đã chọn: ${selectedCountry}`);
            });
        });

        $('#btn-save-edit').on('click', function(){
            $('#btn-save-edit').hide();
            $('#btn-save-info').show();
            let formData = new FormData();
            $('#info-customer .form-control').removeAttr('disabled');
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
            }).finally(function() {
                $('#btn-save-edit').show();
                $('#btn-save-info').hide();
            });
        });
        $('#btn-save-info').on('click', function(){
            $(this).hide();
            $('#btn-save-edit').show();
        });
        $('#btn-company-edit').on('click', function(){
            $(this).hide();
            $('#btn-company-save').show();
        });
        $('#btn-company-save').on('click', function(){
            $(this).hide();
            $('#btn-company-edit').show();
        });
    </script>
@endsection