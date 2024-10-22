@extends('layouts.app')
@section('content')
    <section class="section nhan-nhiem-vu-step mb-5 mt-5">
        <div class="container-fluid">
            <div class="col-inner text-center">
                <section class="col-inner p-5 text-center">
                    <h2 class="mb-3">Cám ơn bạn đã thực hiện nhiệm vụ</h2>
                    <p>Hệ thống đang tiến hành xử lý nhiệm vụ của bạn, thao tác <br> này có thể sẽ tốn một ít thời gian.</p>
                    <img src="{{ asset('./assets/img/bg-mission.png') }}" alt="nhiem-vu" class="mb-4 hoan-thanh-img">
                    <div class="mt-3 d-flex justify-content-center">
                        <a class="btn btn-primary mb-4 d-flex gap-2" href="{{ route('mission.index') }}" >
                            <span class="material-symbols-outlined">
                                fact_check
                            </span> Trở lại trang nhiệm vụ
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection