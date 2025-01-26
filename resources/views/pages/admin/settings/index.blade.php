@extends('layouts.app')
@section('css')
<style>
    .setting-page .accordion-header .accordion-button:not(.collapsed){
        color: #005dfb;
    }
    .select-setting{
        width: 245px;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<section class="section setting-page mb-5 mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-12 mb-4 mb-xl-0">
                <form action="{{ route('update.setting') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xl-12 text-right mb-3">
                            <button class="btn btn-info" type="submit">
                                <span class="material-symbols-outlined">
                                save
                                </span> 
                                Lưu
                            </button>
                        </div>
                    </div>
                    <div class="accordion skeleton" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Cấu hình hệ thống
                            </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Hình thức duyệt đơn</span>
                                        <span class="notice">Nếu để tự động AI duyệt có thể có những sai xót không đáng có</span>
                                    </div>
                                    <select name="approve_project" class="form-select select-setting">
                                        <option value="">Lựa chọn</option>
                                        <option {{ !empty($setting['approve_project']) && $setting['approve_project'] == 1 ? 'selected' : '' }} value="1">Chỉ người duyệt</option>
                                        <option {{ !empty($setting['approve_project']) && $setting['approve_project'] == 2 ? 'selected' : '' }} value="2">Chỉ AI duyệt</option>
                                        <option {{ !empty($setting['approve_project']) && $setting['approve_project'] == 3 ? 'selected' : '' }} value="3">AI duyệt đến người duyệt</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Bật/Tắt tính năng đánh giá ảnh</span>
                                        <span class="notice">Chế độ upload hình trong dự án sẽ bị hiện/ẩn theo cài đặt tại đây</span>
                                    </div>
                                    <select name="rating_image" class="form-select select-setting">
                                        <option value="">Lựa chọn</option>
                                        <option {{ !empty($setting['rating_image']) && $setting['rating_image'] == 1 ? 'selected' : '' }} value="1">Bật</option>
                                        <option {{ !empty($setting['rating_image']) && $setting['rating_image'] == 2 ? 'selected' : '' }} value="2">Tắt</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Thời gian bảo hành</span>
                                        <span class="notice">Thiết lập thời gian mà dự án của khách hàng có thể được bảo hành</span>
                                    </div>
                                    <div class="d-flex flex-row gap-3">
                                        <input name="time_guarantee" value="{{ $setting['time_guarantee'] ?? '' }}" class="form-control select-setting" type="number" placeholder="Thời gian bảo hành" /> 
                                        <select name="time_guarantee_type" class="form-select select-setting">
                                            <option value="">-- Lựa chọn ---</option>
                                            <option {{ !empty($setting['time_guarantee_type']) && $setting['time_guarantee_type'] === 'second' ? 'selected' : ''}} value="second">Giây</option>
                                            <option {{ !empty($setting['time_guarantee_type']) && $setting['time_guarantee_type'] === 'minus' ? 'selected' : ''}} value="minus">Phút</option>
                                            <option {{ !empty($setting['time_guarantee_type']) && $setting['time_guarantee_type'] === 'hour' ? 'selected' : ''}} value="hour">Giờ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Thời gian Otp</span>
                                        <span class="notice">Thời gian khách hàng có thể gửi lại Otp, tại mục tài khoản / đăng ký / quên mật khẩu.</span>
                                    </div>
                                    <div class="d-flex flex-row gap-3">
                                        <input name="time_limit_otp" value="{{ $setting['time_limit_otp'] ?? '' }}" class="form-control select-setting" type="number" placeholder="Thời gian otp" /> 
                                        <select name="time_limit_otp_type" class="form-select select-setting">
                                            <option value="">-- Lựa chọn ---</option>
                                            <option {{ !empty($setting['time_limit_otp_type']) && $setting['time_limit_otp_type'] === 'second' ? 'selected' : ''}} value="second">Giây</option>
                                            <option {{ !empty($setting['time_limit_otp_type']) && $setting['time_limit_otp_type'] === 'minus' ? 'selected' : ''}} value="minus">Phút</option>
                                            <option {{ !empty($setting['time_limit_otp_type']) && $setting['time_limit_otp_type'] === 'hour' ? 'selected' : ''}} value="hour">Giờ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Cấu hình dịch vụ
                            </button>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#collapseTwo">
                            <div class="accordion-body">
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">% quy định dự án (có rãi chậm)</span>
                                        <p class="notice mb-0">Số phần trăm % của gói được review tối đa</p>
                                        <p class="notice mb-0">ví dụ đặt 5% thì khi 200 gói review được tối đa 10 reviews / ngày</p>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <input height="45" style="max-height: 45px" class="form-control select-setting" type="number" name="setting_percent_slow" value="{{ $setting['setting_percent_slow'] ?? 5 }}" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(%)</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Số tiền rãi chậm</span>
                                        <p class="notice mb-0">Số tiền sẽ tính thêm cho từng câu hỏi của dự án</p>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <input class="form-control select-setting" type="number" name="setting_price_slow" value="{{ $setting['setting_price_slow'] ?? 2000 }}" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(đ)</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">% quy định dự án (không rãi chậm - K tính thêm tiền)</span>
                                        <p class="notice mb-0">Số phần trăm % của gói được review tối đa</p>
                                        <p class="notice mb-0">ví dụ đặt 5% thì khi 200 gói review được tối đa 10 reviews / ngày</p>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <input height="45" style="max-height: 45px" class="form-control select-setting" type="number" name="setting_percent_no_slow" value="{{ $setting['setting_percent_no_slow'] ?? 5 }}" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(%)</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">% Upload ảnh dự án</span>
                                        <p class="notice mb-0">Up ảnh ko được ít hơn % min và ko được quá % max ( làm tròn % ) khi ở trang khách hàng.</p>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <label style="margin-bottom: 0; margin-right: 10px">Min:</label>
                                        <input height="45" style="max-height: 45px" class="form-control select-setting" type="number" id="setting-min-image" name="setting_min_image" value="{{ $setting['setting_min_image'] ?? 0 }}" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(%)</span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative;">
                                        <label style="margin-bottom: 0; margin-right: 10px">Max:</label>
                                        <input height="45" style="max-height: 45px" class="form-control select-setting" type="number" id="setting-max-image" name="setting_max_image" value="{{ $setting['setting_max_image'] ?? 0 }}" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(%)</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Giá tiền hình ảnh</span>
                                        <p class="notice mb-0">Chi phí bổ sung khi có ảnh: mỗi ảnh 5k ( có option quy định giá tiền mỗi ảnh ) => tính + thêm vào tổng tiền thanh toán dự án</p>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <input height="45" style="max-height: 45px" class="form-control select-setting" type="number" name="setting_price_image" value="{{ $setting['setting_price_image'] ?? 5000 }}" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(đ)</span>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#headingPartner" aria-expanded="false" aria-controls="headingPartner">
                                Cấu hình đối tác
                            </button>
                            <div id="headingPartner" class="collapse" aria-labelledby="headingPartner" data-bs-parent="#headingPartner">
                            <div class="accordion-body">
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Xác thực tài khoản đối tác</span>
                                        <span class="notice">Bật/tắt xác thực tài khoản đối tác</span>
                                    </div>
                                    <select name="setting_vertify_account" id="setting_vertify_account" class="form-select select-setting">
                                        <option value="">Lựa chọn</option>
                                        <option {{ !empty($setting['setting_vertify_account']) && $setting['setting_vertify_account'] == 1 ? 'selected' : '' }} value="1">Bật</option>
                                        <option {{ !empty($setting['setting_vertify_account']) && $setting['setting_vertify_account'] == 2 ? 'selected' : '' }} value="2">Tắt</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Tài khoản đối tác</span>
                                        <span class="notice">Xác thực sẽ áp dụng với những tài khoản setting tại đây, mặc định sẽ áp dụng tất cả</span>
                                    </div>
                                    <input name="setting_partner" id="setting_partner" class="form-control select-setting" type="text" />
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12">
                                            @if(!empty($list_partners))
                                            <ul>
                                                @foreach ($list_partners as $partner)
                                                    <li>
                                                        <span class="">
                                                            {{ $partner->name }}
                                                        </span>
                                                        <span class="remove-partner" id="remove-partner-{{ $partner->id }}" data-id="{{ $partner->id }}"><i class="fa-solid fa-xmark"></i></span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Khoảng cách đối tác</span>
                                        <span class="notice">Là khoảng cách đối với vị trí của địa điểm của nhiệm vụ mà đối tác có thể nhận</span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <input name="setting_distance" id="setting_distance" min="0" value="{{ $setting['setting_distance'] ?? 0 }}" class="form-control select-setting" type="number" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(Km)</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Ngày tối thiểu</span>
                                        <span class="notice">Là ngày tối thiểu dự án bắt buộc có đối tác nhận nhiệm vụ. Nếu dự án vượt quá số ngày này sẽ cộng thêm 'Khoảng cách mở rộng'.</span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <input name="setting_day_min_distance" id="setting_day_min_distance" min="1" value="{{ $setting['setting_day_min_distance'] ?? 1 }}" class="form-control" type="number" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(Ngày)</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Khoảng cách mở rộng</span>
                                        <span class="notice">Là số khoảng cách được cộng thêm vào 'khoảng khách đối tác' đối với dự án quá </span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center" style="position: relative">
                                        <input name="setting_extend_distance" id="setting_extend_distance" min="0" value="{{ $setting['setting_extend_distance'] ?? 0 }}" class="form-control" type="number" />
                                        <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(Km)</span>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#headingPayment" aria-expanded="false" aria-controls="headingPayment">
                                Cấu hình thanh toán
                            </button>
                            <div id="headingPayment" class="collapse" aria-labelledby="headingPayment" data-bs-parent="#headingPayment">
                            <div class="accordion-body">
                                <div class="d-flex flex-row justify-content-between gap-3 py-3">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Phương thức thanh toán</span>
                                        <span class="notice">Phương thức sẽ trả thưởng cho đối tác</span>
                                    </div>
                                    <select name="vertify_account" id="vertify_account" class="form-select select-setting">
                                        <option value="">Lựa chọn</option>
                                        <option {{ !empty($setting['vertify_account']) && $setting['vertify_account'] == 'momo' ? 'selected' : '' }} value="momo">Thanh toán qua[vi điện tử Momo]</option>
                                        <option {{ !empty($setting['vertify_account']) && $setting['vertify_account'] == 'bank' ? 'selected' : '' }} value="bank">Chuyển khoản ngân hàng</option>
                                    </select>
                                </div>
                                {{-- <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12">
                                            @if(!empty($settings['setting_partner']))
                                            <ul>
                                                @foreach ($setting_partner as $partner)
                                                    <li>
                                                        <span class="">
                                                            {{ $partner->name }}
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#headingAI" aria-expanded="false" aria-controls="headingAI">
                                Cấu hình kịch bản AI
                            </button>
                            <div id="headingAI" class="collapse" aria-labelledby="headingAI" data-bs-parent="#headingAI">
                            <div class="accordion-body">
                                <div class="d-flex flex-row justify-content-between gap-3 py-3">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Nội dung</span>
                                        <span class="notice">Nội dung này sẽ kết hợp với nội dung của khách hàng để tạo ra comment cho dự án</span>
                                    </div>
                                    <textarea class="form-control content-setting" name="setting_ai_content" id="setting_ai_content" placeholder="Nội dung" rows="3">{{ $setting['setting_ai_content'] ?? '' }}</textarea>
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Từ khóa</span>
                                        <span class="notice">Số lượng từ khóa mẫu sẽ được tạo từ nội dung khách hàng</span>
                                    </div>
                                    <input name="setting_number_keyword" id="setting_number_keyword" min="5" value="{{ $setting['setting_number_keyword'] ?? 5 }}" class="form-control select-setting" type="number" />
                                </div>
                                <div class="d-flex flex-row justify-content-between gap-3 py-3">
                                    <div class="content d-flex flex-column">
                                        <span class="title">Giới hạn mô tả dự án</span>
                                        <span class="notice">Số lượng ký tự của mô tả trong dự án sẽ bị giới hạn. Nếu không điền thị mặc định là 300.</span>
                                    </div>
                                    <input name="setting_number_keyword" id="setting_number_keyword" min="5" value="{{ $setting['setting_number_keyword'] ?? 5 }}" class="form-control select-setting" type="number" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#headingInfo" aria-expanded="false" aria-controls="headingTerm">
                                Cấu hình trang giới thiệu
                            </button>
                            <div id="headingInfo" class="collapse" aria-labelledby="headingInfo" data-bs-parent="#headingInfo">
                                <div class="accordion-body pb-3">
                                    <div class="d-flex flex-row justify-content-between gap-3 py-3">
                                        <div class="content d-flex flex-column">
                                            <span class="title">Nội dung</span>
                                            <span class="notice">Chi tiết trang giới thiệu</span>
                                        </div>
                                    </div>
                                    <textarea class="form-control content-setting" name="setting_intro_content" id="setting_intro_content" placeholder="Nội dung" rows="3">{{ $setting['setting_intro_content'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#headingContact" aria-expanded="false" aria-controls="headingTerm">
                                Cấu hình thông tin liên hệ
                            </button>
                            <div id="headingContact" class="collapse" aria-labelledby="headingContact" data-bs-parent="#headingContact">
                                <div class="accordion-body pb-3">
                                    <div class="d-flex flex-row justify-content-between gap-3 py-3">
                                        <div class="content d-flex flex-column">
                                            <span class="title">Nội dung</span>
                                            <span class="notice">Thông tin liên hệ hỗ trợ</span>
                                        </div>
                                    </div>
                                    <textarea class="form-control content-setting" name="setting_contact_content" id="setting_contact_content" placeholder="Nội dung" rows="3">{{ $setting['setting_contact_content'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#headingTerm" aria-expanded="false" aria-controls="headingTerm">
                                Cấu hình chính sách & điều khoản
                            </button>
                            <div id="headingTerm" class="collapse" aria-labelledby="headingTerm" data-bs-parent="#headingTerm">
                                <div class="accordion-body pb-3">
                                    <div class="d-flex flex-row justify-content-between gap-3 py-3">
                                        <div class="content d-flex flex-column">
                                            <span class="title">Nội dung</span>
                                            <span class="notice">Nội dung điều khoản sẽ hiển thị chi tiết tại mục đăng ký tài khoản</span>
                                        </div>
                                    </div>
                                    <textarea class="form-control content-setting" name="setting_term_content" id="setting_term_content" placeholder="Nội dung" rows="3">{{ $setting['setting_term_content'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>

$('#setting-max-image').on('change', function(){
    let max = $(this).val();
    let min = $('#setting-min-image').val();
    if(parseInt(min) > parseInt(max)){
        $('#setting-min-image').val(max);
    }
});
$('#setting-min-image').on('change', function(){
    let min = $(this).val();
    let max = $('#setting-max-image').val();
    if(parseInt(min) > parseInt(max)){
        $('#setting-max-image').val('');
    }
});
$(document).ready(function() {
    $('#setting_term_content').summernote({
        placeholder: 'Điều khoản và chính sách',
        tabsize: 4,
        height: 500
    });
    $('#setting_contact_content').summernote({
        placeholder: 'Thông tin liên hệ',
        tabsize: 4,
        height: 500
    });
    $('#setting_intro_content').summernote({
        placeholder: 'Thông tin giới thiệu',
        tabsize: 4,
        height: 500
    });
});
</script>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/admin/voucher.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#listPartners').select2({
            ajax: {
                url: '{{ route(("ajax.list.partners") )}}',
                data: function (params) {
                    let query = {
                        search: params.term,
                        type: 'public'
                    }
                    console.log(params);
                    return query;
                }
            }
        });
        $('#setting_partner').on('keyup', function() {
            let keyword = $(this).val();
            $.ajax({
                url: "{{ route('user.partner.search') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: keyword
                },
                success: function(res) {
                    $('#list-partners tbody').html(res);
                }
            })
        })
        $('.remove-partner').on('click', function(){
            let id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('delete.partner.setting') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    partner_id: id
                },
                success: function(res) {
                    if(res.success){
                        $('#remove-partner-'+id).remove();
                        showAlert('success', 'Xóa dữ liệu thành công!');
                    }else{
                        showAlert('error', 'Xóa dữ liệu thất bại!');
                    }
                }
            });
        });
    });
</script>
@endsection
@section('js')
<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js"></script>
@endsection