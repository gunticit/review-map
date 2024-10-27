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
            <table class="table list-table">
                <thead>
                    <tr>
                        <th class="list-table-stt" scope="col">STT</th>
                        <th class="list-table-time" scope="col">Thời gian</th>
                        <th class="list-table-title" scope="col">Nhật ký hoạt động</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($histories))
                        @php $stt = 1; @endphp
                        @foreach($histories as $history)
                        <tr>
                            <td>{{ $stt }}</td>
                            <td class="list-table-time">{!! $history['created_at']->format('d/m/Y') !!} <span>{!! $history['created_at']->format('H:i') !!}</span></td>
                            <td class="list-table-title"> 
                                @php
                                    $history_content = !empty($history['content'])?json_decode($history['content'], true):[];   
                                @endphp
                                {!! $history_content['title'] ?? '' !!} {!! $history_content['content'] ? ' - '.$history_content['content'] : '' !!}
                            </td>
                        </tr>
                        @php $stt++; @endphp
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $histories->links('vendor.pagination.custom') }}
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