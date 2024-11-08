@extends('layouts.app')
@section('content')

<!-- thong ke -->
<section class="thong-ke skeleton">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      </div>
      <div class="col-xl-2 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">contract</span>
            <h5>Nhiệm vụ <br> đã nhận</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{{ $total_mission }}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">task</span>
            <h5>Đã hoàn thành</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{{ $total_mission_by_status[1] }}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">scan_delete</span>
            <h5>Bị từ chối</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{{ $total_mission_by_status[5] }}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">hourglass_top</span>
            <h5>Đang chờ <br> hệ thống duyệt</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{{ $total_mission_by_status[3] }}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">hourglass_bottom</span>
            <h5>Đang chờ <br> nhân viên duyệt</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{{ $total_mission_by_status[4] }}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">paid</span>
            <h5>Tổng dư ví</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-success">{!! moneyFormat($balance) ?? 0 !!} VND</h6>
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
            <h2>Dự án của bạn</h2>
          </div>
        </div>
        <div class="col-md-2 col-12">
          <div class="form-group">
            <select class="form-select" aria-label="Lọc theo năm">
              <option>Năm</option>
              <option value="{!! date('Y') - 1 !!}">{!! date('Y') - 1 !!}</option>
              <option value="{!! date('Y') !!}">{!! date('Y') !!}</option>
              <option value="{!! date('Y') + 1 !!}">{!! date('Y') + 1 !!}</option>
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
              // set data Số tiền kiếm được
              {
                type: "column",
                name: "Số tiền kiếm được",
                axisYType: "secondary",
                showInLegend: true,
                color: "#E8EDFF",
                dataPoints: @json($data_chars['money_earned'])
              },
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