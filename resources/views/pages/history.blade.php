@extends('layouts.app')
@section('content')
<!-- lich-su-hoat-dong -->
<section class="section lich-su-hoat-dong mb-5 mt-5">
    <div class="container">
        <div class="col-inner">
            <h2 class="section-title mb-4">Lịch sử hoạt động</h2>
            <form>
                <div class="row section-form">
                    <div class="col-xl-9 col-md-8 col-12">
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-12">
                        <input type="text" class="form-control datepick" name="datepick" id="datepick">
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
                            <td class="list-table-time">{!! $history[0]['created_at']->format('d/m/Y') !!} <span>{!! $history[0]['created_at']->format('H:i') !!}</span></td>
                            <td class="list-table-title"> {{ $history[0]['content'] }}</td>
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
    // Jquery 
    jQuery(document).ready(function($) {
        //Jquery daterangepicker
        $('.datepick').daterangepicker();
    });
</script> 
@endsection