@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5ad6bf3d69.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
<script>
    let latitude = Number('<?= $latitude ?>');
    let longitude = Number('<?= $longitude ?>');
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
        position: relative;
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
    .loader {
        width: 48px;
        height: 48px;
        display: inline-block;
        position: relative;
    }
    .loading-section{
        display: none;
        position: absolute;
        z-index: 9;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: hsl(205.71deg 24.14% 17.06% / 32.16%);
    }
    .loading-section .loader{
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #btn-generate-keyword{
        right: 0;
        position: absolute;
        bottom: 0;
        padding: 3px;
        z-index: 1;
        display: none;
    }
    #btn-generate-keyword > span{
        font-size: 20px;
    }
    .group-tags{
        position: relative;
    }
    .Tagslist-wrap > div.isloading{
        position: absolute;
        z-index: 1;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgb(0 0 0 / 12%);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }
    .Tagslist-wrap > div > span{
        background: transparent;
        padding: 0;
    }
    .Tagslist-wrap > div.isloading > span {
        width: 60px;
        aspect-ratio: 2;
        --_g: no-repeat radial-gradient(circle closest-side, rgb(146 147 147 / 85%) 90%, transparent);
        background: var(--_g) 0% 50%, var(--_g) 50% 50%, var(--_g) 100% 50%;
        background-size: calc(100% / 3) 50%;
        animation: loader-keywords 1s infinite linear;
        height: 30px;
    }
    #inputRaiCham{
        text-align: center;
    }
    #btn-minus-rai-cham, #btn-plus-rai-cham{
        position: absolute;
        top: 0;
        z-index: 2;
        border: 1px solid #ffffff;
        background: #ededed;
        padding: 11px;
    }
    #btn-minus-rai-cham{
        left: 0;
    }
    #btn-plus-rai-cham{
        right: 0;
    }
    #charCount {
        margin-top: 5px;
        font-size: 14px;
        color: #555;
        text-align: right;
    }

    #charCount.error {
        color: red;
    }
    #inputDescription.error{
        border: 1px solid red;
    }
    @keyframes loader-keywords {
        20%{background-position:0%   0%, 50%  50%,100%  50%}
        40%{background-position:0% 100%, 50%   0%,100%  50%}
        60%{background-position:0%  50%, 50% 100%,100%   0%}
        80%{background-position:0%  50%, 50%  50%,100% 100%}
    }
    .loader::after,
    .loader::before {
        content: '';  
        box-sizing: border-box;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 2px solid #FFF;
        position: absolute;
        left: 0;
        top: 0;
        animation: animloader 2s linear infinite;
        }
        .loader::after {
        animation-delay: 1s;
        }

        @keyframes animloader {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(1);
            opacity: 0;
        }
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
        <span class="loader"></span>
    </div>
    <form action="{{ route('project.store') }}" id="form-create-project" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="container-fluid">
            <div class="row">
                <!-- cot 1 -->
                <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                    @if ($errors->any())
                        <div class="alert alert-danger fw-400">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger fw-400">
                            {{ session('error') }}
                        </div>
                    @endif
                    @include('partials.alerts')
                    <div class="col-inner">
                        <h2 class="section-title mb-4">{{ __('project.create_project') }}</h2>
                        <!-- Form Group (list-table)-->
                        <div class="mb-4"><!-- class: invalid -->
                            <div class="row">
                                <div class="col-sm-3 d-none">
                                    <label for="inputlist-table">{{ __('Mã dự án') }} <span class="required">*</span>
                                    </label>
                                    <input class="form-control require" id="project-code" readonly name="project_code" type="text" placeholder="RIVI" value="" required>
                                </div>
                                <div class="col-sm-12">
                                    <label for="inputlist-table">{{ __('project.name') }} <span class="required">*</span>
                                    </label>
                                    <input class="form-control require" id="name-project" name="name" type="text" placeholder="RIVI" value="" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="d-none">Tên dự án cho phép dưới 50 ký tự bao gồm các khoảng trắng.</small>
                                </div>
                            </div>
                        </div>
                        <script>
                            function removeAccents(str) {
                                str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, ''); // Loại bỏ dấu
                                str = str.replace(/đ/g, 'd').replace(/Đ/g, 'D'); // Thay thế đ và Đ
                                return str;
                            }
                            function getFirstLettersFromInput(selector) {
                                var text = $(selector).val();
                                var words = removeAccents(text).split(' ');
                                var initials = '';

                                words.forEach(function(word) {
                                    initials += word.charAt(0).toUpperCase();
                                });

                                return initials;
                            }
                            $('#name-project').keyup(function(){
                                let project_code = getFirstLettersFromInput('#name-project');
                                $('#project-code').val('RIVI_' + project_code + '_' + Math.floor((Math.random() * 100) + 1));
                            });
                        </script>
                        <!-- Form Group (UrlMap)-->
                        <div class="mb-4"><!-- class: active -->
                            <label>{{ __('project.choose_map') }} <span style="margin-left: 5px" class="required">*</span>
                            </label>
                            <div class="row">
                                <div class="col-12">
                                    <div id="preview-map"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 group-check-map">
                                    <button type="button" class="btn btn-primary btn-check-map col-sm-12" data-bs-toggle="modal" data-bs-target="#CheckUrl"><span style="margin-right: 5px">{{ __('project.press_to_choose') }}</span> <i class="fa fa-map-pin" aria-hidden="true"></i></button>
                                </div>
                                <input id="lat" type="hidden" name="latitude" />
                                <input id="long" type="hidden" name="longitude" />
                                <input id="place-id" type="hidden" name="place_id" />
                            </div>
                        </div>
                        <!-- Form Group (Description)-->
                        <div class="mb-4">
                            <label for="inputDescription">{{ __('project.description') }} <span style="margin-left: 5px" class="required">*</span>
                            </label>
                            <div class="textarea-container">
                                <textarea class="form-control" name="description" id="inputDescription" placeholder="{{ __('project.placeholder_description') }}"></textarea>
                                <div id="charCount">0/300 ký tự</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <!-- Form Group (Review)-->
                                <div class="mb-4">
                                    <label for="inputReview">{{ __('project.review_package') }} <span class="required">*</span>
                                    </label>
                                    <select class="form-control form-select require" name="package" id="inputReview" required>
                                        <option value="">--- {{ __('project.choose_package') }} ---</option>
                                        <option value="1">RIVI10 - 45.000 VND/đánh giá - 10 lượt đánh giá</option>
                                        <option value="2">RIVI50 - 35.000 VND/đánh giá - 50 lượt đánh giá</option>
                                        <option value="3">RIVI100 - 30.000 VND/đánh giá - 100 lượt đánh giá</option>
                                        <option value="4">RIVI200 - 25.000 VND/đánh giá - 200 lượt đánh giá</option>
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
                                        {{ __('project.slow_spread') }}
                                    </label>
                                    <button type="button" class="btn" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Rải chậm là hình thức đánh giá review mỗi ngày.
                                Ví dụ: Nếu bạn nhập số lượng rải chậm là 2 tương đương dự án của bạn sẽ nhận 2 lượt đánh giá mỗi ngày">
                                        <span class="material-symbols-outlined">info</span>
                                    </button>
                                    <div class="input-group" id="group-raicham">
                                        <span class="input-group-text" for="inputRaiChamCheck">
                                            <input type="checkbox" name="is_slow" class="form-check-input" id="inputRaiChamCheck">
                                        </span>
                                        <div style="position: relative;flex: 1;">
                                            <button class="btn btn-outline-secondary" type="button" id="btn-minus-rai-cham" style="display:none">
                                                <span class="material-symbols-outlined">
                                                    remove
                                                </span>
                                            </button>
                                            <input type="number" value="" min="1" name="point_slow" readonly class="form-control" id="inputRaiCham">
                                            <button class="btn btn-outline-secondary" type="button" id="btn-plus-rai-cham" style="display:none">
                                                <span class="material-symbols-outlined">
                                                    add
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="alert-du-kien"></div>
                            </div>
                        </div>
                        <!-- Form Group (Tags)-->
                        <div class="mb-4 group-tags">
                            <label for="Tagslist-table" class="d-flex gap-2">
                                <span class="material-symbols-outlined">
                                    info
                                </span> 
                                 {{ __('project.keyword') }} 
                                 <span class="required">*</span>
                            </label>
                            
                            <div class="mb-2 d-flex">
                                <button type="button" id="btn-generate-keyword" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tạo mới bộ từ khóa">
                                    <span class="material-symbols-outlined">
                                        source_notes
                                    </span>
                                </button>
                                <span>Tạo mới bộ từ khóa</span>
                            </div>
                            <div class="Tagslist-wrap">
                                <span>Vui vẻ</span>
                                <span>Thân thiện</span>
                                <span>Thoải mái</span>
                                <div><span></span></div>
                            </div>
                            <input class="form-control" id="Tagslist-table" type="text" name="keyword" placeholder="Enter để ngắt từ khóa">
                            <input class="form-control hidden" hidden id="keyword_value" type="text" name="keyword_value" readonly>
                            @error('keyword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Form Group (Img)-->
                      <div class="inputImg">
                            <label class="d-block" for="inputImg">{{ __('project.images') }}</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_image" id="inputImg1" value="1">
                                <label class="form-check-label" for="inputImg1"> Có </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_image" id="inputImg2" value="0" checked>
                                <label class="form-check-label" for="inputImg2"> Không </label>
                            </div>
                            <div class="d-none" id="group-upload-image">
                                <div id="fileUpload"></div>
                                <p>
                                    <small>Các hình ảnh bắt buộc phải được chụp bằng thiết bị thật, chúng tôi sẽ phân phối mỗi đánh giá kèm với 1 ảnh. Đánh giá có ảnh sẽ được phân phối ngẫu nhiên xen kẽ với đánh giá chỉ có chữ.</small>
                                </p>
                                <p>
                                    <small>Số lượng ảnh không vượt quá 10% số lượng gói đánh giá. Định dạng ảnh là (*.jpeg, *.png). Giá của 1 tấm ảnh là 5k/tấm.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- cot 2 -->
                <div class="col-xl-4 col-md-12 col-12 ">
                    <div class="col-inner col-guide">
                        <div id="info-map-reviews" style="display:none"></div>
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
                        <h3 class="col-title">{{ __('project.slow_spread') }}</h3>
                        <p>{{ __('project.desc_slow_spread', ['price' => formatVND($setting_price_slow)]) }}</p>
                        <h3 class="col-title">{{ __('project.keyword') }}</h3>
                        <p>{{ __('project.desc_keyword_1') }}<br>
                            <strong>{{ __('project.example') }}:</strong> {{ __('project.desc_keyword_1') }}
                        </p>
                        <ul>
                            <li>{{ __('project.desc_sub_slow_1') }}</li>
                            <li>{{ __('project.desc_sub_slow_2') }}</li>
                            <li>{{ __('project.desc_sub_slow_3') }}</li>
                            <li>{{ __('project.desc_sub_slow_4') }}</li>
                        </ul>
                        <input class="btn btn-primary btn-full" type="button" id="btn-submit" value="{{ __('project.order') }}" />
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
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">{{ __('common.text_button.close') }}</button>
                <button type="button" class="btn btn-primary" id="confirm-url-map">{{ __('common.text_button.confirm') }}</button>
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
        $("#fileUpload").fileUpload({
            maxFileCount: function() {
                // Giới hạn số lượng tệp theo gói đánh giá đã chọn
                let selectedPackage = $('#inputReview').val();
                switch (selectedPackage) {
                    case "1": case 1:
                        return Math.ceil(10 * parseInt('{{ $maxSetting }}') / 100);
                    case "2": case 2:
                        return Math.ceil(50 * parseInt('{{ $maxSetting }}') / 100); // Giới hạn 50 tệp cho gói này
                    case "3": case 3:
                        return Math.ceil(100 * parseInt('{{ $maxSetting }}') / 100); // Giới hạn 100 tệp cho gói này
                    case "4": case 4:
                        return Math.ceil(200 * parseInt('{{ $maxSetting }}') / 100); // Giới hạn 200 tệp cho gói này
                    default:
                        return 0; // Không giới hạn
                }
            },
            minFileCount: function() {
                // Giới hạn số lượng tệp theo gói đánh giá đã chọn
                let selectedPackage = $('#inputReview').val();
                console.log('selectedPackage',selectedPackage);
                console.log('minSetting',parseInt('{{ $minSetting }}'));
                switch (selectedPackage) {
                    case "1": case 1:
                        return Math.ceil(10 * parseInt('{{ $minSetting }}') / 100);
                    case "2": case 2:
                        return Math.ceil(50 * parseInt('{{ $minSetting }}') / 100); // Giới hạn 50 tệp cho gói này
                    case "3": case 3:
                        return Math.ceil(100 * parseInt('{{ $minSetting }}') / 100); // Giới hạn 100 tệp cho gói này
                    case "4": case 4: 
                        return Math.ceil(200 * parseInt('{{ $minSetting }}') / 100); // Giới hạn 200 tệp cho gói này
                    default:
                        return 0; // Không giới hạn
                }
            },
        });
        $('#confirm-url-map').on('click', function(){
            $('#CheckUrl').modal('hide');
            $('#video-intro').hide();
            $('#info-map-reviews').show();
            let ratingGoogle = $('#rating-google').val();
            if(ratingGoogle == 0){
                ratingGoogle = 0;
            }
            $('.group-check-map .text-danger').remove();
            
            if($('#place-id').val() == ''){
                $('.btn-check-map').addClass('border-error');
                $('.group-check-map').append('<p class="text-danger">Chọn địa điểm cần đánh giá.</p>');
            }else{
                $('.btn-check-map').removeClass('border-error');
                $('.btn-check-map').addClass('btn-success');
                $('.group-check-map .text-danger').remove();
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
                let textValue = tagText.trim();
                let keyword_value = $('#keyword_value').val();
                let keywordArray = keyword_value.split(',');
                keywordArray = keywordArray.filter(keyword => keyword !== null && keyword !== '');
                let index = keywordArray.indexOf(textValue);
                if (index === -1) {
                    keywordArray.push(textValue);
                } else {
                    keywordArray.splice(index, 1);
                }
                keyword_value = keywordArray.join(',');
                $('#keyword_value').val(keyword_value);
                var newTag = $('<span class="tag">' + tagText + '<a>×</a></span>');
                $('.tags-input-wrapper').prepend(newTag);
            }
        }
        $('body').on('click', '.Tagslist-wrap > span', function(){
            $(this).toggleClass('active');
            let value = $(this).text();
            addTag(value.trim());
        })
        $(document).on('click', '.tags-input-wrapper .tag a', function() {
            var textCheck = $(this).parent().text().trim(); 
            textCheck = textCheck.replace("×", ""); 

            let keyword_value = $('#keyword_value').val();
            let keywordArray = keyword_value.split(',');
            let index = keywordArray.indexOf(textCheck);
            if (index > -1) {
                keywordArray.splice(index, 1);
            }
            keyword_value = keywordArray.join(',');
            $('#keyword_value').val(keyword_value);
            $('.Tagslist-wrap span').each(function() {
                var tagText = $(this).text().trim(); 
                if (tagText === textCheck) { 
                    $(this).removeClass('active'); 
                    return false; 
                }
            });

            $(this).parent().remove(); // Xóa tag từ danh sách tags-input-wrapper
        });
        // Check ngay du kien
        function checkDateDuKien(){
            let package_id = $('#inputReview').val();
            let per_day_work = $('#inputRaiCham').val();
            if(parseInt(per_day_work) < 1){
                $('#inputRaiCham').val(1);
                per_day_work = 1;
            }
            per_day_work = parseInt(per_day_work);
            let date_dukien = 10;
            switch(parseInt(package_id)){
                case 1:
                    if(per_day_work < 1){
                        date_dukien = Math.ceil(10 / Math.ceil(10 * {{ $setting_percent_slow }}/100));
                    }else{
                        date_dukien = Math.ceil(10 / per_day_work);
                    }
                    break;
                case 2:
                    if(per_day_work < 1){
                        date_dukien = Math.ceil(50 / Math.ceil(50 * {{ $setting_percent_slow }}/100));
                    }else{
                        date_dukien = Math.ceil(50 / per_day_work);
                    }
                    break;
                case 3:
                    if(per_day_work < 1){
                        date_dukien = Math.ceil(100 / Math.ceil(100 * {{ $setting_percent_slow }}/100));
                    }else{
                        date_dukien = Math.ceil(100 / per_day_work);
                    }
                    break;
                case 4:
                    if(per_day_work < 1){
                        date_dukien = Math.ceil(200 / Math.ceil(200 * {{ $setting_percent_slow }}/100));
                    }else{
                        date_dukien = Math.ceil(200 / per_day_work);
                    }
                    break;
                default:
                    date_dukien = Math.ceil(10 / (10 * {{ $setting_percent_slow }}/100));
                    break;
            }
            $('#alert-du-kien').html(`<p>Số ngày dự kiến hoàn thành là <span class="text-danger">${date_dukien}</span> ngày. <br />Chi phí: <span class="text-danger">${(parseInt(date_dukien) * parseInt({{$setting_price_slow}})).toLocaleString('vi-VN')}</span> vnđ</p>`);
        }
                
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
        $('#inputReview').on('change', function(){
        //     if($(this).val()){
        //         $('#inputRaiCham').prop('readonly',false);
        //         $('#inputRaiChamCheck').prop('checked', true);
        //         $('#inputRaiCham').focus();
        //     }else{
        //         $('#inputRaiCham').prop('readonly',true);
        //         $('#inputRaiChamCheck').prop('checked', false);
        //     }
            if($('#inputRaiChamCheck').is(':checked')){
                checkDateDuKien();
            }
        })
        $('#inputRaiChamCheck').on('change', function(e){
            let inputReview = $('#inputReview').val().trim();
            if(!inputReview){
                showAlert('warning', 'Vui lòng chọn gói review trước');
                e.preventDefault();
                $(this).prop('checked', false);
                return false;
            }
            if($(this).is(':checked')){
                $('#btn-minus-rai-cham').show();
                $('#btn-plus-rai-cham').show();
                // $('#inputRaiCham').prop('readonly',false);
                $('#inputRaiCham').val(0);
                $('#inputRaiChamCheck').prop('checked', true);
                // $('#inputRaiCham').focus();

                // Tinh ngay du kien
                checkDateDuKien();
            }else{
                // $('#inputRaiCham').prop('readonly',true);
                $('#btn-minus-rai-cham').hide();
                $('#btn-plus-rai-cham').hide();
                $('#inputRaiCham').val('');
                $('#inputRaiChamCheck').prop('checked', false);
                $('#alert-du-kien').html('');
            }
        });
        $('#inputRaiCham').on('change', function(e){
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
            if(data > 20 && review == 4){
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
            $('body').on('change', '.tags-input-wrapper', function(){
                if($('.tags-input-wrapper .tag').length == 0){
                    $('.tags-input-wrapper').addClass('border-error');
                }else{
                    $('.tags-input-wrapper').removeClass('border-error');
                    $('.group-tags .text-danger').remove();
                }
                $(this).parent().find('.alert.text-danger').remove();
            });
            $('body').on('click', '.Tagslist-wrap span', function(){
                if($('body .tags-input-wrapper .tag').length == 0){
                    $('body .tags-input-wrapper').addClass('border-error');
                    return false;
                }else{
                    $('body .tags-input-wrapper').removeClass('border-error');
                    $('.group-tags .text-danger').remove();
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
            $('#inputDescription').on('change', function(){
                if($(this).val() == ''){
                    $('#btn-generate-keyword').hide();
                    return false;
                }
                $('#btn-generate-keyword').show();
            })
            // Generate keyword
            $('#btn-generate-keyword').on('click', function(){
                let description = $('#inputDescription').val();
                if(description == '') return false;
                $.ajax({
                    url: "{{ route('generate.keyword') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        description: description
                    }, 
                    beforeSend: function(){
                        $('.Tagslist-wrap > div').addClass('isloading');
                    },
                    success: function(response) {
                        if(response.status == 'success' && response.data){
                            response.data.forEach(keyword => {
                                $('.Tagslist-wrap').append(`<span>${keyword}</span>`);
                            })
                        }
                    },
                    complete: function(){
                        $('.Tagslist-wrap > div').removeClass('isloading');
                    }
                });
            });

            $('#btn-minus-rai-cham').on('click', function(){
                let value = $('#inputRaiCham').val();
                value = parseInt(value);
                let package_id = $('#inputReview').val();
                if(value >= 2 && package_id > 1){
                    $('#inputRaiCham').val(value - 1);
                }
                checkDateDuKien();
            });
            $('#btn-plus-rai-cham').on('click', function(){
                let value = $('#inputRaiCham').val();
                value = parseInt(value);
                let package_id = $('#inputReview').val();
                let max_value = 1;
                switch(parseInt(package_id)){
                    case 1:
                        max_value = 1;
                        break;
                    case 2:
                        max_value = 2;
                        break;
                    case 3:
                        max_value = 5;
                        break;
                    case 4:
                        max_value = 10;
                        break;
                    default:
                        max_value = 1;
                        break;
                }
                if(value < max_value && package_id >= 1){
                    $('#inputRaiCham').val(value + 1);
                }
                checkDateDuKien();
            });
        });
    </script>
    <script>
        // Add preview map
        $('body #confirm-url-map').on('click', function(){
            let place_id = $('body #place-id').val();
            if(place_id != ''){
                $('#preview-map iframe').remove();
                $('#preview-map').html(`<iframe src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAP_API_KEY') }}&q=place_id:${place_id}" 
                width="100%" height="350px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>`);
            }
        });
    </script>
    <script>
        // Đếm số ký tự
        $(document).ready(function () {
            const $textarea = $('#inputDescription');
            const $charCount = $('#charCount');

            $textarea.on('input', function () {
                const textLength = $textarea.val().length;
                $charCount.text(`${textLength}/300 ký tự`);

                if (textLength > 300) {
                    $textarea.addClass('error');
                    $charCount.addClass('error');
                    $('#btn-submit').attr('disabled', true);
                } else {
                    $textarea.removeClass('error');
                    $charCount.removeClass('error');
                    $('#btn-submit').attr('disabled', false);
                }
            });
        });

    </script>
@endsection