@extends('layouts.app')
@section('content')
<script>

$(document).ready(function(){
    $('body .btn-copy').click(function(){
        var textareaContent = $(this).closest('section').find('.textarea-copy').val();
        var tempTextarea = $('<textarea>');
        $('body').append(tempTextarea);
        tempTextarea.val(textareaContent).select();
        document.execCommand('copy');
        tempTextarea.remove();
        showAlert('success','Đã sao chép nội dung!');
    });
    $('body .btn-download-img').click(function(){
        var imageUrl = $('.download-img').attr('src');
        var a = $('<a>')
            .attr('href', imageUrl)
            .attr('download', 'downloaded_image.png'); 
        $('body').append(a);
        a[0].click();
        a.remove();
    });
})
</script>
<section class="section nhan-nhiem-vu-step mb-5 mt-5">
    <div class="container-fluid">
        <div class="col-inner text-center">
            <div class="section-step">
                <h3>step 1</h3>
                <section>
                    <h2 class="mb-3">Nhận nhiệm vụ</h2>
                    <p>Bạn cần phải đánh giá 5 sao cho map</p>
                    <h2 class="text-primary mb-4">{{ $mission->project->name }}</h2>
                    <p class="text-black-50">Vui lòng copy nội dung bên dưới</p>
                    
                    <div class="mb-4 download-img-wrap position-relative">
                        @if(isset($mission->images->image_url))
                        <img src="{{ url($mission->images->image_url) }}" alt="{{ $mission->project->name }}" class="download-img">
                        @endif
                        <a class="btn btn-outline-primary btn-download-img" href="javascript:void(0);">
                            <span class="material-symbols-outlined">download</span>
                            Tải hình ảnh
                        </a>
                    </div>
                    <textarea class="form-control mb-3 textarea-copy" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">
                        {{ $mission->comments->comment }}
                    </textarea>
                    <div class="text-right ">
                        <a class="btn btn-outline-primary btn-copy" href="javascript:void(0);">
                            <span class="material-symbols-outlined">content_copy</span>
                            Copy nội dung
                        </a>
                        @if(isset($mission->images->image_url))
                        <a class="btn btn-outline-primary ms-3 btn-download-img" href="javascript:void(0);">
                            <span class="material-symbols-outlined">download</span>
                            Tải hình ảnh
                        </a>
                        @endif
                    </div>
                </section>
                <h3>step 4</h3>
                <section>
                    <h2 class="mb-3">Nhận nhiệm vụ</h2>
                    <iframe width="560" height="315" src="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAP_API_KEY')}}&q=place_id:{{$mission->place_id}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </section>
            </div> 
            <!-- end step  -->
        </div>
    </div>
</section>
<script src="{{ asset('assets/js/jquery.steps.min.js') }}"></script>
<script>
    // Jquery
    $(document).ready(function($){
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
            },
            onFinished: function (event, currentIndex) {
                window.location.href = "{{ route('mission.confirm', ['id' => ':id']) }}".replace(':id', {{$mission->id}});
            }
        });
    });
</script>

<style>
    .bg-body-tertiary{
        background: #f8f9fa
    }
</style>
    <script>
        $('#btn-copy').on('click', function() {
            var content = $('#content-mission').text();
            var $tempInput = $('<textarea>');
            $('body').append($tempInput);
            $tempInput.val(content).select();
            document.execCommand('copy');
            $tempInput.remove();
            showAlert('Đã sao chép nội dung!');
        });
    </script>
@endsection