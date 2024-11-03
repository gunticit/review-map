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

        /* Hiển thị biểu tượng "file-remove" khi hover */
        .file-item:hover .file-remove {
            display: inline-block;
        }

        .file-item:hover .file-success {
            display: none;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-wrap">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Thông báo đối tác</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tạo thông báo</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Create Support Request -->
    <section class="section tao-yeu-cau mb-5">
        <form action="{{ route('store.notificate.partner') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="container-fluid">
                <div class="col-inner">
                    <h2 class="section-title mb-4">Tạo thông báo</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Title Input -->
                    <div class="mb-4">
                        <label for="inputlist-table">{{ __('support.title') }} <span class="required">*</span></label>
                        <input class="form-control" name="title" id="inputlist-table" type="text" placeholder="Nhập tiêu đề" value="{{ $notification->title }}" required>
                    </div>
                    
                    <!-- Content Input -->
                    <div class="mb-4">
                        <label for="inputDescription">{{ __('support.content') }} <span class="required">*</span></label>
                        <textarea class="form-control" name="content" id="inputDescription" placeholder="Nhập mô tả" required>{{ $notification->content }}</textarea>
                    </div>

                    <!-- File Upload -->
                    <label>{{ __('support.attachment') }} <small>(Nếu có)</small></label>
                    <div class="mb-4">
                        <label for="inputFile" class="custom-file-upload">
                            <span class="material-symbols-outlined">link</span> Tải lên tệp
                        </label>
                        <input type="file" class="form-control" name="files[]" id="inputFile">
                        <div id="previewFiles"></div>
                    </div>

                    <div id="fileError" class="alert alert-danger" style="display: none;">Tệp quá lớn hoặc không được hỗ trợ.</div>

                    <!-- Khu vực hiển thị tên tệp -->
                    <div id="fileList" class="mb-4 col-6"></div>

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Gửi thông báo</button>
                    </div>
                </div>
            </div>
        </form>
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
