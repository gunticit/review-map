@extends('layouts.app')
@section('content')
    <style>
        .color-grey {
            color: #718096;
        }

        .step-1 {
            margin-bottom: 42px;
        }

        .step-1-contract-upload {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
        }

        .step-1-contract-upload #text-upload-contract {
            display: flex;
            align-items: center;
            width: 100%;
            height: 54px;
            padding: 18px 16px;
            background-color: #FAFAFA;
        }

        .step-1-contract-upload #contract {
            position: absolute;
            right: 0;
            top: 0;
            width: 0;
            height: 0;
        }

        .step-1-contract-upload #btn-upload-contract {
            white-space: nowrap;
            font-weight: 600;
        }

        .step-1-upload #upload-contract {
            white-space: nowrap;
        }

        .step-2-upload .file-container {
            width: 48%;
        }

        .file-container table tr {
            width: 20%;
        }
        
        .verify-button-wrap {
            display: flex;
            justify-content: center;
            margin-top: 48px;
            margin-bottom: 32px;
        }

        #verify-button {
            max-width: 360px;
            width: 100%;
        }

        .file-container-single {
            position: relative;
            width: 100%;
        }

        .file-container-single .file-upload {
            width: 100%;
            display: flex;
            background-color: var(--file-container-bg);
            border-radius: var(--file-rounded);
            transition: all 0.3s;
        }

        .file-container-single .file-upload:hover {
            box-shadow: var(--shadow);
        }

        .file-container-single .file-upload .img-wrap {
            width: 100%;
            background-color: var(--file-bg);
            padding: 15px;
            border-radius: 10px;
            border: 1px dashed var(--file-border-color);
            text-align: center;
            cursor: pointer;
            color: #96A3BE;
            height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .file-container-single .file-upload .img-preview {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 100%;
        }

        .file-container-single .file-upload .img-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-container-single .file-upload .img-close {
            position: absolute;
            top: 6px;
            right: 6px;
            cursor: pointer;
        }
    </style>
    <section class="section section-wallet mb-5 mt-5">
        @if ($errors->any())
            <div class="alert alert-danger fw-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('wallet.verify.store') }}" id="form-store-verify" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="col-inner">
                            <h2 class="section-title mb-4">Hướng dẫn xác thực tài khoản</h2>
                            <p class="mb-4 color-grey">
                                <small>Sau khi nhận yêu cầu xác thực tài khoản, hệ thống sẽ kiểm tra và tiến hành duyệt thông tin cho đối tác. Thao tác này có thể sẽ mất vài giây.</small>
                            </p>
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-12 mx-auto">
                                    <div class="col-12 step-1">
                                        <div class="text-primary fw-500 mb-1">Bước 1:</div>
                                        <div class="col-12 mb-2">
                                            <small class="color-grey">
                                                Click vào đây để tải xuống, ký tên. Sau đó tải lên bản hợp đồng có đầy đủ chữ ký họ tên của đối tác.
                                                    <a href="path-to-your-file.pdf" download style="color:#32343A">
                                                        <span class="material-symbols-outlined fs-4">download</span> Tải hợp đồng
                                                    </a>
                                                </small>
                                        </div>
                                        <div class="col-12">
                                            <div class="step-1-contract-upload">
                                                <small class="color-grey" id="text-upload-contract">Hợp đồng phải đúng tên đối tác</small>
                                                <div class="btn btn-primary" id="btn-upload-contract"><span class="material-symbols-outlined fs-4">upload</span>Tải lên từ thiết bị</div>
                                                <input class="" id="contract" name="contract" type="file" placeholder="" value="" required="">
                                            </div>
                                        </div>
                                        <div class="error-message" id="contract_error">
                                            <small class="text-danger">
                                                <i class="material-symbols-outlined align-middle">error</i>
                                                Vui lòng tải lên hợp đồng
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 step-2">
                                        <div class="text-primary fw-500 mb-1">Bước 2:</div>
                                        <div class="color-grey"><small>Ảnh chụp mặt trước và sau CMND/CCCD/Hộ chiếu hoặc GPLX.</small></div>
                                        <div class="color-grey mb-2"><small>Vui lòng đảm bảo thông tin chính chủ; Chụp rõ, không bị loá, mờ và không bị cắt ra khỏi khung hình.</small></div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="file-container-single">
                                                    <label for="front_id_image" class="file-upload">
                                                        <div class="img-wrap">
                                                            <div class="img-preview">
                                                            </div>
                                                            <div class="img-close" style="display: none;">
                                                                <i class="material-symbols-outlined">close</i>
                                                            </div>
                                                            <div class="img-upload">
                                                                <i class="material-symbols-outlined">image</i>
                                                                <p>Kéo thả hoặc <span class="text-primary">chọn hình ảnh</span> để tải lên</p>
                                                            </div>
                                                        </div>
                                                        <input type="file" accept="image/png, image/gif, image/jpeg" id="front_id_image" name="front_id_image" false="" hidden="">
                                                    </label>
                                                </div>
                                                <div class="error-message" id="front_id_image_error">
                                                    <small class="text-danger">
                                                        <i class="material-symbols-outlined align-middle">error</i>
                                                        Vui lòng tải lên ảnh
                                                    </small>
                                                </div>
                                                <div class="text-center"><small class="color-grey">Mặt trước</small></div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="file-container-single">
                                                    <label for="back_id_image" class="file-upload">
                                                        <div class="img-wrap">
                                                            <div class="img-preview">
                                                            </div>
                                                            <div class="img-close" style="display: none;">
                                                                <i class="material-symbols-outlined">close</i>
                                                            </div>
                                                            <div class="img-upload">
                                                                <i class="material-symbols-outlined">image</i>
                                                                <p>Kéo thả hoặc <span class="text-primary">chọn hình ảnh</span> để tải lên</p>
                                                            </div>
                                                        </div>
                                                        <input type="file" accept="image/png, image/gif, image/jpeg" id="back_id_image" name="back_id_image" false="" hidden="">
                                                    </label>
                                                </div>
                                                <div class="error-message" id="back_id_image_error">
                                                    <small class="text-danger">
                                                        <i class="material-symbols-outlined align-middle">error</i>
                                                        Vui lòng tải lên ảnh
                                                    </small>
                                                </div>
                                                <div class="text-center"><small class="color-grey">Mặt sau</small></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="verify-button-wrap">
                                        <button type="submit" class="btn btn-primary fw-600" id="button-verify">Xác thực tài khoản</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <script src="{{ asset('./assets/js/fileUpload.js') }}"></script>
    <script>
        const contractError = $('#contract_error');
        const frontIdImageError = $('#front_id_image_error');
        const backIdImageError = $('#back_id_image_error');

        contractError.hide();
        frontIdImageError.hide();
        backIdImageError.hide();

        function initFileUpload(selector){
            $(selector).on('change', function(event){
                const fileInput = $(this);
                const imgPreview = fileInput.closest('.file-container-single').find('.img-preview');
                const imgClose = fileInput.closest('.file-container-single').find('.img-close');
                const imgUpload = fileInput.closest('.file-container-single').find('.img-upload');

                const selectedFile = event.target.files[0];
                const objectURL = URL.createObjectURL(selectedFile);
                const img = $('<img>').attr('src', objectURL).attr('alt', 'Ảnh đã chọn');

                imgPreview.empty();
                imgPreview.append(img);
                imgClose.show();
                imgUpload.hide();

                imgClose.on('click', function(e){
                    e.preventDefault();
                    imgPreview.empty();
                    imgClose.hide();
                    imgUpload.show();
                    fileInput.val('');
                });
            });
        }

        initFileUpload('#front_id_image');
        initFileUpload('#back_id_image');

        $('#btn-upload-contract').on('click', function(){
            $('#contract').click();
        });

        $('#contract').on('change', function(event){
            if (event.target.files.length > 0) {
                const fileName = event.target.files[0].name;
                $('#text-upload-contract').text(fileName);
            } else {
                $('#text-upload-contract').text('');
            }
        });

        $('#button-verify').on('click', function(e){
            e.preventDefault();
            const contractInput = $('#contract');
            const frontIdImageInput = $('#front_id_image');
            const backIdImageInput = $('#back_id_image');

            if (contractInput.val() == '') {
                contractError.show();
                return;
            } else {
                contractError.hide();
            }

            if (frontIdImageInput.val() == '') {
                frontIdImageError.show();
                return;
            } else {
                frontIdImageError.hide();
            }

            if (backIdImageInput.val() == '') {
                backIdImageError.show();
                return;
            } else {
                backIdImageError.hide();
            }

            $('#form-store-verify').submit();
        });
    </script>
@endsection
