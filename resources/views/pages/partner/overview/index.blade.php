@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="row">
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  group
                </span>
                <h5>Tổng số đối tác</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-primary">{!! $projects['total'] ?? 0 !!}</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-4 col-6 mb-4">
            <div class="thong-ke-item text-center">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  person_check
                </span>
                <h5>Tổng số đối tác đã xác thực</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-primary">{!! $projects['total_working'] ?? 0 !!}</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  payments
                </span>
                <h5>Tổng số đối tác đã xác nhận hoa hồng</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-primary">100</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  receipt_long
                </span>
                <h5>Tổng số đơn hàng</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-danger">100</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  task
                </span>
                <h5>Tổng số nhiệm vụ đã hoàn thành</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-danger">100</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  tv_options_edit_channels
                </span>
                <h5>Số nhiệm vụ đang thực hiện</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-danger">100</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel">
          <div class="panel-body">
            <h4>Cấp độ thành viên</h4>
            <div id="chart-partner"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end thong ke  -->
<!-- du-an-cua-ban -->
<section class="du-an-cua-ban">
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
                name: "Số tiền kiếm được",
                axisYType: "secondary",
                showInLegend: true,
                color: "#95ADFF",
                dataPoints: @json($data_chars['money_earned'])
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
</section>
@endsection