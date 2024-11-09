@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke skeleton">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">contract</span>
                        <h5>Tổng dự án</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-primary">{!! $total ?? 0 !!}</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">task</span>
                        <h5>Đang thực hiện</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-primary">{!! $working ?? 0 !!}</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">scan_delete</span>
                        <h5>Đã tạm dừng</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-primary">{!! $stopped ?? 0 !!}</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">attach_money</span>
                        <h5>Đã chi tiêu</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-danger">{!! formatCurrency($money['spent']) !!}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end thong ke  -->
<!-- cau-hoi-thuong-gap -->
<section class="section cau-hoi-thuong-gap mb-5">
    <div class="container-fluid">
        <div class="col-inner">
            <h2 class="section-title mb-4 text-center">Các câu hỏi phổ biến</h2>
            <div class="accordion skeleton" id="accordion">
                @if(!empty($faqs))
                    @foreach($faqs as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {!! $key != 0 ? 'collapsed' : '' !!}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$key}}" aria-expanded="true" aria-controls="collapse-{{$key}}">{{ $faq->title }}</button>
                            </h2>
                            <div id="collapse-{{$key}}" class="accordion-collapse collapse {!! $key == 0 ? 'show' : '' !!}" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    {{ $faq->content }}
                                </div>
                            </div>
                        </div>
                    @endForeach
                @endif
            </div>
        </div>
    </div>
</section>
<!-- end cau-hoi-thuong-gap -->
@endsection