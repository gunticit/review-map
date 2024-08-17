@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">contract</span>
                        <h5>Tổng dự án</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-primary">100</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">task</span>
                        <h5>Đang thực hiện</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-primary">90</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">scan_delete</span>
                        <h5>Đã tạm dừng</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-primary">10</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
                <div class="thong-ke-item text-center">
                    <div class="thong-ke-head">
                        <span class="material-symbols-outlined">attach_money</span>
                        <h5>Đã chi tiêu</h5>
                    </div>
                    <div class="thong-ke-content">
                        <h6 class="text-danger">500.000 VND</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end thong ke  -->
<!-- cau-hoi-thuong-gap -->
<section class="section cau-hoi-thuong-gap mb-5">
    <div class="container">
        <div class="col-inner">
            <h2 class="section-title mb-4 text-center">Các câu hỏi phổ biến</h2>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Lorem ipsum dolor sit amet?</button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Lorem ipsum dolor sit amet, consectetur adipiscing elit?</button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Ullamcorper morbi tincidunt ornare massa eget ege?</button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Diam quam nulla porttitor massa id. Eget velit aliquet sagittis id consectetur?</button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- end cau-hoi-thuong-gap -->
@endsection