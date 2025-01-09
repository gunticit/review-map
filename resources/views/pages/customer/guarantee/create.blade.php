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
        <form action="{{ route('customer.support.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="container-fluid">
                <div class="col-inner">
                    <h2 class="section-title mb-4">Tạo yêu cầu</h2>
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
                    <!-- Form Group (list-table)-->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-4">
                        <!-- class: invalid -->
                        <label for="inputlist-table">{{ __('support.title') }} <span class="required">*</span>
                        </label>
                        <input class="form-control" name="title" id="inputlist-table" type="text" placeholder="Nhập tiêu đề" value="" required>
                    </div>
                    <!-- Form Group (inputPhongBan)-->
                    <div class="mb-4">
                        <label for="inputPhongBan">{{ __('support.department') }} <span class="required">*</span>
                        </label>
                        <select class="form-control form-select" name="department_id" id="inputPhongBan" required>
                            <option value="">Chọn phòng ban</option>
                            @if(!empty($departments))
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!-- Form Group (DuAn)-->
                    <div class="mb-4">
                        <label for="inputDuAn">{{ __('support.project') }} <span class="required">*</span>
                        </label>
                        <select class="form-control form-select" name="project_id" id="inputDuAn" required>
                            <option>{{ __('support.select_project') }}</option>
                            @if(!empty($projects))
                                @foreach($projects as $project)
                                    <option value="{{ $project['id'] }}">{{ $project['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!-- Form Group (Description)-->
                    <div class="mb-4">
                        <label for="inputDescription">{{ __('support.content') }} <span class="required">*</span>
                        </label>
                        <textarea class="form-control" name="content" id="inputDescription" placeholder="Nhập mô tả"></textarea>
                    </div>
                    <!-- Form Group (inputFile)-->
                    <label>{{ __('support.attachment') }} <small>(Nếu có)</small>
                    </label>
                    <div class="mb-4">
                        <label for="inputFile" class="custom-file-upload"><span class="material-symbols-outlined">link</span> Tải lên tệp</label>
                        <input type="file" class="form-control" name="files[]" multiple id="inputFile">
                        <div id="previewImages"></div>
                    </div>
                    <div id="fileError" class="alert alert-danger" style="display: none;">Tệp quá lớn hoặc không được hỗ trợ.</div>
                    <!-- Khu vực hiển thị tên tệp -->
                    <div id="fileList" class="mb-4 col-6"></div>
                    <!-- Form Group (inputFile)-->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
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