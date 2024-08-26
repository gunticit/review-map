@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5ad6bf3d69.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
{{-- <link href="{{ asset('assets/css/bootstrap-tagsinput.css') }}" rel="stylesheet"/> --}}
<script>
    var latitude = parseFloat('<?= $latitude; ?>');
    var longitude = parseFloat('<?= $longitude; ?>');
</script>
<style>
    .inputUrlMap.active .col-md-3{
        cursor: pointer;
    }
    #map{
        width: 100%;
        height: 500px;
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
        border-radius: 40px;
        padding: 0px 3px 0px 7px;
        margin-right: 5px;
        margin-bottom: 5px;
        box-shadow: 0 5px 15px -2px rgb(208 208 208 / 70%);
    }
    .tags-input-wrapper .tag a {
        margin: 0 7px 3px;
        display: inline-block;
        cursor: pointer;
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
    <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row">
                <!-- cot 1 -->
                <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                    <div class="col-inner">
                        <h2 class="section-title mb-4">Tạo dự án</h2>
                        <!-- Form Group (list-table)-->
                        
                        <div class="mb-4"><!-- class: invalid -->
                            <label for="inputlist-table">Tên dự án <span class="required">*</span>
                            </label>
                            <input class="form-control" id="inputlist-table" name="name" type="text" placeholder="RIVI" value="" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="d-none">Tên dự án cho phép dưới 50 ký tự bao gồm các khoảng trắng.</small>
                        </div>
                        <!-- Form Group (UrlMap)-->
                        <div class="mb-4 inputUrlMap "><!-- class: active -->
                            <label for="inputUrlMap">URL Map <span class="required">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-9 col-12 relative">
                                    <input class="form-control" id="inputUrlMap" name="url_map" type="url" placeholder="URL bắt buộc phải là URL, bắt buộc bằng địa chỉ https://maps.app.goo.gl/..." value="" required>
                                    @error('url_map')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="d-none">Sai URL. Vui lòng kiểm tra lại.</small>
                                    <div class="row-coordinate">
                                        <div>
                                            <input class="form-control" placeholder="Latitude" name="lat" id="lat">
                                        </div>
                                        <div>
                                            <input class="form-control" placeholder="Longitude" name="lng" id="lng">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <button type="button" class="btn btn-primary btn-check-map" onclick="handleCheckMap()" data-bs-toggle="modal" data-bs-target="#CheckUrl" disabled> Kiểm tra URL </button>
                                </div>
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
                                    <select class="form-control form-select" name="package" id="inputReview" required>
                                        <option value="">--- Chọn gói ---</option>
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
                                        Rải chậm
                                    </label>
                                    <button type="button" class="btn" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Rải chậm là hình thức đánh giá review mỗi ngày.
                                Ví dụ: Nếu bạn nhập số lượng rải chậm là 2 tương đương dự án của bạn sẽ nhận 2 lượt đánh giá mỗi ngày">
                                        <span class="material-symbols-outlined">info</span>
                                    </button>
                                    <div class="input-group" id="group-raicham">
                                        <span class="input-group-text" id="inputRaiChamCheck">
                                            <input type="checkbox" name="is_slow" class="form-check-input" id="inputRaiChamCheck">
                                        </span>
                                        <input type="number" max="100" name="point_slow" class="form-control" id="inputRaiCham">
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
                            <input class="form-control" id="Tagslist-table" type="text" name="keyword" placeholder="Enter để ngắt từ khóa" value="" required>
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
                        <input class="btn btn-primary btn-full" type="submit" value="Đặt đơn" />
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
                    <input onchange="handleSearchMap(event)" id="search-places" placeholder="Tìm kiếm vị trí" class="form-control" >
                    <div id="map"></div>
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
        //imgs
        $('.inputUrlMap input[name="url_map"]').change(async function() {
            $(".inputUrlMap").toggleClass("active");
            let urlMap = $(this).val();
            if(urlMap) {
                await getLongUrl(urlMap).then(function(res) {
                    if(res.data) {
                        let realUrl = res.data?.long_url ?? '';
                        if (realUrl) {
                            let coordinates = getLatLongFromUrl(realUrl);
                            console.log(coordinates);
                            document.getElementById('lng').value = coordinates.longitude ?? '';
                            document.getElementById('lat').value = coordinates.latitude ?? '';
                            $('.btn-check-map').prop('disabled', false);
                        }
                    }
                })
            }
        });
        $('#confirm-url-map').on('click', function(){
            $('#CheckUrl').modal('hide');
        });
    });
    async function getLongUrl(shortUrl) {
        try {
            let url = "{{ route('get.long.url') }}?url=" + encodeURIComponent(shortUrl); 
            const response = await axios(url);
            return response
        } catch (error) {
            console.error('Error:', error);
        }
    }
    function getLatLongFromUrl(url) {
        const regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
        const match = url.match(regex);
        if (match) {
            latitude = match[1];
            longitude = match[2];
            console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);
        } else {
            console.log('Không tìm thấy tọa độ trong URL.');
        }
        return {
            latitude: latitude,
            longitude: longitude
        };
    }
