@extends('layouts.app')
@section('content')
<section class="section nhan-nhiem-vu mb-5 mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-md-3 col-12 mb-4 mb-md-0">
                <a class="btn btn-primary btn-full" href="{{ route('mission.index') }}" id="btn-get-mission2" data-bs-target="#missionModal">Nhận nhiệm vụ</a>
            </div>
            <div class="col-xl-10 col-md-9 col-12 mb-4 mb-md-0 "></div>
        </div>
    </div>
</section>
<!-- nhiem vu -->
<section class="section nhiem-vu mb-5">
    <div class="container-fluid">
        <div class="col-inner">
            <h2 class="section-title mb-4">Lịch sử nhiệm vụ</h2>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if($errors->any())
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
            <div class="group-table-list">
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-time" scope="col">Thời gian</th>
                            <th class="list-table-sku" scope="col">Mã đơn hàng</th>
                            <th class="list-table-title" scope="col">Tên dự án</th>
                            <th class="list-table-link-map" scope="col">URL Google Map</th>
                            <th class="list-table-content-2" style="max-width: unset; min-width: 250px" scope="col">Nội dung</th>
                            <th class="list-table-progree text-center" scope="col">Trạng thái</th>
                            <th class="list-table-profit text-center" scope="col">Lợi nhuận</th>
                            <th class="list-table-note" scope="col">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($missions))
                            @foreach($missions as $mission)
                                <tr>
                                    <td>{{ $mission->id }}</td>
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
                                        <a class="btn " href="https://www.google.com/maps/place?key={{env('GOOGLE_MAP_API_KEY')}}&q=place_id:{{ $mission->project->place_id }}" target="_blank" role="button">
                                            <span class="material-symbols-outlined">link</span>
                                        </a>
                                    </td>
                                    <td class="list-table-content-2" style="max-width: unset; min-width: 250px">
                                        <p style="overflow: hidden; text-overflow: ellipsis; margin-bottom: 0; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; line-height: 1.5;">{{ $mission->comments->comment }}</p>
                                    </td>
                                    <td class="list-table-progree text-center">
                                        <span class="{{ checkStatus($mission->status)['className'] }}">{{ statusMission($mission->status) }}</span>
                                    </td>
                                    <td class="list-table-profit text-center">
                                        <span class="{{ checkStatus($mission->status)['className'] }}">{{ formatCurrency($mission->price) }}</span>
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
            </div>
            {{ $missions->links('vendor.pagination.custom') }}
        </div>
    </div>
</section>
<!-- end danh-sach-du-an --> 

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
<!-- Recaptcha -->
<script type="text/javascript">
    var onloadCallback = function() {
      showAlert("grecaptcha is ready!");
    };
</script>
@endsection