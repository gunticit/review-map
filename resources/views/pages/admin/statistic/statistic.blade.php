@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke">
  <div class="container">
    <div class="row">
      <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">contract</span>
            <h5>Thống kê doanh thu</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $projects['total'] ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">task</span>
            <h5>Tổng chi phí</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $projects['total_working'] ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">scan_delete</span>
            <h5>Tổng chi phí</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $projects['total_stopped'] ?? 0 !!}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end thong ke  -->
<!-- du-an-cua-ban -->
<section class="du-an-cua-ban">
  <div class="container">
    <div class="col-inner">
      <div class="row">
        <div class="col-md-10 col-12">
          <div class="section-title">
            <span>Tổng quan</span>
            <h2>Dự án của bạn</h2>
          </div>
        </div>
        <div class="col-md-2 col-12">
          <select class="form-select" aria-label="Default select example">
            <option>Năm</option>
            @if(!empty($filters['years']))
              @foreach($filters['years'] as $year)
                <option value="{{ $year }}">{{ $year }}</option>
              @endforeach
            @endif
          </select>
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
                dataPoints: @json($data_chars['revenue'] ?? [])
              },

              // set data Đánh giá đã phân phối
              {
                type: "column",
                name: "Đánh giá đã phân phối",
                axisYType: "secondary",
                showInLegend: true,
                color: "#95ADFF",
                dataPoints: @json($data_chars['commission'] ?? [])
              },

              // set data Tổng lợi nhuận
              {
                type: "column",
                name: "Chi phí bảo hành",
                axisYType: "thirdary",
                showInLegend: true,
                color: "#E8EDFF",
                dataPoints: @json($data_chars['profits'] ?? [])
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
      <div id="chartContainer" style="height: 290px; max-width: 100%; margin: 0px auto;"></div>
    </div>
  </div>
</section>
@endsection