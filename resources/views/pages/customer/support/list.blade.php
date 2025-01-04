@extends('layouts.app')
@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-wrap">
  <div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-xl-10 col-md-8 col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active fw-700" aria-current="page">Yêu cầu hỗ trợ</li>
                </ol>
            </nav>
        </div>
        <div class="col-xl-2 col-md-8 col-12 text-right">
            @if(auth()->user()->getRoleNames()->first() != 'admin')
            <a href="{{ route('customer.support.create') }}" class="btn btn-primary d-flex flex-wrap" id="btn-add">
                <span class="material-symbols-outlined">add</span>
                <span>Tạo yêu cầu</span>
            </a>
            @endif
        </div>
    </div>
  </div>
</section>

<!-- danh-sach-du-an -->
<section class="section danh-sach-du-an mb-5">
    <div class="container-fluid">
        <div class="col-inner">
            <h2 class="section-title mb-4">Yêu cầu hỗ trợ</h2>
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            <form>
                <div class="input-group">
                    <button class="input-group-text" type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <input type="text" placeholder="Tìm kiếm" class="form-control" name="keyword" id="inputSearch">
                </div>
            </form>
            <div class="group-table-list">
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th style="min-width: unset; width: 80px !important" class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-title text-start" scope="col">Tiêu đề</th>
                            <th class="list-table-sku" style="min-width: unset; width: 150px !important; text-align: left" scope="col">Nội dung</th>
                            <th class="list-table-time" scope="col">Người gửi</th>
                            <th class="list-table-time" scope="col">Thời gian</th>
                            <th class="list-table-progree" scope="col">Trạng thái</th>
                            <th style="min-width: 45px; max-width: 45px; width: 45px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($supports))
                        @foreach ($supports as $key => $support)
                        @php
                            $link_support = (!empty($support->status) && $support->status != 4) ? route('admin.reply.support', ['id' => $support->id]) : route('customer.support.detail', ['id' => $support->id]);
                        @endphp
                        <tr>
                            <td style="min-width: unset !important; width: 80px !important">{{ $key + 1 }}</td>
                            <td class="list-table-title text-start" style="min-width: unset !important; width: 220px !important">
                                <a href="{{ $link_support }}" style="min-width: unset !important; width: 180px !important">{{ $support->title }}</a>
                            </td>
                            <td class="list-table-sku text-start" style="min-width: unset; width: 150px !important">
                                <a href="javascript:void(0);" style="min-width: unset !important; width: 150px !important; text-align: left">{{ $support->content }}</a>
                            </td>
                            <td class="text-center">{{ $support->sender?->name ?? '' }}</td>
                            <td class="list-table-time text-center">
                                {!! date('d/m/Y h:i', strtotime($support->created_at)) !!}
                            </td>
                            <td class="list-table-progree text-center">
                                <span class="btn {!! 
                                    $support->status == 1 ? 'btn-success' : 
                                    ($support->status == 2 ? 'btn-primary' :
                                    ($support->status == 3 ? 'btn-info' : 
                                    ($support->status == 4 ? 'btn-danger' : 'btn-danger')))
                                !!} ">{!! __( config('constants.status_support')[$support->status]) !!}</span>
                            </td>
                            <td style="min-width: 45px; max-width: 45px; width: 45px">
                                @if(!empty($support->status) && $support->status != 4)
                                <a href="{{ $link_support }}" class="btn btn-primary p-2"><span class="material-symbols-outlined">reply</span></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $supports->links('vendor.pagination.custom') }}
        </div>
    </div>
</section>
<!-- end danh-sach-du-an -->
@endsection