@extends('layouts.app')

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
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Cấu hình dịch vụ
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
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
<script src="{{ asset('js/admin/voucher.js') }}"></script>
@endsection