@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5 mt-5">
        <div class="container">
            <div class="col-inner p-5 text-center">
                <h5 class="card-title mb-2">Cản ơn bạn đã thực hiện nhiệm vụ</h5>
                <p style="color: #96A3BE">Hệ thống đang tiến hành xử lý nhiệm vụ của bạn, thao tác này có thể sẽ tốn một ít thời gian.</p>
                <img src="{{ asset('./assets/img/bg-mission.png') }}" alt="">
                <div class="mt-3 d-flex justify-content-center">
                    <a href="{{ route('mission.index') }}" class="btn btn-primary d-flex gap-2">
                        <span class="material-symbols-outlined">
                            fact_check
                        </span> <span>Trở lại trang nhiệm vụ</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection