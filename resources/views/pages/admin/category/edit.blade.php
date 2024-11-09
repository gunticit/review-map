@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5ad6bf3d69.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script src="{{ asset('./assets/js/map.js') }}"></script>
<script>
    let latitude = Number('<?= $project->latitude ?>');
    let longitude = Number('<?= $project->longitude ?>');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            console.log(latitude, longitude);
        });
    }
</script>
<style>
    #map{
        width: 100%;
        height: 530px;
    }
    .stars i {
        color: #ccc;
    }

    .stars i.filled {
        color: gold;
    }

    .stars i.half {
        background: linear-gradient(90deg, gold 50%, #ccc 50%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .row-coordinate{
        display: flex;
    }
    .relative{
        position: relative
    }
    .row-coordinate{
        position: absolute;
        top: 0;
        right: 0;
        direction: rtl;
        width: 220px;
        z-index: -1;
    }
    .row-coordinate.show{
        z-index: 1;
    }
    .rating-row{
        display: flex;
        gap: 12px
    }
    .map-info{
        position: relative
    }
    #detail-video{
        position: relative;
    }
    #detail-video .btn-play-video{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        background: transparent;
        border: none;
        display: none;
        transition: all ease .4s;
        opacity: 0;
        animation: showBtnVideo 1s ease forwards;
    }
    #detail-video:hover .btn-play-video{
        display: block;
    }
    #detail-video .btn-play-video span{
        font-size: 50px;
        color: #1b1b1b;
    }
    .Tagslist-wrap{
        display: flex;
        flex-wrap: wrap;
    }
    .Tagslist-wrap span {
        border-radius: 8px;
        background-color: #FAFAFA;
        color: #96A3BE;
        padding: 6px 8px;
        margin-right: 6px;
        margin-bottom: 6px;
        font-size: 12px;
        border:transparent 1px solid;
    }
    .Tagslist-wrap span.active, .Tagslist-wrap span:hover{
        background-color: #eaeaea;
        color: #3d3e3f;
        border: 1px solid #ccc;
    }
    .list-star{
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }
    .list-star p{
        margin-bottom: 0 !important;
    }
    .list-star svg{
        color: #cacaca;
    }
    .list-star svg.active{
        color: #ffa400
    }
    .tags-input-wrapper{
        background: transparent;
        background-color: #FAFAFA;
        border-radius: 8px;
        min-height: 54px;
        box-shadow: unset;
        line-height: 1.3;
        border: 1px solid transparent;
        width: 100%;
        padding: 0.875rem 1.125rem;
        font-size: 0.875rem;
    }
    .tags-input-wrapper input{
        border: none;
        background: transparent;
        outline: none;
        width: 140px;
        margin-left: 8px;
    }
    .tags-input-wrapper .tag{
        display: inline-block;
        background-color: #FAFAFA;
        color: #000000;
        border-radius: 5px;
        padding: 2px 3px 2px 10px;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .tags-input-wrapper .tag a {
        margin: 0 7px;
        display: inline-block;
        cursor: pointer;
    }
        /* Đảm bảo ô search có z-index cao hơn modal */
    #search-places {
        position: relative;
        z-index: 1050; /* Số z-index cao hơn modal */
        right: 0;
        width: 80%;
    }

    /* Đảm bảo kết quả tìm kiếm không bị che mất */
    #map {
        position: relative;
        z-index: 1050; /* Số z-index cao hơn modal */
    }
    .pac-container{
        z-index: 9999;
    }
    #infowindow-content{
        text-align: center;
    }
    #infowindow-content p{
        margin-bottom: 5px;
    }
    #place-name{
        margin: 10px 0;
        text-align: center;
    }
    #info-map-reviews h3{
        margin-bottom: 5px;
    }
    #info-map-reviews p{
        margin-bottom: 5px;
    }
    .border-error{
        border: 1px solid #f00 !important;
    }
    .btn-check-map{
        background: #b0b0b0;
        color: #3c3b3b;
        border: transparent;
        cursor: pointer;
        transition: all ease .4s
    }
    .btn-check-map:hover{
        background: #c1c1c1;
        color: #3c3b3b;
    }
    .btn-check-map.border-error{
        border: 1px solid #f00;
        background: #f1f1f1;
    }
    @keyframes showBtnVideo{
        from{
            opacity: 0;
        }
        to{
            opacity: 1;
        }
    }
</style>
<!-- tao-du-an -->
<section class="section tao-du-an mb-5 mt-5">
    <div class="loading-section">
        <div class="loading-wave">
          <div class="loading-bar"></div>
          <div class="loading-bar"></div>
          <div class="loading-bar"></div>
          <div class="loading-bar"></div>
        </div>
    </div>
    <form action="{{ route('project.update', ['id' => $project->id]) }}" id="form-create-project" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <!-- cot 1 -->
                <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                        <h2 class="section-title mb-4">Chi tiết dự án</h2>
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
                        <div class="mb-4"><!-- class: invalid -->
                            <label for="inputlist-table">Tên dự án <span class="required">*</span>
                            </label>
                            <input class="form-control require" id="inputlist-table" name="name" type="text" placeholder="RIVI" value="{{ $project->name }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="d-none">Tên dự án cho phép dưới 50 ký tự bao gồm các khoảng trắng.</small>
                        </div>
                        <!-- Form Group (UrlMap)-->
                        <div class="mb-4"><!-- class: active -->
                            <label>
                                Chọn Map <span style="margin-left: 5px" class="required">*</span>
                            </label>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary btn-check-map col-sm-12" data-bs-toggle="modal" data-bs-target="#CheckUrl"><span style="margin-right: 5px">Nhấn để Map</span> <i class="fa fa-map-pin" aria-hidden="true"></i></button>
                                </div>
                                <input id="lat" type="hidden" name="latitude" value="{{ $project->latitude }}" />
                                <input id="long" type="hidden" name="longitude" value="{{ $project->place_id }}" />
                                <input id="place-id" type="hidden" name="place_id" value="{{ $project->place_id }}" />
                            </div>
                        </div>
                        <!-- Form Group (Description)-->
                        <div class="mb-4">
                            <label for="inputDescription">Mô tả dự án
                            </label>
                            <textarea class="form-control" name="description" id="inputDescription" placeholder="Nhập mô tả"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <!-- Form Group (Review)-->
                                <div class="mb-4">
                                    <label for="inputReview">Chọn gói review <span class="required">*</span>
                                    </label>
                                    <select class="form-control form-select require" name="package" id="inputReview" required>
                                        <option <?= !isset($project->package) ? 'selected' : '' ?> value="">--- Chọn gói ---</option>
                                        <option <?= $project->package == 1 ? 'selected' : '' ?> value="1">RIVI10 - 45.000 VND/đánh giá - 10 lượt đánh giá</option>
                                        <option <?= $project->package == 2 ? 'selected' : '' ?> value="2">RIVI50 - 35.000 VND/đánh giá - 50 lượt đánh giá</option>
                                        <option <?= $project->package == 3 ? 'selected' : '' ?> value="3">RIVI100 - 30.000 VND/đánh giá - 100 lượt đánh giá</option>
                                        <option <?= $project->package == 4 ? 'selected' : '' ?> value="4">RIVI200 - 25.000 VND/đánh giá - 200 lượt đánh giá</option>
                                    </select>
                                    @error('package')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <!-- Form Group (RaiCham)-->
                                <div class="mb-4 RaiCham">
                                    <label for="inputRaiCham">
                                        Rải chậm
                                    </label>
                                    <button type="button" class="btn" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Rải chậm là hình thức đánh giá review mỗi ngày.
                                Ví dụ: Nếu bạn nhập số lượng rải chậm là 2 tương đương dự án của bạn sẽ nhận 2 lượt đánh giá mỗi ngày">
                                        <span class="material-symbols-outlined">info</span>
                                    </button>
                                    <div class="input-group" id="group-raicham">
                                        <span class="input-group-text" for="inputRaiChamCheck">
                                            <input type="checkbox" <?= $project->is_slow ? 'checked' : '' ?> name="is_slow" class="form-check-input" id="inputRaiChamCheck">
                                        </span>
                                        <input type="number" min="2" name="point_slow" value="{{ $project->point_slow }}" readonly class="form-control" id="inputRaiCham">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Form Group (Tags)-->
                        <div class="mb-4">
                            <label for="Tagslist-table">Từ khóa <span class="required">*</span>
                            </label>
                            <div class="Tagslist-wrap">
                                <span>Đồ uống ngon</span>
                                <span>Yên tĩnh</span>
                                <span>Nhân viên thân thiện</span>
                                <span>Náo nhiệt</span>
                                <span>Không gian đẹp</span>
                                <span>Ưu đãi hấp dẫn</span>
                            </div>
                            <input class="form-control" id="Tagslist-table" type="text" name="keyword" placeholder="Enter để ngắt từ khóa">
                            @error('keyword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Form Group (Img)-->
                        <div class="inputImg"><!-- class: active -->
                            <label class="d-block" for="inputImg">Hình ảnh
                            </label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_image" id="inputImg1" value="1">
                                <label class="form-check-label" for="inputImg1"> Có </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_image" id="inputImg2" value="0" checked>
                                <label class="form-check-label" for="inputImg2"> Không </label>
                            </div>
                            <div class="d-none" id="group-upload-image">
                                <p>
                                    <small>Các hình ảnh bắt buộc phải được chụp bằng thiết bị thật, chúng tôi sẽ phân phối mỗi đánh giá kèm với 1 ảnh. Đánh giá có ảnh sẽ được phân phối ngẫu nhiên xen kẽ với đánh giá chỉ có chữ.</small>
                                </p>
                                <p>
                                    <small>Số lượng ảnh không vượt quá 10% số lượng gói đánh giá. Định dạng ảnh là (*.jpeg, *.png). Giá của 1 tấm ảnh là 5k/tấm.</small>
                                </p>
                                <div id="fileUpload"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- cot 2 -->
                <div class="col-xl-4 col-md-12 col-12 ">
                    <div class="col-inner col-guide">
                        <div id="info-map-reviews">
                            <h3>{{ $project->name }}</h3>
                            <div class="list-star">
                                <span>{{ $project->rating_google }}</span>
                                <p>
                                    <i class="fa fa-star {!! (int)$project->total_rating_google >= 1 ? 'active' : ''!!}"></i>
                                    <i class="fa fa-star {!! (int)$project->total_rating_google >= 2 ? 'active' : ''!!}"></i>
                                    <i class="fa fa-star {!! (int)$project->total_rating_google >= 3 ? 'active' : ''!!}"></i>
                                    <i class="fa fa-star {!! (int)$project->total_rating_google >= 4 ? 'active' : ''!!}"></i>
                                    <i class="fa fa-star {!! (int)$project->total_rating_google >= 5 ? 'active' : ''!!}" aria-hidden="true"></i>
                                </p>
                                {{ $project->total_rating_google }}
                            </div>
                            <p>{{ $project->address_google }}</p>
                            <p>{{ $project->telephone_google }}</p>
                            <div class="rating-row">
                                <h4>Đánh giá: <span id="avg-rating">{{ $project->rating_google }}</span></h4>
                                <span>{{ $project->total_rating_google }}</span>
                            </div>
                            <div id="rating-desire-group">
                                <input type="hidden" name="rating_google" id="rating-google" value="{{ $project->rating_google ?? 0 }}"/>
                                <input type="text" onchange="handleRatingDesire()" step="0.1" min="4.1" max="4.9" class="form-control" value="{{ $project->rating_desire }}" name="rating_desire" id="rating-desire"/>
                            </div>
                        </div>
                        <div id="video-intro">
                            <h2>Hướng dẫn lấy URL</h2>
                            <div id="detail-video">
                                <button onclick="playPause()" type="button" class="btn-play-video">
                                    <span class="material-symbols-outlined">
                                        play_circle
                                    </span>
                                </button>
                                <video id="video1" width="420" style="max-width: 100%;">
                                    <source src="{{ asset('assets/video/mov_bbb.mp4') }}" type="video/mp4">
                                    <source src="{{ asset('assets/video/mov_bbb.ogg') }}" type="video/ogg">
                                    Your browser does not support HTML video.
                                </video>
                            </div>
                        </div>
                        <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/MLpWrANjFbI?si=ZGXqWQK6lxYSxRAW" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
                        <h3 class="col-title">Rải chậm</h3>
                        <p>Rải chậm giúp các đánh giá thật hơn. Chi phí rải chậm một ngày là 2.000 VND</p>
                        <h3 class="col-title">Từ khóa</h3>
                        <p>RIVI AI sẽ dùng trí tuệ nhân tạo để tạo ra các nội dung đánh giá bám sát vào sản phẩm/dịch vụ của bạn. <br>
                            <strong>Ví dụ:</strong> Khi bạn có từ khóa “Cà phê ngon” thì RIVI AI sẽ tạo ra các nội dung sau:
                        </p>
                        <ul>
                            <li>Quán cà phê ngon, đồ uống bổ dưỡng, không gian thoải mái, phục vụ nhanh nhẹn</li>
                            <li>Không gian quán cà phê ngon và ấm cúng, đồ uống tuyệt vời, nhân viên thân thiện</li>
                            <li>Đồ uống tại quán cà phê ngon và đa dạng , không gian sang trong và sạch sẽ</li>
                            <li>Quán cà phê ngon, đồ uống chất lượng, không gian yên tĩnh và thư giãn</li>
                        </ul>
                        <input class="btn btn-primary btn-full" type="button" id="btn-submit" value="Đặt đơn" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<!-- end list-table -->
<!-- Modal Change Password -->
<div class="modal fade CheckUrl" id="CheckUrl" tabindex="-1" aria-labelledby="CheckUrlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="map-info">
                    <input id="search-places" placeholder="Nhập theo cú pháp: Cửa hàng + Địa chỉ" type="text" class="controls form-control" >
                    <div id="map"></div>
                    <div id="infowindow-content">
                        <h2 id="place-name" class="title"></h2>
                        <p id="place-address"></p>
                        <p id="place-telephone"></p>
                        <p id="place-rate"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="confirm-url-map">Xác nhận</button>
            </div>
        </div>
    </div>
</div>
<!-- Jquery table input Tags -->
<script src="{{ asset('./assets/js/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('./assets/js/fileUpload.js') }}"></script>
<script>
    // Jquery 
    jQuery(document).ready(function($) {
        //Jquery table input Tags
        var tagInput1 = new TagsInput({
            selector: 'Tagslist-table',
            duplicate : false,
            max : 10
        });
        tagInput1.addData([]);

        // file Upload
        $("#fileUpload").fileUpload();
        $('#confirm-url-map').on('click', function(){
            $('#CheckUrl').modal('hide');
            $('#video-intro').hide();
            $('#info-map-reviews').show();
            
            if($('#place-id').val() == ''){
                $('.btn-check-map').addClass('border-error');
            }else{
                $('.btn-check-map').removeClass('border-error');
            }
        });
    });
</script> 
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap&fields=id,displayName,rating,reviews,userRatingCount&libraries=places&v=weekly" defer></script>
    <script>
        function addTag(tagText) {
            var exists = false;
            $('.tags-input-wrapper .tag').each(function() {
                if ($(this).text().trim() == tagText + '×') {
                    $(this).remove();
                    exists = true;
                    return false;
                }
            });
            if (!exists) {
                var newTag = $('<span class="tag">' + tagText + '<a>×</a></span>');
                $('.tags-input-wrapper').prepend(newTag);
            }
        }
        $('.Tagslist-wrap > span').click(function(){
            $(this).toggleClass('active');
            let value = $(this).text();
            addTag(value.trim());
        })
        $(document).on('click', '.tags-input-wrapper .tag a', function() {
            var textCheck = $(this).parent().text().trim(); 
            textCheck = textCheck.replace("×", ""); 

            $('.Tagslist-wrap span').each(function() {
                var tagText = $(this).text().trim(); 
                if (tagText === textCheck) { 
                    $(this).removeClass('active'); 
                    return false; 
                }
            });

            $(this).parent().remove(); // Xóa tag từ danh sách tags-input-wrapper
        });

        // Rating
        function handleRateChange(event, rating){
            $('#info-map-reviews .group-reviews-alert').remove();
            let rate = event.target.value;
            let message = '';
            let errors = false;
            if(rate > 0 && rate < 5){
                errors = false;
            }else{
                errors = true;
                if(rate < 0){
                    $('#changeRate').val(0);
                    message = 'Giá trị đánh giá từ 0 đến 5';
                }
                if(rate > 5){
                    $('#changeRate').val(5);
                    message = 'Giá trị đánh giá không quá 5';
                }
            }
            if (errors) {
                $('#info-map-reviews').append(`
                    <div class="group-reviews-alert">
                        <p class="text-danger">${message}</p>
                    </div>
                `);
            } else {
                $('#info-map-reviews').append(`
                    <div class="group-reviews-alert">
                        <p class="text-success">${message}</p>
                    </div>
                `);
            }
            setTimeout(() => {
                $('#info-map-reviews .group-reviews-alert').remove();
            }, 3500);
        }
        // $('#inputReview').on('change', function(){
        //     if($(this).val()){
        //         $('#inputRaiCham').prop('readonly',false);
        //         $('#inputRaiChamCheck').prop('checked', true);
        //         $('#inputRaiCham').focus();
        //     }else{
        //         $('#inputRaiCham').prop('readonly',true);
        //         $('#inputRaiChamCheck').prop('checked', false);
        //     }
        // })
        $('#inputRaiChamCheck').on('change', function(){
            if($(this).is(':checked')){
                $('#inputRaiCham').prop('readonly',false);
                $('#inputRaiChamCheck').prop('checked', true);
                $('#inputRaiCham').focus();
            }else{
                $('#inputRaiCham').prop('readonly',true);
                $('#inputRaiChamCheck').prop('checked', false);
            }
        });
        $('#inputRaiCham').on('change', function(){
            $('#group-raicham small').remove();
            let review = $('#inputReview').val();
            const data = $(this).val();
            if(data <= 2){
                $(this).val(2);
            }
            if(data > 2 && review == 1){
                $('#group-raicham').append(`<small class="text-danger">Bạn nên rải chậm để các review trông có vẻ thật nhất. Không nên đánh giá quá nhiều trong 1 ngày sẽ giảm số lượng hiển thị review. Số lượng rải chậm nhiều hơn 2 đánh giá và ít hơn 10% số lượng gói mua</small>`);
                if(data > 10){
                    $(this).val(10);
                }
            }
            if(data > 5 && review == 2){
                $('#group-raicham').append(`<small class="text-danger">Bạn nên rải chậm để các review trông có vẻ thật nhất. Không nên đánh giá quá nhiều trong 1 ngày sẽ giảm số lượng hiển thị review. Số lượng rải chậm nhiều hơn 2 đánh giá và ít hơn 10% số lượng gói mua</small>`);
                $(this).val(5);
            }
            if(data > 10 && review == 3){
                $('#group-raicham').append(`<small class="text-danger">Bạn nên rải chậm để các review trông có vẻ thật nhất. Không nên đánh giá quá nhiều trong 1 ngày sẽ giảm số lượng hiển thị review. Số lượng rải chậm nhiều hơn 2 đánh giá và ít hơn 10% số lượng gói mua</small>`);                
                $(this).val(10);
            }
            if(data > 20 && review == 3){
                $('#group-raicham').append(`<small class="text-danger">Bạn nên rải chậm để các review trông có vẻ thật nhất. Không nên đánh giá quá nhiều trong 1 ngày sẽ giảm số lượng hiển thị review. Số lượng rải chậm nhiều hơn 2 đánh giá và ít hơn 10% số lượng gói mua</small>`);
                $(this).val(20);
            }
            setTimeout(() => {
                $('#group-raicham small').remove();
            }, 5000);
        });
        // Upload image
        $('input[name=has_image]').on('change', function(){
            if($(this).is(':checked') && $(this).val() === '1'){
                $('#group-upload-image').removeClass('d-none');
            }else if($(this).val() === '0'){
                $('#group-upload-image').addClass('d-none');
            }  
        });
        var myVideo = document.getElementById("video1"); 

        function playPause() { 
            if (myVideo.paused){
                $('#detail-video .btn-play-video *').remove();
                $('#detail-video .btn-play-video').html(`<span class="material-symbols-outlined">
                pause_circle
                </span>`);
                myVideo.play(); 
            }else{
                $('#detail-video .btn-play-video *').remove();
                $('#detail-video .btn-play-video').html(`<span class="material-symbols-outlined">
                play_circle
                </span>`);
                myVideo.pause();
            }
                
        } 
        $(document).ready(function() {
            function validateRequiredFields() {
                $('.alert').remove();
                $('.require').each(function() {
                    if ($(this).val() === '') {
                        $(this).addClass('border-error');
                        var alertMessage = $('<div class="alert text-danger">Bắt buộc nhập dữ liệu</div>');
                        $(this).after(alertMessage);
                        $(this).addClass('error');
                        return false;
                    } else {
                        $(this).removeClass('border-error');
                        $(this).removeClass('error');
                    }
                });
                if($('#place-id').val() == ''){
                    $('.btn-check-map').addClass('border-error');
                    return false;
                }else{
                    $('.btn-check-map').removeClass('border-error');
                }
                if($('.tags-input-wrapper .tag').length == 0){
                    $('.tags-input-wrapper').addClass('border-error');
                    return false;
                }else{
                    $('.tags-input-wrapper').removeClass('border-error');
                }
                if($('body #rating-desire').val() == 0 || $('body #rating-desire').val() == null || $('body #rating-desire').val() == ''){
                    $('body #rating-desire').addClass('border-error');
                    $('body #rating-desire-group').append('<p class="alert text-danger">Vui lòng nhập giá trị mong muốn</p>');
                    return false;
                }
                return true;
            }
            $('.tags-input-wrapper').on('change', function(){
                if($('.tags-input-wrapper .tag').length == 0){
                    $('.tags-input-wrapper').addClass('border-error');
                }else{
                    $('.tags-input-wrapper').removeClass('border-error');
                }
                $(this).parent().find('.alert.text-danger').remove();
            });
            $('.Tagslist-wrap span').on('click', function(){
                if($('.tags-input-wrapper .tag').length == 0){
                    $('.tags-input-wrapper').addClass('border-error');
                    return false;
                }else{
                    $('.tags-input-wrapper').removeClass('border-error');
                }
                $(this).parent().parent().find('.alert.text-danger').remove();
            });
            $('.require').on('change', function(){
                if($(this).val()){
                    $(this).removeClass('border-error');
                    $(this).removeClass('error');
                    $(this).parent().find('.alert.text-danger').remove();
                }
            });
            $('#btn-submit').on('click', function(e){
                e.preventDefault();
                let checkValidate = validateRequiredFields();
                
                if ($('.alert').length === 0 && checkValidate) {
                    $('#form-create-project').submit();
                }
            }); 
        });
    </script>
@endsection