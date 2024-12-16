@extends('layouts.app')
@section('content')
<!-- lich-su-hoat-dong -->
<section class="section lich-su-hoat-dong mb-5 mt-5">
    <div class="container-fluid">
        <div class="col-inner">
            <h2 class="section-title mb-4">Lịch sử hoạt động</h2>
            <form action="{{ route('history') }}" method="GET">
                <div class="row section-form">
                    <div class="col-xl-8 col-md-8 col-12">
                        <div class="input-group">
                            <input type="text" placeholder="Tìm kiếm" value="{!! $filter['keyword'] ?? '' !!}" name="keyword" class="form-control" id="inputSearch">
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-12 d-flex gap-4">
                        <input type="text" class="form-control datepick" value="{!! $filter['date'] ?? '' !!}" name="date" id="datepick">
                        <button class="input-group-text" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                </div>
                    
            </form>
            <div class="group-table-list">
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" width="50" scope="col">STT</th>
                            <th class="list-table-time text-start" width="200" scope="col">Thời gian</th>
                            <th class="list-table-title text-start" width="1000" scope="col">Nhật ký hoạt động</th>
                            <th class="list-table-title text-start" width="200" scope="col">Người tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($histories) && count($histories) > 0)
                            @foreach($histories as $key => $history)
                            <tr>
                                <td width="50">{{ ($histories->currentPage() - 1) * $histories->perPage() + $key + 1 }}</td>
                                <td class="list-table-time">{!! $history['created_at']->format('d/m/Y') !!} <span>{!! $history['created_at']->format('H:i') !!}</span></td>
                                <td class="list-table-title"> 
                                    @php
                                        $history_content = !empty($history['content'])?json_decode($history['content'], true):[];   
                                    @endphp
                                    {!! $history_content['title'] ?? '' !!} {!! $history_content['content'] ? ' - '.$history_content['content'] : '' !!}
                                </td>
                                <td>
                                    {{ $history['createdBy']->name }}
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="no-result">
                                <td colspan="4">
                                    <img src="{{ asset('assets/img/no-image.svg') }}" alt="no-data"> <span>{{ __('Chưa có lịch sử hoạt động') }}</span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @if(!empty($histories))
            {{ $histories->links('vendor.pagination.custom') }}
            @endif
        </div>
    </div>
</section>

<!-- Jquery daterangepicker -->
<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.min.js"></script>

<script>
    $.datetimepicker.setLocale('vi');
    $(document).ready(function($) {
        $('#datepick').datetimepicker({
            i18n:{
                vi:{
                    months:[
                        'T1','T2','T3','T4',
                        'T5','T6','T7','T8',
                        'T9','T10','T11','T12',
                    ],
                    dayOfWeek:[
                        "CN", "Th2", "Th3", "Th4",
                        "Th5", "Th6", "Th7",
                    ]
                }
            },
            timepicker:false,
            format:'Y-m-d',
        });
    });
</script> 
@endsection