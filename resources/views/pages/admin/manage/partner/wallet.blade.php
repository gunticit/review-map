@extends('layouts.app')
@section('content')
    <style>
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

        .table .table-th .table-th-col.asc::before {
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
        }

        .list-table-footer nav .small.text-muted {
            display: none;
        }

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
        
        .color-black {
            color: #32343A;
        }

        .color-success {
            color: #22C55E;
        }

        .color-danger {
            color: #FF4747;
        }

        .color-warning {
            color: #F59E0B;
        }
    </style>
    <div class="list-manage-customer">
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.info', ['id' => $partner_id]) }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted">Thông tin cơ bản</button>
                    </form>
                </div>
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.wallet', ['id' => $partner_id]) }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted active">Ví đối tác</button>
                    </form>
                </div>
                <div class="col-3">
                    <form action="{{ route('admin.manage.partner.project', ['id' => $partner_id]) }}" method="GET">
                        <button type="submit" class="button-tab btn btn-muted">Lịch sử nhiệm vụ</button>
                    </form>
                </div>
            </div>
            @php
                $queries = ['order_by', 'sort', 'keyword', 'page', 'per_page'];
                $cols = [
                    ['label' => 'STT', 'value' => 'id'],
                    ['label' => 'Thời gian', 'value' => 'created_at'],
                    ['label' => 'Mã giao dịch', 'value' => 'reference_id'],
                    ['label' => 'Phương thức', 'value' => 'payment_method_id'],
                    ['label' => 'Tài khoản nhận', 'value' => 'user_name'],
                    ['label' => 'Số tiền rút', 'value' => 'amount'],
                    ['label' => 'Trạng thái', 'value' => 'status'],
                ];
            @endphp
            <section class="section thong-bao mb-5 mt-5">
                <div class="col-inner">
                    <h3 class="section-title mb-4">Lịch sử rút tiền</h3>
                    <form action="{{ route('admin.manage.partner.wallet', ['id' => $partner_id]) }}" method="GET">
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
                                        <th scope="col">
                                            <div class="table-th">
                                                <form action="{{ route('admin.manage.partner.wallet', ['id' => $partner_id]) }}" method="GET">
                                                    @php
                                                        $sort = '';
                                                        if (request()->order_by == $col['value']) {
                                                            $sort = request()->sort == 'asc' ? 'asc' : 'desc';
                                                        }

                                                        if (!request()->order_by && $index == 0) {
                                                            $sort = 'desc';
                                                        }
                                                    @endphp
                                                    <button type="submit" class="table-th-col {{ $sort }}">
                                                        {{ $col['label'] }}
                                                    </button>
                                                    @if (!request()->order_by)
                                                        <input type="hidden" name="order_by" value="{{ $col['value'] }}">
                                                    @endif
                                                    @if (!request()->sort)
                                                        <input type="hidden" name="sort" value="{{ $sort == 'asc' ? 'desc' : 'asc' }}">
                                                    @endif
                                                    @foreach ($queries as $query)
                                                        @if (request($query))
                                                            @if ($query == 'sort')
                                                                <input type="hidden" name="{{ $query }}" value="{{ $sort == 'asc' ? 'desc' : 'asc' }}">
                                                            @elseif ($query == 'order_by')
                                                                <input type="hidden" name="{{ $query }}" value="{{ $col['value'] }}">
                                                            @else
                                                                <input type="hidden" name="{{ $query }}" value="{{ request($query) }}">
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </form>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($transactionHistories))
                                    @foreach ($transactionHistories as $transactionHistory)
                                        <tr>
                                            <td class="text-center">{{ $transactionHistory['id'] }}</td>
                                            <td class="text-center">{{ $transactionHistory['created_at'] }}</td>
                                            <td class="text-center">{{ $transactionHistory['reference_id'] }}</td>
                                            <td class="text-center">{!! $transactionHistory['payment_method'] ? config('constants.type_histories')[$transactionHistory['payment_method']] : null !!}</td>
                                            <td class="text-center">{{ $transactionHistory['user_name'] }}</td>
                                            <td class="text-center color-black fw-500">{{ $transactionHistory['amount'] }}</td>
                                            <td>
                                                @if ($transactionHistory['status'] == 'completed')
                                                    <div class="text-center fw-500 color-success">Thành công</div>
                                                @elseif ($transactionHistory['status'] == 'failed')
                                                    <div class="text-center fw-500 color-danger">Thất bại</div>
                                                @else
                                                    <div class="text-center fw-500 color-warning">Chờ xử lý</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="list-table-footer d-flex justify-content-between align-items-center">
                        <div class="list-table-per-page">
                            <span class="form-label">Hiển thị kết quả</span>
                            <form action="{{ route('admin.manage.partner.wallet', ['id' => $partner_id]) }}" method="GET">
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
                        {{ $transactionHistories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection