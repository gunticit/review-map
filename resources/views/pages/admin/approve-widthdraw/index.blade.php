@extends('layouts.app')
@section('content')
<style>
    .bt-content{
        display: flex;
        gap: 5px;
    }
</style>
<section class="approve-project">
    <div class="container-fluid pt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="section-title mb-4">Kiểm duyệt rút tiền</h2>
                        <div class="group-table-list">
                            <table class="table list-table">
                                <thead>
                                    <tr>
                                        <th class="list-table-stt" scope="col">STT</th>
                                        <th style="width: 250px; min-width: 250px !important; max-width: 250px !important" class="text-start" scope="col">Tên đối tác</th>
                                        <th class="text-start">Hợp đồng</th>
                                        <th class="text-start">CCCD Mặt trước</th>
                                        <th class="text-start">CCCD Mặt sau</th>
                                        <th class="text-start list-table-so-tien" scope="col">Ngày xác thực</th>
                                        <th class="text-start list-table-phuong-thuc" scope="col">Trạng thái</th>
                                        <th class="text-start list-table-tai-khoan-nhan" scope="col">Người duyệt</th>
                                        <th class="text-start list-table-so-tien-rut" scope="col">Thời gian duyệt</th>
                                        <th class="text-start list-table-trang-thai" scope="col" style="width: 100px; min-width: 100px !important; max-width: 100px !important"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($partners))
                                        @foreach($partners as $key => $partner)
                                        <tr>
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td style="width: 250px; min-width: 250px !important; max-width: 250px !important">{{ $partner->name }}</td>
                                            <td>
                                                @if(!empty($partner->certificationAccount->contract))
                                                    <a id="contract-{{ $partner->certificationAccount->id ?? '' }}" html-href="{{ asset('storage/'.$partner->certificationAccount->contract) }}" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="javascript:void(0);" onclick="viewContract({{$partner->certificationAccount->id}})">Xem hợp đồng</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($partner->certificationAccount->front_id_image))
                                                    <a id="id-image-front-{{ $partner->certificationAccount->id ?? '' }}" html-href="{{ asset('storage/'.$partner->certificationAccount->front_id_image) }}" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" href="javascript:void(0);" onclick="viewIdImage({{$partner->certificationAccount->id}},'front')">Xem mặt trước</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($partner->certificationAccount->back_id_image))
                                                    <a id="id-image-back-{{ $partner->certificationAccount->id ?? '' }}" html-href="{{ asset('storage/'.$partner->certificationAccount->back_id_image) }}" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" href="javascript:void(0);" onclick="viewIdImage({{$partner->certificationAccount->id}},'back')">Xem mặt sau</a>
                                                @endif
                                            </td>
                                            <td>{!! !empty($partner->certificationAccount->created_at) ? date('d/m/Y', strtotime($partner->certificationAccount->created_at)) : '' !!}</td>
                                            <td class="text-start status-verified" id="item-withdraw-{{ $partner->certificationAccount->id ?? '' }}">
                                                @if(!empty($partner->certificationAccount->verified_at) && !empty($partner->certificationAccount->active))
                                                    <span class="text-success material-symbols-outlined">
                                                        check_circle
                                                    </span> <span class="text-success">Đã duyệt</span>
                                                @endif
                                                @if(!empty($partner->certificationAccount->verified_at) && empty($partner->certificationAccount->active))
                                                    <span class="material-symbols-outlined text-danger">
                                                        error
                                                    </span> <span class="text-danger">Không duyệt</span>
                                                @endif
                                            </td>
                                            <td id="name-verified-{{ $partner->certificationAccount->id ?? '' }}">{{ $partner->certificationAccount?->userVerified?->name ?? '' }}</td>
                                            <td id="date-verified-{{ $partner->certificationAccount->id ?? '' }}">{!! !empty($partner->certificationAccount->verified_at) ? date('d/m/Y H:i', strtotime($partner->certificationAccount->verified_at)) : '' !!}</td>
                                            <td style="width: 100px; min-width: 100px !important; max-width: 100px !important; text-align: right" id="btn-group-{{ $partner->certificationAccount->id ?? '' }}">
                                                @if(empty($partner->certificationAccount->userVerified) && !empty($partner->certificationAccount->contract))
                                                    <button class="btn btn-success p-2" type="button" onclick="approve({{$partner->certificationAccount->id}})">
                                                        <span style="font-size: 18px" class="material-symbols-outlined">
                                                            check
                                                        </span>
                                                    </button>
                                                    <button class="btn btn-danger p-2" type="button" onclick="reject({{$partner->certificationAccount->id}})">
                                                        <span style="font-size: 18px" class="material-symbols-outlined">
                                                            delete
                                                        </span>
                                                    </button>
                                                @elseif(!empty($partner->certificationAccount->userVerified))
                                                    <button class="btn btn-info p-2" type="button" onclick="handleRefresh({{$partner->certificationAccount->id}})">
                                                        <span class="material-symbols-outlined">
                                                            refresh
                                                        </span>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Hợp đồng</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <iframe src="" width="100%" height="600px" id="contract-iframe"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Đóng</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="label-image">Hình căn cước</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <img src="" alt="" id="id-image">
        </div>
      </div>
    </div>
