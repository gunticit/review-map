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
            <a href="{{ route('customer.support.create') }}" class="btn btn-primary d-flex flex-wrap" id="btn-add">
                <span class="material-symbols-outlined">add</span>
                <span>Tạo yêu cầu</span>
            </a>
        </div>
    </div>
  </div>
</section>

<!-- danh-sach-du-an -->
<section class="section danh-sach-du-an mb-5">
    <div class="container-fluid">
        <div class="col-inner">
            <h2 class="section-title mb-4">Yêu cầu hỗ trợ</h2>
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
                            <th class="list-table-title" scope="col">Tiêu đề</th>
                            <th class="list-table-sku" scope="col">Mã đơn</th>
                            <th class="list-table-time" scope="col">Thời gian</th>
                            <th class="list-table-progree" scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($supports))
                        @foreach ($supports as $key => $support)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="list-table-title">
                                <a href="javascript:void(0);">{{ $support->title }}</a>
                            </td>
                            <td class="list-table-sku">
                                <a href="javascript:void(0);">{{ $support->title }}</a>
                            </td>
                            <td class="list-table-time">
                                {!! date('d/m/Y', strtotime($support->created_at)) !!} <span>{!! date('hh:mm', strtotime($support->created_at)) !!}</span>
                            </td>
                            <td class="list-table-progree">
                                <span class="btn {!! 
                                    $support->status == 1 ? 'btn-success' : 
                                    ($support->status == 2 ? 'btn-primary' :
                                    ($support->status == 3 ? 'btn-info' : 
                                    ($support->status == 4 ? 'btn-danger' : 'btn-danger')))
                                !!} ">{!! __( config('constants.status_support')[$support->status]) !!}</span>
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