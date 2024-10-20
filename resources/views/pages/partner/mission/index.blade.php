@extends('layouts.app')
@section('content')
<section class="section nhan-nhiem-vu-step mb-5 mt-5">
    <div class="container">
        <div class="col-inner text-center">
            <div class="col-xl-10 col-md-9 col-12 mb-4 mb-md-0 ">
                <!-- class: bg-warning, bg-success, bg-danger  -->
                <div id="message-location" class="message bg-danger">
                    <div class="d-flex align-items-center" id="alert-location">
                        <span class="material-symbols-outlined me-2">info</span>
                    </div>
                </div>
            </div>
            @if(!empty($project))
            <div class="section-step">
                <h3>step 1</h3>
                <section>
                    <h2 class="mb-3">Nhận nhiệm vụ</h2>
                    <p>Bạn cần phải đánh giá 5 sao cho map</p>
                    <h2 class="text-primary">{{ $project->name }}</h2>
                </section>
                <h3>step 2</h3>
                <section>
                    <h2 class="mb-3">Nhận nhiệm vụ</h2>
                    <p>Bạn cần phải đánh giá 5 sao cho map</p>
                    <h2 class="text-primary mb-4">{{ $project->name }}</h2>
                    <p class="text-black-50">Vui lòng copy nội dung bên dưới</p>
                    
                    <textarea class="form-control mb-3 textarea-copy" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">
                        {!! trim($project->description) !!}
                    </textarea>
                    <div class="text-right">
                        <a class="btn btn-outline-primary btn-copy" href="#">
                            <span class="material-symbols-outlined">content_copy</span>
                            Copy nội dung
                        </a>
                    </div>
                </section>
                <h3>step 3</h3>
                <section>
                    <h2 class="mb-3">Nhận nhiệm vụ</h2>
                    <p>Bạn cần phải đánh giá 5 sao cho map</p>
                    <h2 class="text-primary mb-4">{{ $project->name }}</h2>
                    <p class="text-black-50">Vui lòng copy nội dung bên dưới</p>
                    @if(!empty($mission->images))
                    <div class="mb-4 download-img-wrap position-relative">
                        <img src="{{$mission->images->image_url}}" alt="image download" class="download-img">
                        <a class="btn btn-outline-primary btn-download-img" href="#">
                            <span class="material-symbols-outlined">download</span>
                            Tải hình ảnh
                        </a>
                    </div>
                    @endif
                    <textarea class="form-control mb-3 textarea-copy" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">Đồ uống tại quán cà phê ngon và đa dạng, không gian sang trọng và sạch sẽ. Nhân viên phục vụ nhanh, thân thiện, nhiệt tình và rất chu đáo. Từ nay chính thức trở thành khách ruột của quán, nhất định sẽ trở lại quán thêm nhiều lần nữa!</textarea>
                    <div class="text-right ">
                        <a class="btn btn-outline-primary btn-copy" href="#">
                            <span class="material-symbols-outlined">content_copy</span>
                            Copy nội dung
                        </a>
                        @if(!empty($mission))
                        <a class="btn btn-outline-primary ms-3 btn-download-img" href="#">
                            <span class="material-symbols-outlined">download</span>
                            Tải hình ảnh
                        </a>
                        @endif
                    </div>
                </section>
                <h3>step 4</h3>
                <section>
                    <h2 class="mb-3">Nhận nhiệm vụ</h2>
                    <iframe width="560" height="315" src="https://www.google.com/maps/place/?q=place_id:{{$project->place_id}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </section>
                <h3>step 6</h3>
                <section>
                    <h2 class="mb-3">Cám ơn bạn đã thực hiện nhiệm vụ</h2>
                    <p>Hệ thống đang tiến hành xử lý nhiệm vụ của bạn, thao tác <br> này có thể sẽ tốn một ít thời gian.</p>
                    
                    <div class="text-center">
                        <img src="{{ asset('assets/img/nhiem-vu-hoan-thanh.jpg') }}" alt="nhiem-vu" class="mb-4 hoan-thanh-img" >
                        <a class="btn btn-primary mb-4" href="{{route('mission.index')}}" >Trở lại trang nhiệm vụ</a>
                    </div>
                </section>
            </div> 
            @else 
            <span class="material-symbols-outlined" style="font-size: 120px">
                dvr
            </span>
            <p>Hiện tại chưa có nhiệm vụ!</p>
            @endif
        </div>
    </div>

<!-- Modal Vi Tri -->
<div class="modal fade ViTri" id="ViTri" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header ">
                <h2 class="modal-title" id="ViTriLabel">Yêu cầu cho phép <br> truy cập vị trí</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <p>Chúng tôi cần biết vị trí của bạn để phân phối nhiệm vụ ở gần bạn. 
                    Hãy <span class="text-primary">Cho phép truy cập vị trí</span> để tiếp tục
                </p>
                <img src="{{ asset('assets/img/Group-1000006623.png')}}" alt="1000006623">
            </div>
        </div>
    </div>
</div>
<!-- end modal vi tri  -->
</section>
<script src="{{ asset('assets/js/jquery.steps.min.js') }}"></script>
<script>
    // Jquery
    jQuery(document).ready(function($){
        $(".section-step").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            enableKeyNavigation: false,
            labels: {
                cancel: "Huỷ bỏ",
                current: "Bước hiện tại:",
                pagination: "Phân trang",
                finish: "Hoàn thành",
                next: "Tiếp tục",
                previous: "Quay lại",
                loading: "Đang tải ..."
            }
        });


        $('.btn-copy').click(function(){
            var textareaContent = $(this).parents('section').find('.textarea-copy').val();
            var tempTextarea = $('<textarea>');
            $('body').append(tempTextarea);
            tempTextarea.val(textareaContent).select();
            document.execCommand('copy');
            tempTextarea.remove();
        });
        $('.btn-download-img').click(function(){
            var imageUrl = $('.download-img').attr('src');
            var a = $('<a>')
                .attr('href', imageUrl)
                .attr('download', 'downloaded_image.png'); 
            $('body').append(a);
            a[0].click();
            a.remove();
        });

        let check_location = localStorage.getItem('current_location');
        if(!check_location){
            navigator.geolocation.getCurrentPosition(
                    function(position) {
                        $('#ViTri').modal('hide');
                        $('#message-location').remove();
                        $.ajax({
                            url: "{{ route('profile.update.location') }}",    //the page containing php script
                            type: "post",    //request type,
                            dataType: 'json',
                            data: {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude
                            },
                            success:function(result){
                                localStorage.setItem('current_location', JSON.stringify(position.coords));
                            },
                            error:function(result){
                                console.log(result)
                            }
                        });
                    },
                    function(error) {
                        console.log('not support');
                        $('#ViTri').modal('show');
                        $('#alert-location').append(`
                            <p class="alert-alert mb-0">Bạn cần cung cấp vị trí để có thể làm nhiệm vụ. Vui lòng tải lại trang.
                                <a href="{{route('mission.index')}}" class="ms-2">Tải lại trang <span class="material-symbols-outlined">replay</span></a>
                            </p>
                        `);
                    }
                );
        } else {
            $('#message-location').remove();
        }
    });
</script>
@endsection