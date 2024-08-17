@extends('layouts.app')

@section('content')
<!-- tai khoan -->
<section class="accout mb-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- cot 1 -->
            <div class="col-xl-6 col-md-12 col-12 mb-4 mb-xl-0">
                <form>
                    <div class="card mb-4">
                        <div class="card-header d-xl-flex justify-content-between align-items-center">
                            <h2 class="card-title">Thông tin cá nhân</h2>
                            <button class="btn btn-primary" type="button">Chỉnh sửa</button>
                            <button class="btn btn-outline-primary" type="submit">Lưu thông tin</button>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-4">
                                    <label for="inputUsername">Ảnh đại diện</label>
                                    <div class="position-relative">
                                        <img src="{{ asset('./assets/img/acount-img.svg') }}" alt="account img">
                                        <a class="btn btn-primary position-absolute bottom-0" href="#" role="button">
                                            <span class="material-symbols-outlined">border_color</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <!-- Form Group (username)-->
                                    <div class="mb-4">
                                        <label for="inputUsername">Họ và tên <span class="required">*</span>
                                        </label>
                                        <input class="form-control" id="inputUsername" type="text" value="Nguyen Van A" disabled>
                                    </div>
                                    <!-- Form Group (email address)-->
                                    <div class="mb-4">
                                        <label for="inputEmailAddress">Email <span class="required">*</span>
                                        </label>
                                        <input class="form-control form-control-lg" id="inputEmailAddress" type="email" value="customer.kh_01@gmail.com" disabled>
                                    </div>
                                    <!-- Form Group (phone)-->
                                    <div class="mb-4">
                                        <label for="inputPhone">Số điện thoại <span class="required">*</span>
                                        </label>
                                        <input type="tel" class="form-control form-control-lg" id="phone" name="phone" placeholder="Số điện thoại" value="123 45 67 89" disabled />
                                        <div class="form-check mt-2"></div>
                                    </div>
                                    <!-- Form Group (country)-->
                                    <div class="mb-4">
                                        <label for="inputcountry">Quốc gia <span class="required">*</span>
                                        </label>
                                        <select class="form-control form-select form-select-lg" name="" id="" disabled>
                                            <option selected>Việt Nam</option>
                                            <option value="">English</option>
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
                <form>
                    <div class="card mb-4">
                        <div class="card-header d-xl-flex justify-content-between align-items-center">
                            <h2 class="card-title">Thông tin công ty</h2>
                            <button class="btn btn-primary" type="button">Chỉnh sửa</button>
                            <button class="btn btn-outline-primary" type="submit">Lưu thông tin</button>
                        </div>
                        <div class="card-body">
                            <!-- Form Group (Tên công ty)-->
                            <div class="mb-4">
                                <label for="inputCompany">Tên công ty </label>
                                <input class="form-control" id="inputCompany" type="text" placeholder="Tên công ty" value="" disabled>
                            </div>
                            <!-- Form Group (email Tax code)-->
                            <div class="mb-4">
                                <label for="inputTaxCode">Mã số thuế </label>
                                <input class="form-control " id="inputTaxCode" type="number" placeholder="Mã số thuế" value="" disabled>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-4">
                                <label for="inputEmailAddress">Email <span class="required">*</span>
                                </label>
                                <input class="form-control mb-1" id="inputEmailAddress" type="email" placeholder="Email" value="" disabled>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Tôi muốn nhận hóa đơn qua email này</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Group (company address)-->
                            <div class="mb-4">
                                <label for="inputCompanyAddress">Địa chỉ </label>
                                <input class="form-control" id="inputCompanyAddress" type="text" placeholder="Địa chỉ công ty" value="" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end tai khoan -->
@endsection