</script> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsrw-1OJrRbffA0EZ6gcFPJLLgnw8aM6E&libraries=places&callback=initMap" async defer></script>
    <script>
        // Xử lý map
        var map;
        var marker;

        function initMap() {

            // Tạo bản đồ
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                gestureHandling: "greedy",
                center: { lat: latitude, lng: longitude },
            });

            // Tạo marker
            marker = new google.maps.Marker({
                map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: { lat: latitude, lng: longitude },
            });

            // Tạo SearchBox cho ô tìm kiếm
            const input = document.getElementById('search-places');
            const searchBox = new google.maps.places.SearchBox(input);

            // Điều chỉnh kết quả tìm kiếm theo viewport của bản đồ
            map.addListener('bounds_changed', () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener('places_changed', () => {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }

                // Lấy vị trí đầu tiên từ kết quả tìm kiếm
                const place = places[0];

                if (!place.geometry || !place.geometry.location) {
                    console.error("Place không có thông tin về vị trí");
                    return;
                }

                // Di chuyển marker tới vị trí được chọn và cập nhật bản đồ
                marker.setPosition(place.geometry.location);
                map.setCenter(place.geometry.location);

                // Cập nhật giá trị latitude và longitude trong các ô input
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
            });
            marker.addListener("dragend", handleMarkerDragEnd);
        }

        function handleCheckMap() {
            latitude = parseFloat($('#lat').val());
            longitude = parseFloat($('#lng').val());
            console.log(latitude, longitude);

            if (!isNaN(latitude) && !isNaN(longitude) && map) {
                map.setCenter({ lat: latitude, lng: longitude });
                marker.setPosition({ lat: latitude, lng: longitude });
            } else {
                console.error('Tọa độ không hợp lệ hoặc bản đồ chưa được khởi tạo.');
            }
        }
        function handleMarkerDragEnd(event) {
            const newLat = event.latLng.lat();
            const newLng = event.latLng.lng();
            document.getElementById('lat').value = newLat;
            document.getElementById('lng').value = newLng;
        }

        $('#confirm-url-map').on('click', function(){
            latitude = parseFloat($('#lat').val());
            longitude = parseFloat($('#lng').val());
            var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
            var geocoder = new google.maps.Geocoder;
            $('#info-map-reviews *').remove();
            geocoder.geocode({'location': latlng}, async function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                    await getMapInfo(results[1].place_id);
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        });
        function getMapInfo(placeID){
            axios.get(`https://places.googleapis.com/v1/places/${placeID}?fields=id,displayName,rating,reviews,userRatingCount&key=AIzaSyDsrw-1OJrRbffA0EZ6gcFPJLLgnw8aM6E`)
            .then(function (response) {
                let data = response.data ? response.data : {};
                $('#video-intro').hide();
                $('#info-map-reviews').show();
                $('#info-map-reviews').append(`
                <h2>${data?.displayName?.text}</h2>
                <p>Đánh giá trung bình</p>
                <div class="rating-row">
                    <span>${data?.rating}</span>
                    <div class="stars">
                        <i class="fa fa-star" data-value="1"></i>
                        <i class="fa fa-star" data-value="2"></i>
                        <i class="fa fa-star" data-value="3"></i>
                        <i class="fa fa-star" data-value="4"></i>
                        <i class="fa fa-star" data-value="5"></i>
                    </div> 
                    <span>(${data?.userRatingCount})</span>
                </div>
                `);
                let rating = data?.rating ? data?.rating : 0;
                const stars = document.querySelectorAll('.stars i');

                stars.forEach(star => {
                    const starValue = parseFloat(star.getAttribute('data-value'));
                    if (rating >= starValue) {
                        star.classList.remove('fa-star-half');
                        star.classList.add('fa-solid');
                        star.classList.remove('fa-regular');
                    } else if (rating > starValue - 1 && rating < starValue) {
                        star.classList.add('fa-star-half');
                        star.classList.remove('fa-star');
                        star.classList.remove('fa-solid');
                        star.classList.remove('fa-regular');
                    } else {
                        star.classList.remove('fa-star-half');
                        star.classList.add('fa-regular');
                    }
                });
                $('#info-map-reviews').append(`
                    <hr />
                    <p>Bạn cần nâng cấp trung bình đánh giá lên số lượng</p>`);
                $('#info-map-reviews').append(`
                    <input class="form-control" id="changeRate" onchange="handleRateChange(event, ${data?.rating})" type="number" name="changeRate" min="0" max="5">
                `);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
        function handleSearchMap(event){
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
            }, 2500);
        }

        // Rải chậm
        $('#inputRaiCham').on('change', function(){
            $('#group-raicham small').remove();
            if($(this).val() > 100){
                $(this).val(100);
                $('#group-raicham').append(`<small class="text-danger">Bạn nên rải chậm để các review trông có vẻ thật nhất. Không nên đánh giá quá nhiều trong 1 ngày sẽ giảm số lượng hiển thị review. Số lượng rải chậm nhiều hơn 2 đánh giá và ít hơn 10% số lượng gói mua</small>`);
                setTimeout(() => {
                    $('#group-raicham small').remove();
                }, 2500);
            }
            if($(this).val() < 0){
                $(this).val(0);
            }
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
    </script>
@endsection