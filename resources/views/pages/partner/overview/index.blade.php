@extends('layouts.app')
@section('content')

<!-- thong ke -->
<section class="thong-ke">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-2 col-md-4 col-6 mb-4 mb-xl-0">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">contract</span>
            <h5>Nhiệm vụ <br> đã nhận</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">100</h6>
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
            <h6 class="text-primary">90</h6>
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
            <h6 class="text-primary">10</h6>
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
            <h6 class="text-primary">10</h6>
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
            <h6 class="text-primary">10</h6>
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
            <h6 class="text-success">500.000 VND</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end thong ke  -->
<!-- du-an-cua-ban -->
<section class="du-an-cua-ban">
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
          <select class="form-select" aria-label="Default select example">
            <option>Năm</option>
            <option value="1">2024</option>
            <option value="2">2023</option>
            <option value="3">2025</option>
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
                dataPoints: [{
                  label: "Tháng 1",
                  y: 60
                }, {
                  label: "Tháng 2",
                  y: 40
                }, {
                  label: "Tháng 3",
                  y: 100
                }, {
                  label: "Tháng 4",
                  y: 70
                }, {
                  label: "Tháng 5",
                  y: 50
                }, {
                  label: "Tháng 6",
                  y: 60
                }, {
                  label: "Tháng 7",
                  y: 50
                }, {
                  label: "Tháng 8",
                  y: 49
                }, {
                  label: "Tháng 9",
                  y: 70
                }, {
                  label: "Tháng 10",
                  y: 34
                }, {
                  label: "Tháng 11",
                  y: 24
                }, {
                  label: "Tháng 12",
                  y: 64
                }, ]
              },
              // set data Số tiền kiếm được
              {
                type: "column",
                name: "Số tiền kiếm được",
                axisYType: "secondary",
                showInLegend: true,
                color: "#E8EDFF",
                dataPoints: [{
                  label: "Tháng 1",
                  y: 70
                }, {
                  label: "Tháng 2",
                  y: 30
                }, {
                  label: "Tháng 3",
                  y: 30
                }, {
                  label: "Tháng 4",
                  y: 40
                }, {
                  label: "Tháng 5",
                  y: 70
                }, {
                  label: "Tháng 6",
                  y: 30
                }, {
                  label: "Tháng 7",
                  y: 40
                }, {
                  label: "Tháng 8",
                  y: 79
                }, {
                  label: "Tháng 9",
                  y: 80
                }, {
                  label: "Tháng 10",
                  y: 20
                }, {
                  label: "Tháng 11",
                  y: 50
                }, {
                  label: "Tháng 12",
                  y: 20
                }, ]
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
      <div id="chartContainer" style="height: 290px; max-width: 100%; margin: 0px auto;"></div>
    </div>
  </div>
</section>
@endsection