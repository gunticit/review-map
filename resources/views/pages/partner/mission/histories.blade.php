@extends('layouts.app')
@section('content')
<script src="https://www.google.com/recaptcha/api.js"></script>
<section class="section nhan-nhiem-vu mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-2 col-md-3 col-12 mb-4 mb-md-0">
                <a class="btn btn-primary btn-full" href="#" id="btn-get-mission2" data-bs-target="#missionModal">Nhận nhiệm vụ</a>
            </div>
            <div class="col-xl-10 col-md-9 col-12 mb-4 mb-md-0 ">
                <!-- class: bg-warning, bg-success, bg-danger  -->
                <div id="message-location" class="message bg-danger">
                    <div class="d-flex align-items-center" id="alert-location">
                        <span class="material-symbols-outlined me-2">info</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- nhiem vu -->
<section class="section nhiem-vu mb-5">
    <div class="container">
        <div class="col-inner">
            <h2 class="section-title mb-4">Lịch sử nhiệm vụ</h2>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 mt-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form>
                <div class="input-group">
                    <button class="input-group-text" type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                </div>
            </form>     

            </form>
            <table class="table list-table">
                <thead>
                    <tr>
                        <th class="list-table-stt" scope="col">STT</th>
                        <th class="list-table-time" scope="col">Thời gian</th>
                        <th class="list-table-sku" scope="col">Mã đơn hàng</th>
                        <th class="list-table-title" scope="col">Tên dự án</th>
                        <th class="list-table-link-map" scope="col">URL Google Map</th>
                        <th class="list-table-content-2" scope="col">Nội dung</th>
                        <th class="list-table-progree" scope="col">Trạng thái</th>
                        <th class="list-table-profit" scope="col">Lợi nhuận</th>
                        <th class="list-table-note" scope="col">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($missions))
                        @foreach($missions as $mission)
                            <tr>
                                <td>1</td>
                                <td class="list-table-time">
                                    {{ date('d/m/Y H:i', strtotime($mission->created_at)) }}
                                </td>
                                <td class="list-table-sku">
                                    {{ 'RO'.$mission->id }}
                                </td>
                                <td class="list-table-title">
                                    {{ $mission->project->name }}
                                </td>
                                <td class="list-table-link-map">
                                    <a class="btn " href="https://www.google.com/maps/place/?q=place_id:{{ $mission->project->place_id }}" target="_blank" role="button">
                                        <span class="material-symbols-outlined">link</span>
                                    </a>
                                </td>
                                <td class="list-table-content-2">
                                    {{ $mission->comments->comment }}
                                </td>
                                <td class="list-table-progree">
                                    <span class="btn btn-primary">{{ statusMission($mission->status) }}</span>
                                </td>
                                <td class="list-table-profit">
                                    <span class="text-warning">{{ $mission->price }} VND</span>
                                </td>
                                <td class="list-table-note">
                                    @if(in_array($mission->status,$status_alert))
                                    Cần tối đa 60 phút để hệ thống kiểm tra
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="list-table-footer d-flex justify-content-between align-items-center">
                <div class="list-table-per-page">
                    <span class="form-label">Hiển thị kết quả</span>
                    <select class="form-select d-inline-block" name="" id="">
                        <option selected>10</option>
                        <option value="">20</option>
                        <option value="">30</option>
                        <option value="">40</option>
                    </select>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <span class="page-link" href="#">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">20</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- end danh-sach-du-an --> 

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

<!-- Modal thông báo -->
<div class="modal fade alert-modal" id="warning-location-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header ">
                <h2 class="modal-title" id="alert-modal-label">Thông báo</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Chúng tôi không thể lấy vị trí hiện tại của bạn. <br />
                    Hãy <span class="text-primary">Cho phép truy cập vị trí</span> để tiếp tục
                </p>
            </div>
        </div>
    </div>
</div>
<!-- end modal vi tri  -->

<!-- Modal nhan Nhiem Vu -->
<div class="modal fade missionModal" id="missionModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header ">
                <h2 class="modal-title" id="missionModalLabel">Nhận nhiệm vụ</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('verify.recaptcha') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <h4 class="fw-500 text-primary">60 phút</h4>
                    <p>Phần thưởng <span class="fw-500">10.000 VND</span> khi Review <span class="fw-500">RO1234</span></p>
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_V2_SITE_KEY') }}"></div>
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
 
<script>
    // Jquery
    jQuery(document).ready(function($){
        // let check_location = localStorage.getItem('current_location');
        if(!navigator.geolocation){
            $('#ViTri').modal('show');
            $('#alert-location').append(`
                <p class="alert-alert mb-0">Bạn cần cung cấp vị trí để có thể làm nhiệm vụ. Vui lòng tải lại trang.
                    <a href="#" class="ms-2">Tải lại trang <span class="material-symbols-outlined">replay</span></a>
                </p>
            `);
  
        }else{
            navigator.geolocation.getCurrentPosition(
                    function(position) {
                        $('#ViTri').modal('hide');
                        $('#message-location').remove();
                        console.log(position);
                        $.ajax({
                            url: "{{ route('profile.update.location') }}",    //the page containing php script
                            type: "post",    //request type,
                            dataType: 'json',
                            data: {
                                email: "{{auth()->user()->email}}",
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
                    }
                );
            $('#message-location').remove();
        }

        // Get mission
        $('#btn-get-mission').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            let check_location = localStorage.getItem('current_location');
            if(!check_location){
                $('#warning-location-modal').modal('show');
            }else{
                var targetModal = $(this).attr('data-bs-target');
                $(targetModal).modal('show');
            }
        })
    });
</script>
<!-- Recaptcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
    var onloadCallback = function() {
      alert("grecaptcha is ready!");
    };
  </script>
<script>
    $('#submit-captcha').on('click', function(e){
        e.preventDefault();
    })
</script>
@endsection