@extends('layouts.app')
@section('content')
    <style>
        .button-tab {
            width: 100%;
            font-size: 18px;
            font-weight: 700;
            color: #96A3BE;
            background-color: #fff;
            border: 1px solid #fff;
        }

        .button-tab:hover {
            color: #194BFB;
            border: 1px solid #194BFB;
            background-color: #fff;
        }

        .button-tab.active {
            color: #194BFB;
            border: 1px solid #194BFB;
            background-color: #fff;
        }

        .table {
            font-size: 14px;
        }

        .table .table-th {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table .table-th .table-th-col {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: none;
            background: transparent;
            color: #5D6A83;
            font-weight: 700;
            padding-right: 20px;
            line-height: 1;
        }

        /* .table .table-th .table-th-col.asc::before {
            opacity: 1;
        }

        .table .table-th .table-th-col.desc::after {
            opacity: 1;
        }

        .table .table-th .table-th-col::before {
            position: absolute;
            display: block;
            right: 0;
            top: 50%;
            transform: translateY(-80%);
            font-size: 19px;
            content: "▲" / "";
            opacity: 0.5;
        }

        .table .table-th .table-th-col::after {
            position: absolute;
            display: block;
            right: 0;
            bottom: 50%;
            font-size: 19px;
            transform: translateY(80%);
            content: "▼" / "";
            opacity: 0.5;
        } */

        .list-table-footer nav .small.text-muted {
            display: none;
        }

        .table-td-alert {
            padding: 2px 4px;
            font-weight: 500;
            white-space: nowrap;
        }
    </style>
    <div class="list-manage-customer">
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.wallet', ['id' => $partner_id]) }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted">Thông tin cơ bản</button>
                    </form>
                </div>
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.wallet', ['id' => $partner_id]) }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted">Ví đối tác</button>
                    </form>
                </div>
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.project', ['id' => $partner_id]) }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted active">Lịch sử nhiệm vụ</button>
                    </form>
                </div>
            </div>
            @php
                $queries = ['keyword', 'page', 'per_page'];
                $cols = [
                    ['label' => 'STT', 'value' => 'id'],
                    ['label' => 'Thời gian', 'value' => 'created_at'],
                    ['label' => 'Mã đơn hàng', 'value' => ''],
                    ['label' => 'Tên dự án', 'value' => ''],
                    ['label' => 'URL <br>Google Map', 'value' => ''],
                    ['label' => 'Nội dung', 'value' => ''],
                    ['label' => 'Trạng thái', 'value' => ''],
                    ['label' => 'Lợi nhuận', 'value' => ''],
                    ['label' => 'Ghi chú', 'value' => ''],
                ];
            @endphp
            <section class="section thong-bao mb-5 mt-5">
                <div class="col-inner">
                    <h3 class="section-title mb-4">Lịch sử nhiệm vụ</h3>
                    <form action="{{ route('admin.manage.partner.project', ['id' => $partner_id]) }}" method="GET">
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch" name="keyword" value="{{ request()->keyword }}">
                            @foreach ($queries as $query)
                                @if (request()->$query && $query != 'keyword')
                                    <input type="hidden" name="{{ $query }}" value="{{ request()->$query }}">
                                @endif
                            @endforeach
                        </div>
                    </form>
                    <div class="group-table-list">
                        <table class="table list-table">
                            <thead>
                                <tr>
                                    @foreach ($cols as $index => $col)
                                        <th style="{!! $index == 0 ? 'min-width: auto' : '' !!}" scope="col">
                                            <div class="table-th">
                                                <button type="submit" class="table-th-col">
                                                    {!! $col['label'] !!}
                                                </button>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td style="max-width:100px; min-width: unset; width: auto" class="text-center">{{ $project->id }}</td>
                                        <td class="text-center">{{ $project->formatted_created_at }}</td>
                                        <td class="text-center">{{ $project->project_code }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td class="text-center">
                                            <a class="btn" target="_blank" href="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAP_API_KEY')}}&q=place_id:{{$project->place_id}}" role="button">
                                                <span class="material-symbols-outlined">link</span>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if(isset($project->missions))
                                                @foreach ($project->missions as $key => $mission)
                                                    @if($key == 0)
                                                    {{ $mission->link_confirm }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{-- 0: Huỷ, 1: Hoàn thành, 2: Đang thực hiện, 3: Hoàn lại, 4: Tạm ngưng, 5: Chưa thanh toán, 6: Đang chờ duyệt (khi hoàn thành nhiệm vụ) --}}
                                            @if ($project->status == 0)
                                                <div class="table-td-alert">
                                                    Huỷ
                                                </div>
                                            @elseif ($project->status == 1)
                                                <div class="table-td-alert">
                                                    Hoàn thành
                                                </div>
                                            @elseif ($project->status == 2)
                                                <div class="table-td-alert" style="background-color: #FFF0E6; color: #FE964A">
                                                    Đang thực hiện
                                                </div>
                                            @elseif ($project->status == 3)
                                                <div class="table-td-alert">
                                                    Hoàn lại
                                                </div>
                                            @elseif ($project->status == 4)
                                                <div class="table-td-alert">
                                                    Tạm ngưng
                                                </div>
                                            @elseif ($project->status == 5)
                                                <div class="table-td-alert" style="background-color: #E8EDFF; color: #436CFF">
                                                    Chưa thanh toán
                                                </div>
                                            @elseif ($project->status == 6)
                                                <div class="table-td-alert">
                                                    Đang chờ duyệt
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $project->profit }}</td>
                                        <td>{{ $project->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        
                    <div class="list-table-footer d-flex justify-content-between align-items-center">
                        <div class="list-table-per-page">
                            <span class="form-label">Hiển thị kết quả</span>
                            <form action="{{ route('admin.manage.partner.project', ['id' => $partner_id]) }}" method="GET">
                                @php
                                    $perPages = [10, 20, 30, 40];
                                @endphp
                                <select class="form-select d-inline-block" name="per_page" onchange="this.form.submit()">
                                    @foreach ($perPages as $perPage) 
                                        <option value="{{ $perPage }}" {{ $perPage == request()->per_page ? 'selected' : '' }}>{{ $perPage }}</option>
                                    @endforeach
                                </select>
                                @foreach ($queries as $query)
                                    @if (request()->$query && $query != 'per_page')
                                        <input type="hidden" name="{{ $query }}" value="{{ request()->$query }}">
                                    @endif
                                @endforeach
                            </form>
                        </div>
                        {{ $projects->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection