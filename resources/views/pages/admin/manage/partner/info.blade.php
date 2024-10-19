@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/js/flag-icon.min.js"></script>
    <style>
        .button-tab {
            width: 100%;
            font-size: 18px;
            font-weight: 700;
            color: #96A3BE;
            background-color: #fff;
            border: 1px solid #fff;
        }

        .button-tab:hover {
            color: #194BFB;
            border: 1px solid #194BFB;
            background-color: #fff;
        }

        .button-tab.active {
            color: #194BFB;
            border: 1px solid #194BFB;
            background-color: #fff;
        }
        
        .color-black {
            color: #32343A;
        }

        .color-success {
            color: #22C55E;
        }

        .color-danger {
            color: #FF4747;
        }

        .color-warning {
            color: #F59E0B;
        }
    </style>
    <div class="list-manage-customer">
        <div class="container">
            <div class="row mt-5">
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.info') }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted active">Thông tin cơ bản</button>
                    </form>
                </div>
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.wallet') }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted">Ví đối tác</button>
                    </form>
                </div>
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.project') }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted">Lịch sử nhiệm vụ</button>
                    </form>
                </div>
            </div>
            <section class="mt-4">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">contract</span>
                                    <h5>Tổng dự án</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">task</span>
                                    <h5>{{ __('common.doing') }}</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total_working'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">scan_delete</span>
                                    <h5>Dự án tạm ngừng</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">scan_delete</span>
                                    <h5>Dự án y/c bảo hành</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">contract</span>
                                    <h5>Tổng nạp</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">task</span>
                                    <h5>Số dư hiện tại</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total_working'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">scan_delete</span>
                                    <h5>Đã chi tiêu</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
                            <div class="thong-ke-item text-center">
                                <div class="thong-ke-head">
                                    <span class="material-symbols-outlined">scan_delete</span>
                                    <h5>Ticket đã gửi</h5>
                                </div>
                                <div class="thong-ke-content">
                                    <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection