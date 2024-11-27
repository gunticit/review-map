@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/js/flag-icon.min.js"></script>
    <style>
        .button-tab {
            width: 100%;
            font-size: 18px;
            font-weight: 700;
            color: #96A3BE;
            background-color: #fff;
            border: 1px solid #fff;
        }

        .button-tab:hover {
            color: #194BFB;
            border: 1px solid #194BFB;
            background-color: #fff;
        }

        .button-tab.active {
            color: #194BFB;
            border: 1px solid #194BFB;
            background-color: #fff;
        }
        
        .color-black {
            color: #32343A;
        }

        .color-success {
            color: #22C55E;
        }

        .color-danger {
            color: #FF4747;
        }

        .color-warning {
            color: #F59E0B;
        }
    </style>
    <div class="list-manage-customer">
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="col-3">
                    <a href="{{ route('admin.manage.partner.info', ['id' => $partner_id]) }}" class="button-tab btn btn-muted active">Thông tin cơ bản</a>
                </div>
                <div class="col-3">
                    <a href="{{ route('admin.manage.partner.wallet', ['id' => $partner_id]) }}" class="button-tab btn btn-muted">Ví đối tác</a>
                </div>
                <div class="col-3">
                    <a href="{{ route('admin.manage.partner.project', ['id' => $partner_id]) }}" class="button-tab btn btn-muted">Lịch sử nhiệm vụ</a>
                </div>
            </div>
            <section class="row mt-4">
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
            <section class="row mt-4">
                <!-- cot 1 -->
                <div class="col-xl-6 col-md-12 col-12 mb-4 mb-xl-0">
                    <form>
                        <div class="card mb-4">
                            <div class="card-header d-xl-flex justify-content-between align-items-center">
                                <h2 class="card-title">Thông tin cá nhân</h2>
                            </div>
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <!-- Form Group (usercode)-->
                                        <div class="mb-4">
                                            <label for="usercode">Mã đối tác <span class="required">*</span>
                                            </label>
                                            <input class="form-control" id="usercode" type="text" value="{{ $partner_info->usercode ?? 'NO_CODE'}}" disabled>
                                        </div>
                                        <!-- Form Group (fullname)-->
                                        <div class="mb-4">
                                            <label for="name">Họ và tên <span class="required">*</span>
                                            </label>
                                            <input class="form-control" id="name" type="text" value="{{ $partner_info->name ?? ''}}"  disabled="disabled">
                                        </div>
                                        <!-- Form Group (email address)-->
                                        <div class="mb-4">
                                            <label for="email">Email <span class="required">*</span>
                                            </label>
                                            <input class="form-control form-control-lg" id="email" type="email" value="{{ $partner_info->email ?? ''}}"  disabled="disabled">
                                        </div>
                                        <!-- Form Group (phone)-->
                                        <div class="mb-4">
                                            <label for="inputPhone">Số điện thoại <span class="required">*</span>
                                            </label>
                                            <input type="tel" class="form-control form-control-lg" id="telephone" name="telephone" placeholder="Số điện thoại" value="{{ $partner_info->telephone ?? ''}}"  disabled="disabled">
                                        </div>
                                        <!-- Form Group (country)-->
                                        <div class="mb-4">
                                            <label for="inputcountry">Quốc gia <span class="required">*</span>
                                            </label>
                                            <select class="form-control form-select form-select-lg" name="country_id" id="countryCode" disabled="disabled">
                                                <option value="">--- Chọn ---</option>
                                                <option selected value="vi">Việt Nam</option>
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
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-primary" id="btn-edit" type="button">Chỉnh sửa</button>
                                <button class="btn btn-outline-primary d-none" id="btn-company" type="button">Lưu thông tin</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="company_name">Tên công ty </label>
                                <input class="form-control" id="company_name" type="text" placeholder="Tên công ty" value="" disabled="disabled">
                            </div>
                            <div class="mb-4">
                                <label for="tax">Mã số thuế </label>
                                <input class="form-control " id="tax" type="number" placeholder="Mã số thuế" value="" disabled="disabled">
                            </div>
                            <div class="mb-4">
                                <label for="company_email">Email <span class="required">*</span>
                                </label>
                                <input class="form-control mb-1" id="company_email" type="email" name="email" placeholder="Email" value="" disabled="disabled">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input type="checkbox" disabled="disabled" class="form-check-input" id="is_receive">
                                        <label class="form-check-label" for="is_receive">Tôi muốn nhận hóa đơn qua email này</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="company_address">Địa chỉ </label>
                                <input class="form-control" id="company_address" type="text" placeholder="Địa chỉ công ty" value="" disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
<script>
    $('body').on('click', '#btn-edit', function(){
        $('input,select').removeAttr("disabled");
        $(this).addClass('d-none');
        $('#btn-company').removeClass('d-none');
    });
    $('body').on('click', '#btn-company', function(){
        $(this).addClass('d-none');
        $('#btn-edit').removeClass('d-none');
        $('input, select').attr('disabled', 'disabled');
    });
</script>
@endsection