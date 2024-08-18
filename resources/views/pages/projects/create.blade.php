@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/basictable/1.5.0/basictable.min.js"></script>
<style>
    .inputUrlMap.active .col-md-3{
        cursor: pointer;
    }
    #map{
        width: 100%;
        height: 500px;
    }
</style>
<!-- tao-du-an -->
<section class="section tao-du-an mb-5 mt-5">
    <form action="{{ route('project.store') }}" method="POST">
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
                            <small class="d-none">Tên dự án cho phép dưới 50 ký tự bao gồm các khoảng trắng.</small>
                        </div>
                        <!-- Form Group (UrlMap)-->
                        <div class="mb-4 inputUrlMap "><!-- class: active -->
                            <label for="inputUrlMap">URL Map <span class="required">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-9 col-12">
                                    <input class="form-control" id="inputUrlMap" name="url_map" type="url" placeholder="URL bắt buộc phải là URL, bắt buộc bằng địa chỉ https://maps.app.goo.gl/..." value="" required>
                                    <small class="d-none">Sai URL. Vui lòng kiểm tra lại.</small>
                                </div>
                                <div class="col-md-3 col-12">
                                    <button type="button" class="btn btn-primary btn-check-map" onclick="handleCheckMap()" data-bs-toggle="modal" data-bs-target="#CheckUrl" disabled> Kiểm tra URL </button>
                                </div>
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
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
                                        <option value="">RIVI10 - 45.000 VND/đánh giá - 10 lượt đánh giá</option>
                                        <option value="">RIVI50 - 35.000 VND/đánh giá - 50 lượt đánh giá</option>
                                        <option value="">RIVI100 - 30.000 VND/đánh giá - 100 lượt đánh giá</option>
                                        <option value="">RIVI200 - 25.000 VND/đánh giá - 200 lượt đánh giá</option>
                                    </select>
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
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputRaiChamCheck">
                                            <input type="checkbox" class="form-check-input" id="inputRaiChamCheck">
                                        </span>
                                        <input type="number" max="100" class="form-control" id="inputRaiCham">
                                    </div>
                                    <small>Bạn nên rải chậm để các review trông có vẻ thật nhất. Không nên đánh giá quá nhiều trong 1 ngày sẽ giảm số lượng hiển thị review. Số lượng rải chậm nhiều hơn 2 đánh giá và ít hơn 10% số lượng gói mua</small>
                                </div>
                            </div>
                        </div>
                        <!-- Form Group (Tags)-->
                        <div class="mb-4">
                            <label for="Tagslist-table">Từ khóa <span class="required">*</span>
                            </label>
                            <input class="form-control" id="Tagslist-table" type="text" placeholder="Enter để ngắt từ khóa" value="" required>
                        </div>
                        <!-- Form Group (Img)-->
                        <div class="inputImg"><!-- class: active -->
                            <label class="d-block" for="inputImg">Hình ảnh <span class="required">*</span>
                            </label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inputImg" id="inputImg1" value="inputImg1">
                                <label class="form-check-label" for="inputImg1"> Có </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inputImg" id="inputImg2" value="inputImg2" checked>
                                <label class="form-check-label" for="inputImg2"> Không </label>
                            </div>
                            <div class="d-none">
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
                        <h2 class="section-title">Hướng dẫn lấy URL</h2>
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
<script src="{{ asset('./assets/js/inputTags.jquery.min.js') }}"></script>
<script src="{{ asset('./assets/js/fileUpload.js') }}"></script>
<script>
    // Jquery 
    jQuery(document).ready(function($) {
        //Jquery table input Tags
        $('#Tagslist-table').inputTags({
            autocomplete: {
                values: ['Không gian đẹp', 'Nhân viên nhiệt tình', 'Cà phê ngon', 'Náo nhiệt', 'Review', 'Google Map', 'Đồ uống ngon', 'Yên tĩnh'],
                only: true
            },
            max: 6,
        });
        // file Upload
        $("#fileUpload").fileUpload();
        //imgs
        $('.inputUrlMap input[name="url_map"]').change(function() {
            $(".inputUrlMap").toggleClass("active");
            let urlMap = $(this).val();
            let coordinates = getLatLongFromUrl(urlMap);
            console.log(coordinates);
            $('#lat').val(coordinates.latitude);
            $('#lng').val(coordinates.longitude);
            $('.btn-check-map').prop('disabled', false);
        });
        $('#confirm-url-map').on('click', function(){
            $('#CheckUrl').modal('hide');
        });
    });
    function getLatLongFromUrl(url) {
        const urlObj = new URL(url);
        const pathParts = decodeURIComponent(urlObj.pathname).split('/');
        const dataURL = pathParts.filter(item => item.startsWith('@'));
        const data = dataURL[0] ? dataURL[0].split(',') : [];
        
        return {
            latitude: data[0] ? data[0].replace('@', '') :'',
            longitude: data[1] ? data[1] : ''
        };
    }
</script> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsrw-1OJrRbffA0EZ6gcFPJLLgnw8aM6E&callback=initMap" async defer></script>
    <script>
        let map;
        let marker;

        function initMap() {
            const initialLat = parseFloat('<?= $latitude; ?>');
            const initialLng = parseFloat('<?= $longitude; ?>');

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                gestureHandling: "greedy",
                center: { lat: initialLat, lng: initialLng },
            });

            marker = new google.maps.Marker({
                map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: { lat: initialLat, lng: initialLng },
            });

            marker.addListener("dragend", handleMarkerDragEnd);
        }

        function handleCheckMap() {
            let latitude = parseFloat($('#lat').val());
            let longitude = parseFloat($('#lng').val());

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
            $('#lat').val(newLat);
            $('#lng').val(newLng);
        }
    </script>
@endsection