@extends('layouts.app')
@section('content')
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
                                        <th class="text-start list-table-phuong-thuc" scope="col">Đã duyệt</th>
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
                                                    <a href="{{$partner->certificationAccount->contract}}" target="_blank">Xem hợp đồng</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($partner->certificationAccount->front_id_image))
                                                    <a href="{{$partner->certificationAccount->front_id_image}}" target="_blank">Xem mặt trước</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($partner->certificationAccount->back_id_image))
                                                    <a href="{{$partner->certificationAccount->back_id_image}}" target="_blank">Xem mặt sau</a>
                                                @endif
                                            </td>
                                            <td>{!! !empty($partner->certificationAccount->created_at) ? date('d/m/Y', strtotime($partner->certificationAccount->created_at)) : '' !!}</td>
                                            <td class="text-start">
                                                @if(!empty($partner->certificationAccount->verified_at))
                                                    <span class="text-success material-symbols-outlined">
                                                        check_circle
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $partner->certificationAccount?->userVerified?->name ?? '' }}</td>
                                            <td>{!! !empty($partner->certificationAccount->verified_at) ? date('d/m/Y H:i', strtotime($partner->certificationAccount->verified_at)) : '' !!}</td>
                                            <td style="width: 100px; min-width: 100px !important; max-width: 100px !important; text-align: right">
                                                @if(empty($partner->certificationAccount->userVerified) && !empty($partner->certificationAccount->contract))
                                                <button class="btn btn-success p-2" type="button">
                                                    <span style="font-size: 18px" class="material-symbols-outlined">
                                                        check
                                                    </span>
                                                </button>
                                                <button class="btn btn-danger p-2" type="button">
                                                    <span style="font-size: 18px" class="material-symbols-outlined">
                                                        delete
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
@endsection