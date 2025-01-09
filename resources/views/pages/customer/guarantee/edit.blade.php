@extends('layouts.app')
@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-wrap">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Yêu cầu hỗ trợ</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tạo yêu cầu</li>
                </ol>
            </nav>
        </div>
    </section>
    <!-- tao-yeu-cau -->
    <section class="section tao-yeu-cau mb-5">
        <form action="">
            <div class="container-fluid">
                <div class="col-inner">
                    <h2 class="section-title mb-4">Tạo yêu cầu</h2>
                    <!-- Form Group (list-table)-->
                    <div class="mb-4">
                        <!-- class: invalid -->
                        <label for="inputlist-table">Tiêu đề <span class="required">*</span>
                        </label>
                        <input class="form-control" name="tieu-de" id="inputlist-table" type="text" placeholder="Nhập tiêu đề" value="" required>
                    </div>
                    <!-- Form Group (inputPhongBan)-->
                    <div class="mb-4">
                        <label for="inputPhongBan">Phòng ban <span class="required">*</span>
                        </label>
                        <select class="form-control form-select" name="phong-ban" id="inputPhongBan" required>
                            <option>Chọn dự án</option>
                            <option value="">Kỹ thuật</option>
                            <option value="">Kế toán</option>
                        </select>
                    </div>
                    <!-- Form Group (DuAn)-->
                    <div class="mb-4">
                        <label for="inputDuAn">Dự án <span class="required">*</span>
                        </label>
                        <select class="form-control form-select" name="du-an" id="inputDuAn" required>
                            <option>Chọn dự án</option>
                            <option value="">Dự án Review Cửa hàng số 01</option>
                            <option value="">Dự án Review Cửa hàng số 02</option>
                            <option value="">Dự án Review Cửa hàng số 03</option>
                        </select>
                    </div>
                    <!-- Form Group (Description)-->
                    <div class="mb-4">
                        <label for="inputDescription">Nội dung <span class="required">*</span>
                        </label>
                        <textarea class="form-control" name="noi-dung" id="inputDescription" placeholder="Nhập mô tả"></textarea>
                    </div>
                    <!-- Form Group (inputFile)-->
                    <label>Tệp đính kèm <small>(Nếu có)</small>
                    </label>
                    <div class="mb-4">
                        <label for="inputFile" class="custom-file-upload"><span class="material-symbols-outlined">link</span> Tải lên tệp</label>
                        <input type="file" class="form-control" name="tep-dinh-kem" id="inputFile">
                    </div>
                    <!-- Form Group (inputFile)-->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                    </div>
                </div>
        </form>
    </section>
@endsection