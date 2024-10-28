@extends('layouts.app')

@section('css')
    <style>
        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            position: relative;
        }

        .file-name {
            font-size: 14px;
        }

        .file-size {
            font-size: 12px;
            color: #6c757d;
            margin-right: 10px;
        }

        .file-success,
        .file-remove {
            color: green;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .file-remove {
            color: red;
            display: none;
        }

        /* Show file-remove icon on hover */
        .file-item:hover .file-remove {
            display: inline-block;
        }

        .file-item:hover .file-success {
            display: none;
        }

        .custom-file-upload {
            border: 1px solid var(--bs-primary);
            padding: 11px 12px;
            cursor: pointer;
            font-weight: 700;
            color: var(--bs-primary);
            border-radius: 8px;
            width: 600px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 100%;
        }

        .custom-file-upload span {
            margin-right: 10px;
        }

        .text-right .btn {
            min-width: 336px;
        }
    </style>
@endsection

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-wrap py-3">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-md-8 col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">Yêu cầu hỗ trợ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chi tiết hỗ trợ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Support Request Details -->
<section class="section support-request-details mb-5">
    <div class="container-fluid">
        <div class="card p-4">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="mb-3">HT00001 Yêu cầu hỗ trợ dự án số 01</h5>
                </div>

                <div class="col-md-4 text-end d-flex align-items-center justify-content-end gap-3">
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-2">27/06/2024</span>
                        <span class="text-muted">07:28</span>
                    </div>
                    <button class="btn btn-outline-primary" disabled>Đã tiếp nhận</button>
                </div>
            </div>

            <!-- User Info -->
            <div class="row mt-4 col-10 border border-primary rounded p-4">
                <div class="col-md-2 text-center">
                    <img src="{{ asset('./assets/img/profile-1.png') }}" class="img-fluid rounded-circle mb-3" alt="User Avatar" width="90" height="90">
                    <p>TÊN KHÁCH HÀNG</p>
                </div>
                <div class="col-md-10">
                    <p>
                        Varius sit amet mutta vulputate enim Morbi trisque senectus et netus et malesuada mare senean esmordermentum m quen
                        sam dong tae hullam non nisi est sit amet facilius Amet coласти атрtesque habitant morь на свеститыraurus faucibus pulumar mentum reger Suscipit seus mauris a diam maecenas sod.
                    </p>
                    <p>
                        Varius sit amet mutta vulputate enim Morbi trisque senectus et netus et malesuada mare senean esmordermentum m quen
                        sam dong tae hullam non nisi est sit amet facilius Amet coласти атрtesque habitant morь на свеститыraurus faucibus pulumar mentum reger Suscipit seus mauris a diam maecenas sod.
                    </p>
                    <p>
                        Varius sit amet mutta vulputate enim Morbi trisque senectus et netus et malesuada mare senean esmordermentum m quen
                        sam dong tae hullam non nisi est sit amet facilius Amet coласти атрtesque habitant morь на свеститыraurus faucibus pulumar mentum reger Suscipit seus mauris a diam maecenas sod.
                    </p>
                </div>
            </div>

            <!-- Reply Section -->
            <div class="col-12 d-flex justify-content-end">
                <div class="row mt-4 col-10 border border-primary rounded p-4" style="background-color: #e8edff;">
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('./assets/img/profile-1.png') }}" class="img-fluid rounded-circle mb-3" alt="User Avatar" width="90" height="90">
                        <p>Rivi</p>
                    </div>
                    <div class="col-md-10">
                        <p>
                            Varius sit amet mutta vulputate enim Morbi trisque senectus et netus et malesuada mare senean esmordermentum m quen
                            sam dong tae hullam non nisi est sit amet facilius Amet coласти атрtesque habitant morь на свеститыraurus faucibus pulumar mentum reger Suscipit seus mauris a diam maecenas sod.
                        </p>
                        <p>
                            Varius sit amet mutta vulputate enim Morbi trisque senectus et netus et malesuada mare senean esmordermentum m quen
                            sam dong tae hullam non nisi est sit amet facilius Amet coласти атрtesque habitant morь на свеститыraurus faucibus pulumar mentum reger Suscipit seus mauris a diam maecenas sod.
                        </p>
                        <p>
                            Varius sit amet mutta vulputate enim Morbi trisque senectus et netus et malesuada mare senean esmordermentum m quen
                            sam dong tae hullam non nisi est sit amet facilius Amet coласти атрtesque habitant morь на свеститыraurus faucibus pulumar mentum reger Suscipit seus mauris a diam maecenas sod.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Reply Form -->
            <div class="row mt-4">
                <div class="col-12">
                    <form action="" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="reply-content" class="form-label">Nội dung</label>
                            <textarea id="reply-content" class="form-control" rows="4" placeholder="Nhập nội dung"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('support.attachment') }} <small>(Nếu có)</small></label>
                            <div class="mb-4">
                                <label for="inputFile" class="custom-file-upload">
                                    <span class="material-symbols-outlined">link</span> Tải lên tệp
                                </label>
                                <input type="file" class="form-control d-none" name="files[]" multiple id="inputFile">
                                <div id="previewFiles"></div>
                            </div>

                            <div id="fileError" class="alert alert-danger" style="display: none;">Tệp quá lớn hoặc không được hỗ trợ.</div>

                            <!-- File name display area -->
                            <div id="fileList" class="mb-4 col-6"></div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        const getSelectedFiles = setupFileInput('#inputFile', '#fileList', '#fileError', 2);
        
        $('#inputFile').on('change', function () {
            const selectedFiles = getSelectedFiles(); // Get the array of selected files
            console.log('Currently selected files:', selectedFiles); // Log the files
        });
    });
</script>
@endsection
