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
                <div class="row">
                    <div class="col-xl-12 text-right mb-3">
                      <button class="btn btn-info"><span class="material-symbols-outlined">
                        save
                        </span> Lưu</button>
                    </div>
                </div>
                <form action="{{ route('update.setting') }}" method="POST">
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
                                      <option value="1">Chỉ người duyệt</option>
                                      <option value="2">Chỉ AI duyệt</option>
                                      <option value="3">AI duyệt đến người duyệt</option>
                                  </select>
                              </div>
                              <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                  <div class="content d-flex flex-column">
                                      <span class="title">Bật/Tắt tính năng đánh giá ảnh</span>
                                      <span class="notice">Chế độ upload hình trong dự án sẽ bị hiện/ẩn theo cài đặt tại đây</span>
                                  </div>
                                  <select name="rating_image" class="form-select select-setting">
                                      <option value="">Lựa chọn</option>
                                      <option value="1">Bật</option>
                                      <option value="2">Tắt</option>
                                  </select>
                              </div>
                              <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                  <div class="content d-flex flex-column">
                                      <span class="title">Thời gian bảo hành</span>
                                      <span class="notice">Thiết lập thời gian mà dự án của khách hàng có thể được bảo hành</span>
                                  </div>
                                  <input name="time_guarantee" class="form-control select-setting" type="time" /> 
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
                                    <input height="45" style="max-height: 45px" class="form-control select-setting" type="number" name="percentage" value="{{ $setting->percentage ?? 5 }}" />
                                    <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(%)</span>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                <div class="content d-flex flex-column">
                                    <span class="title">Số tiền rãi chậm</span>
                                    <p class="notice mb-0">Số tiền sẽ tính thêm cho từng câu hỏi của dự án</p>
                                </div>
                                <div class="d-flex flex-row align-items-center" style="position: relative">
                                    <input class="form-control select-setting" type="number" name="setting_price_slow" value="{{ $setting->setting_price_slow ?? 2000 }}" />
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
                                    <input height="45" style="max-height: 45px" class="form-control select-setting" type="number" name="percentage" value="{{ $setting->percentage ?? 5 }}" />
                                    <span style="position: absolute; top: 50%; right: 20%; transform: translateY(-50%);">(%)</span>
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
                                <select name="vertify_account" id="vertify_account" class="form-select select-setting">
                                    <option value="">Lựa chọn</option>
                                    <option value="1">Bật</option>
                                    <option value="2">Tắt</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
                                <div class="content d-flex flex-column">
                                    <span class="title">Tài khoản đối tác</span>
                                    <span class="notice">Xác thực sẽ áp dụng với những tài khoản setting tại đây, mặc định sẽ áp dụng tất cả</span>
                                </div>
                                <select class="ajax-list-partner" name="user_partner_verify" id="listPartners"></select>
                            </div>
                            <div class="d-flex flex-row justify-content-between gap-3 py-3 border-bottom">
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
                                    <option value="1">Thanh toán qua[vi điện tử Momo]</option>
                                    <option value="2">Chuyển khoản ngân hàng</option>
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
                  </div>
                </form>
            </div>
        </div>
    </div>
</section>
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
    });
</script>
@endsection