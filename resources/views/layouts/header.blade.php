<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>RIVI</title>
        <link rel="icon" type="image/x-icon" href="img/rivi-favicon.png" />

        <!-- css -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,-25" />
        <link href="{{ asset('./assets/css/bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/theme.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/style.css') }}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        @yield('css')
    </head>
    <body class="nav-fixed">

        <!-- js chart-->
        <script src="{{ asset('./assets/js/canvasjs.min.js') }}"></script>
        <!-- jquery -->
        <script src="{{ asset('./assets/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('./assets/js/jquery.basictable.js') }}"></script>
        <script src="{{ asset('./assets/js/select2.min.js') }}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
        <script src="{{ asset('./js/main.js') }}"></script>
        {{-- <script src="{{ asset('./js/password.js') }}"></script> --}}
        <script src="{{ asset('./assets/js/map.js') }}"></script>
        <script src="{{ asset('./assets/js/verifyOtp.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('./js/payment/dynamicDepositAmount.js') }}?v={{ time() }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <link href="
        https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/jquery.datetimepicker.min.css
        " rel="stylesheet">
        <script src="
        https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/build/jquery.datetimepicker.full.min.js
        "></script>
        @yield('js')
    </body>
</html>
<!-- Modal nhan Nhiem Vu -->
<div class="modal fade missionModal" id="missionModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header ">
                <h2 class="modal-title" id="missionModalLabel">Nhận nhiệm vụ</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($errors->has('captcha'))
                <div class="alert alert-danger">
                    {{ $errors->first('captcha') }}
                </div>
            @endif
            <form method="POST" id="recaptcha-form" action="{{ route('verify.recaptcha') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <h4 class="fw-500 text-primary">60 phút</h4>
                    <p>Phần thưởng <span class="fw-500">10.000 VND</span> khi Review <span class="fw-500">RO1234</span></p>
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                </div>
                <div class="modal-footer">
                    <a  class="btn btn-outline-primary btn-lg" data-bs-dismiss="modal" aria-label="Close" >Hủy</a>
                    <a href="javascript:void(0)" id="submit-captcha" class="btn btn-primary btn-lg">Đồng ý</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal vi tri  -->

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
<script>
    $(window).on('load', function() {
        // Get mission
        $('body #btn-get-mission,body #btn-get-mission2').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            let checkCaptcha = getCookie('captchaChecked');
            if(!checkCaptcha){
                $('#missionModal').modal('show');
                return;
            }
            // let check_location = getCookie('current_location');
            // if(!check_location){
            //     $('#warning-location-modal').modal('show');
            // } else {
                let href = $(this).attr('href');
                window.location.href = href;
            // }
        })
    })
</script>

<script>
    $('#submit-captcha').on('click', function(e){
        e.preventDefault();
        const recaptcha = grecaptcha.getResponse();
        if(recaptcha){
            setCookie('captchaChecked', true, 0.0104);
            $('#recaptcha-form').submit();
            $('#submit-captcha').prop('disabled', true);
            $('#submit-captcha').text('Đang xử lý...')
            $('#submit-captcha').prepend(`<span class="spinner-border spinner-border-sm" style="margin-right: 5px;" role="status" aria-hidden="true"></span> `);
        }
    })
</script>

<script>
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    $.ajax({
                        url: "{{ route('profile.update.location') }}",    //the page containing php script
                        type: "post",    //request type,
                        dataType: 'json',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            latitude: latitude,
                            longitude: longitude
                        },
                        success:function(result){
                            localStorage.setItem('current_location', JSON.stringify(position.coords));
                        },
                        error:function(result){
                            console.log(result)
                        }
                    })
                },
                // Hàm lỗi, ví dụ khi người dùng từ chối truy cập
                (error) => {
                    $('#layoutSidenav_content main').prepend(`
                        <div class="col-xl-12 col-md-12 col-12 mt-4 mb-0 px-3">
                            <div id="message-location" class="message bg-danger">
                                <div class="d-flex align-items-center" id="alert-location">
                                    <span class="material-symbols-outlined me-2">info</span>
                                    <p class="alert-alert mb-0">Bạn cần cung cấp vị trí để có thể làm nhiệm vụ. Vui lòng tải lại trang.
                                        <a href="{{route('mission.index')}}" class="ms-2">Tải lại trang <span class="material-symbols-outlined">replay</span></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    `);
                    $('#ViTri').modal('show');
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            console.log("Người dùng đã từ chối yêu cầu lấy vị trí.");
                            break;
                        case error.POSITION_UNAVAILABLE:
                            console.log("Thông tin vị trí không có sẵn.");
                            break;
                        case error.TIMEOUT:
                            console.log("Yêu cầu lấy vị trí quá thời gian cho phép.");
                            break;
                        default:
                            console.log("Đã xảy ra lỗi không xác định.");
                            break;
                    }
                }
            );
        } else {
            showAlert('error','Trình duyệt của bạn không thể truy cập vị trí.');
        }
    }
</script>
@if(!Auth::user()?->latitude || !Auth::user()?->longitude)
    <script>
        getUserLocation();
    </script>
@endif