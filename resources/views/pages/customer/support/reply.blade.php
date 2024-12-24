@extends('layouts.app')
@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-wrap">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Hỗ trợ khách hàng</a>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    <!-- tao-yeu-cau -->
    <section class="section tao-yeu-cau mb-5">
        <form action="{{ route('update.reply.support', ['id' => $support_id]) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="container-fluid">
                <div class="col-inner">
                    <h2 class="section-title mb-4">Hỗ trợ khách hàng</h2>
                    <!-- Form Group (list-table)-->
                    <div class="mb-4">
                        <!-- class: invalid -->
                        <label for="inputlist-table">Tiêu đề <span class="required">*</span>
                        </label>
                        <input class="form-control" name="tieu-de" id="inputlist-table" type="text" placeholder="Nhập tiêu đề" value="{{ $title }}" readonly>
                    </div>
                    <!-- Form Group (inputPhongBan)-->
                    <div class="mb-4">
                        <label for="inputPhongBan">Phòng ban <span class="required">*</span>
                        </label>
                        <select class="form-control form-select" name="department_id" id="inputPhongBan" disabled required>
                            <option value="">Chọn phòng ban</option>
                            @if(!empty($departments))
                                @foreach($departments as $department)
                                    <option {!! $department_id == $department->id? 'selected': '' !!} value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!-- Form Group (DuAn)-->
                    <div class="mb-4">
                        <label for="inputDuAn">Dự án <span class="required">*</span>
                        </label>
                        <select class="form-control form-select" name="project_id" id="inputDuAn" disabled required>
                            <option>{{ __('support.select_project') }}</option>
                            @if(!empty($projects))
                                @foreach($projects as $project)
                                    <option {!! $project_id == $project['id']? 'selected': '' !!} value="{{ $project['id'] }}">{{ $project['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!-- Form Group (Description)-->
                    <div class="mb-4">
                        <label for="inputDescription">Nội dung <span class="required">*</span>
                        </label>
                        <textarea class="form-control" name="noi-dung" id="inputDescription" placeholder="Nhập mô tả">
                            {!! trim($content) !!}
                        </textarea>
                    </div>
                    @if($filepath)
                    <!-- Form Group (inputFile)-->
                    <label>Tệp đính kèm <small>(Nếu có)</small>
                    </label>
                    <div class="mb-4">
                        <img src="{{ $filepath }}" alt="anh" width="100px" height="100px">
                    </div>
                    @endif
                    <!-- Form Group (inputFile)-->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                    </div>
                </div>
        </form>
    </section>
@endsection