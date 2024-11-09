@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke skeleton">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">contract</span>
            <h5>Tổng dự án</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $total ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">task</span>
            <h5>{{ __('common.doing') }}</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $working ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">scan_delete</span>
            <h5>Đã tạm dừng</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $stopped ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-4 col-6 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">attach_money</span>
            <h5>Đã chi tiêu</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-danger">{{ formatCurrency($money['spent']) }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end thong ke  -->
<!-- du-an-cua-ban -->
<section class="du-an-cua-ban skeleton">
  <div class="container-fluid">
    <div class="col-inner">
      <div class="row">
        <div class="col-md-10 col-12">
          <div class="section-title">
            <span>Tổng quan</span>
            <h2>Chi phí</h2>
          </div>
        </div>
        <div class="col-md-2 col-12">
          <div class="form-group">
            <select class="form-select" aria-label="Lọc theo năm" id="filter-year">
              <option value="">Năm</option>
              @if(!empty($filters['years']))
                @foreach($filters['years'] as $year)
                  <option {!! $filter_data['year'] == $year ? 'selected' : '' !!} value="{{ $year }}">{{ $year }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>
      </div>
      <!-- chart  -->
      <script>
        window.onload = function() {
          var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            toolTip: {
              shared: true
            },
            axisX: {
              interval: 1
            },
            legend: {
              cursor: "pointer",
              itemclick: toggleDataSeries
            },
            dataPointWidth: 16,
            data: [
              // set data Đánh giá đã hoàn thành
              {
                type: "column",
                name: "Đánh giá đã hoàn thành",
                showInLegend: true,
                color: "#436CFF",
                dataPoints: @json($data_chars['completed'])
              },
              // set data Đánh giá đã phân phối
              {
                type: "column",
                name: "Đánh giá đã phân phối",
                axisYType: "secondary",
                showInLegend: true,
                color: "#95ADFF",
                dataPoints: @json($data_chars['distributed'])
              },
              // set data Giá trị chi tiêu
              {
                type: "column",
                name: "Giá trị chi tiêu",
                axisYType: "thirdary",
                showInLegend: true,
                color: "#E8EDFF",
                dataPoints: @json($data_chars['spents'])
              }
            ]
          });
          chart.render();

          function toggleDataSeries(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
            } else {
              e.dataSeries.visible = true;
            }
            chart.render();
          }
        }
      </script>
      <!-- end chart  -->
      <div class="group-chart">
        <div id="chartContainer" style="height: 290px; max-width: 100%; margin: 0px auto;"></div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('js')
  <script>
    $(document).ready(function(){
      $('#filter-year').on('change', function(){
        let year = $(this).val();
        if(year){
          window.location.href = "{{ route('customer.overview') }}?year=" + year;
        }else{
          window.location.href = "{{ route('customer.overview') }}";
        }
      })
    });
  </script>
@endsection