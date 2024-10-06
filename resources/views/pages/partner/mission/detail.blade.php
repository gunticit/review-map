@extends('layouts.app')
@section('content')
<style>
    .bg-body-tertiary{
        background: #f8f9fa
    }
</style>
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5 mt-5">
        <div class="container">
            <div id="step2" class="col-inner p-5 text-center">
                <h5 class="card-title mb-2">Nhận nhiệm vụ</h5>
                <p class="card-text mb-0">Bạn cần đánh giá 5 sao cho map</p>
                <h4 class="d-flex my-3 justify-content-center text-primary">{{ $mission->project->name }}</h4>
                <p style="color: #96A3BE">Vui lòng copy nội dung bên dưới</p>
                <div class="p-5 text-center bg-body-tertiary rounded-3">
                    {{ $mission->comments->comment }}
                </div>
                <div class="text-end">
                    <button class="btn btn-outline-black mt-3" id="btn-copy">
                        <span class="material-symbols-outlined">
                        content_copy
                        </span>
                        Copy nội dung
                    </button>

                    <button class="btn btn-outline-black mt-3" id="btn-copy">
                        <span class="material-symbols-outlined">
                            download
                        </span>
                        Tải hình ảnh
                    </button>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('mission.index') }}" class="btn btn-outline-primary"><span class="material-symbols-outlined">
                        arrow_back_ios
                        </span><span>Quay lại</span></a>
                    <a href="{{ route('mission.confirm', ['id' => $mission_id]) }}" class="btn btn-primary">Tiếp tục <span class="material-symbols-outlined">
                        arrow_forward_ios
                        </span></a>
                </div>
            </div>
        </div>
    </section>
@endsection