</div>
<script>
    function approve(id) {
        $.ajax({
            url: "{{ route('confirm.approve.withdraw') }}",
            type: 'POST',
            data: {
                certification_id: id,
                _token: '{{ csrf_token() }}',
            },  
            dataType: 'json',
            success: function(data) {
                $('#name-verified-'+id).html(data.user_verified);
                $('#date-verified-'+id).html(data.verified_at);
                $('#item-withdraw-'+id).html(`
                    <span class="bt-content">
                        <span class="text-success material-symbols-outlined">
                            check_circle
                        </span>
                        <span class="text-success">Đã duyệt</span>
                    </span>
                `);
                $('#btn-group-'+id+' *').remove();
                // setTimeout(() => {
                //     showAlert(
                //         data.status == 'success' ? 'success' : 'error',
                //         data.message
                //     )
                // }, 1000);
            }
        });
    }
    function reject(id) {
        $.ajax({
            url: "{{ route('confirm.reject.withdraw') }}",
            type: 'POST',
            data: {
                certification_id: id,
                _token: '{{ csrf_token() }}',
            },  
            dataType: 'json',
            success: function(data) {
                $('#name-verified-'+id).html(data.user_verified);
                $('#date-verified-'+id).html(data.verified_at);
                $('#item-withdraw-'+id).html(`
                    <span class="bt-content">
                        <span class="material-symbols-outlined text-danger">
                            error
                        </span>
                        <span class="text-danger">Không duyệt</span>
                    </span>
                `);
                $('#btn-group-'+id+' *').remove();
                // setTimeout(() => {
                //     showAlert(
                //         data.status == 'success' ? 'success' : 'error',
                //         'Xác nhận đã kiểm duyệt thành công!'
                //     )
                // }, 1000);
            }
        });
    }
    function handleRefresh(id) {
        $.ajax({
            url: "{{ route('confirm.refresh.withdraw') }}",
            type: 'POST',
            data: {
                certification_id: id,
                _token: '{{ csrf_token() }}',
            },  
            dataType: 'json',
            success: function(data) {
                // showAlert(
                //     data.status == 'success' ? 'success' : 'error',
                //     data.message
                // )
                window.location.reload();
            }
        });
    }
</script>
<script>
    function viewContract(id) {
        $('#staticBackdrop').modal('show');
        let link_docx = $('#contract-'+id).attr('html-href');
        $('#contract-iframe').attr('src', link_docx);
    }
    function viewIdImage(id, type=''){
        $('#staticBackdrop2').modal('show');
        if(type=='front'){
            let id_image_front = $('#id-image-front-'+id).attr('html-href');
            $('#id-image').attr('src', id_image_front);
            $('#label-image').text('Hình CCCD Mặt trước');
        }else{
            let id_image_back = $('#id-image-back-'+id).attr('html-href');
            $('#id-image').attr('src', id_image_back);
            $('#label-image').text('Hình CCCD Mặt sau');
        }
    }
</script>
@endsection