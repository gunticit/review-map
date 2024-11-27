@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke skeleton">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">
        <div class="row">
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center mb-0">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  group
                </span>
                <h5>Tổng số đối tác</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-primary">{!! $total_partner ?? 0 !!}</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-4 col-6 mb-4">
            <div class="thong-ke-item text-center mb-0">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  person_check
                </span>
                <h5>Tổng số đối tác đã xác thực</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-primary">{!! $total_verify ?? 0 !!}</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center mb-0">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  payments
                </span>
                <h5>Tổng số đối tác đã xác nhận hoa hồng</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-primary">{{ $has_commission }}</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center mb-0">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  receipt_long
                </span>
                <h5>Tổng số đơn hàng</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-danger">{{ $order_total }}</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center mb-0">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  task
                </span>
                <h5>Tổng số nhiệm vụ đã hoàn thành</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-danger">{{ $mission_complete }}</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="thong-ke-item text-center mb-0">
              <div class="thong-ke-head">
                <span class="material-symbols-outlined">
                  tv_options_edit_channels
                </span>
                <h5>Số nhiệm vụ đang thực hiện</h5>
              </div>
              <div class="thong-ke-content">
                <h6 class="text-danger">{{ $mission_working }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-chart">
          <div class="panel-body">
            <h4>Cấp độ thành viên</h4>
            <div id="chart-partner-overview" style="height: 370px; width: 100%;"></div>
            <div id="chartLabels" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end thong ke  -->
<!-- du-an-cua-ban -->
<section class="du-an-cua-ban mb-4">
  <div class="container-fluid">
    <div class="col-inner">
      <div class="row">
        <div class="col-md-10 col-12">
          <div class="section-title">
            <span>Bản đồ</span>
            <h2>Số lượng, vị trí đối tác {{ $filter_data['year'] }}</h2>
          </div>
        </div>
        <div class="col-md-2 col-12">
          <div class="form-group">
            <select class="form-select" onchange="handleChangeYear(this.value)" aria-label="Default select example">
              <option>Năm</option>
              @if(!empty($years))
                @foreach($years as $year)
                  <option {{ $filter_data['year'] == $year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>
      </div>
      <div id="map" style="height: 500px; max-width: 100%; margin: 0px auto;"></div>
    </div>
  </div>
</section>
@endsection
@section('js')
  <script>
      window.onload = function () {
      
      var chart = new CanvasJS.Chart("chart-partner-overview", {
        exportEnabled: true,
        animationEnabled: true,
        title:{
          text: ""
        },
        legend:{
          cursor: "pointer",
          itemclick: explodePie
        },
        data: [{
          type: "doughnut",
          innerRadius: 60,
          showInLegend: true,
          indexLabelPlacement: "inside",
          toolTipContent: "<strong>{y}%</strong>",
          indexLabel: "{y}%",
          dataPoints: @json($data_chart_level)
        }]
      });
      chart.render();
    }
    
    function explodePie (e) {
      if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
      } else {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
      }
      e.chart.render();
    
    }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap" async defer></script>
  <script>
    let map;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: {{$current_lat}}, lng: {{$current_long}} }, 
            zoom: 10,
        });
        const locations = @json($data_partner_data);
        locations.forEach(location => {
            const marker = new google.maps.Marker({
                position: { lat: location.latitude, lng: location.longitude },
                map: map,
                title: location.name,
            });
            let urlMap = `{{ route('admin.manage.partner.info', ['id' => ':id']) }}`.replace(':id', location.id);
            const infoWindowContent = `<h5><a href="${urlMap}">${location.name}</a></h5>`;
            const infoWindow = new google.maps.InfoWindow({
                content: infoWindowContent,
            });
            marker.addListener("click", () => {
                infoWindow.open(map, marker);
            });
        });
    }
  </script>
  <script>
    function handleChangeYear(year){
      window.location.href = '/admin/overview-partner?year='+year;
    }
  </script>
@endsection