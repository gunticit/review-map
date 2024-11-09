@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke skeleton">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-4 col-md-4 col-6 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">
              monitoring
            </span>
            <h5>Thống kê doanh thu</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! moneyFormat($total_earning) ?? 0 !!} VND</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-4 col-6 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">
              paid
            </span>
            <h5>Tổng chi phí</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! moneyFormat($total_expense) ?? 0 !!} VND</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-4 col-6 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">
              query_stats
            </span>
            <h5>Tổng lợi nhuận</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! moneyFormat($total_profit) ?? 0 !!}</h6>
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
            <h2>Chi phí</h2>
          </div>
        </div>
        <div class="col-md-2 col-12">
          <div class="form-group">
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
              // set data Tổng chi phí
              {
                type: "column",
                name: "Tổng chi phí",
                showInLegend: true,
                color: "#436CFF",
                dataPoints: @json($data_chars['total_cost'])
              },
              // set data Chi phí hoa hồng
              {
                type: "column",
                name: "Chi phí hoa hồng",
                axisYType: "secondary",
                showInLegend: true,
                color: "#95ADFF",
                dataPoints: @json($data_chars['total_commission'])
              },
              // set data Chi phí bảo hành
              {
                type: "column",
                name: "Chi phí bảo hành",
                axisYType: "thirdary",
                showInLegend: true,
                color: "#E8EDFF",
                dataPoints: @json($data_chars['total_warranty'])
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