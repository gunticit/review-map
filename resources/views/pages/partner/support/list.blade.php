@extends('layouts.app')

@section('css')
<style>
    .support__title {
        styleName: HeadingMedium/24/Bold;
        font-family: Montserrat;
        font-size: 24px;
        font-weight: 700;
        line-height: 31.68px;
        text-align: left;
    }
    .support__btn {
        width: Fixed (233.99px)px;
        height: Fixed (56px)px;
        top: 19px;
        left: 1320.01px;
        padding: 16px 0px 0px 0px;
        gap: 8px;
        border-radius: 8px 0px 0px 0px;
        opacity: 0px;
    }
    .support__crate {
        styleName: BodyMeium/16/Medium;
        font-family: Montserrat;
        font-size: 16px;
        font-weight: 500;
        line-height: 25.6px;
        text-align: right;

    }
    .support__title--sub {
        styleName: HeadingMedium/24/Bold;
        font-family: Montserrat;
        font-size: 24px;
        font-weight: 700;
        line-height: 29.26px;
        text-align: left;
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-wrap">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xl-10 col-md-8 col-12">
            </div>
            <div class="col-xl-2 col-md-8 col-12 text-right support__btn">
                <a href="{{ route('partner.support.create') }}" class="btn btn-primary d-flex flex-wrap support__crate">
                    <span class="support__crate">+ Tạo yêu cầu</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Support Requests List -->
<section class="section danh-sach-du-an mb-5">
    <div class="container-fluid">
        <div class="col-inner">
            <h2 class="support__title--sub mb-4">Yêu cầu hỗ trợ</h2>
            <form>
                <div class="input-group mb-4">
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
                            <th class="list-table-department" scope="col">Phòng ban</th> <!-- Added column for Phòng ban -->
                            <th class="list-table-code" scope="col">Mã yêu cầu</th> <!-- Updated to mã yêu cầu -->
                            <th class="list-table-time" scope="col">Thời gian</th>
                            <th class="list-table-status" scope="col">Trạng thái</th>
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
                                <td class="list-table-department">{{ $support->department->name }}</td>
                                <td class="list-table-code">{{ $support->support_code }}</td>
                                <td class="list-table-time">
                                    {{ date('d/m/Y', strtotime($support->created_at)) }} <span>{{ date('H:i', strtotime($support->created_at)) }}</span>
                                </td>
                                <td class="list-table-status">
                                    <span class="btn">
                                        {!! __(config('constants.status_support')[$support->status]) !!}
                                    </span>
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
@endsection
