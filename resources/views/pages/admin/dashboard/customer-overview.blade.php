@extends('layouts.app')
@section('css')
  <style>
    .section-title span {
      font-size: 30px;
      color: #5D6A83;
    }
  </style>
@endsection
@section('content')
<!-- thong ke -->
<section class="thong-ke skeleton">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-4 col-md-4 col-6">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">contract</span>
            <h5>Tổng số khách hàng</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $overview['total_customer'] ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-4 col-6">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">task</span>
            <h5>Tổng số dự án</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $overview['total_project'] ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-4 col-6">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">
                fact_check
            </span>
            <h5>Số dự án hoàn thành</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-primary">{!! $overview['total_project_complete'] ?? 0 !!}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-4 col-6">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">
            list_alt_add
            </span>
            <h5>Số dự án đang thực hiện</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-danger">{{ $overview['total_project_working'] }}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-4 col-6">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">
                inactive_order
            </span>
            <h5>Số dự án đã tạm ngừng</h5>
          </div>
          <div class="thong-ke-content">
            <h6 class="text-danger">{{ $overview['total_project_pause'] }}</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-4 col-6">
        <div class="thong-ke-item text-center">
          <div class="thong-ke-head">
            <span class="material-symbols-outlined">
                inactive_order
            </span>
            <h5>Số dự án yêu cầu bảo hành</h5>
          </div>
          <div class="thong-ke-content"><h6 class="text-danger">{{ $overview['total_project_guarantee'] }}</h6>
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
        <div class="col-md-12 col-12 relative">
          <div class="section-title d-flex align-center justify-content-center">
            <span class="material-symbols-outlined">
              home_pin
            </span> 
            <h2>Bản đồ, số lượng và vị trí khách hàng  {{ $filters['year'] }}</h2>
          </div>

          <select class="form-select" onchange="handleChangeYear(this.value)" aria-label="Năm" style="position: absolute;top: -10px;right: 10px;z-index: 2">
            <option>Năm</option>
            @if(!empty($years))
              @foreach($years as $year)
                <option {!! !empty($filters['year']) && $filters['year'] == $year ? 'selected':'' !!} value="{{ $year }}">{{ $year }}</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      <!-- end chart  -->
      
      <div id="map" style="height: 500px; max-width: 100%; margin: 0px auto;"></div>
    </div>
  </div>
</section>
@endsection

@section('css')
  <style>
    gmp-map {
      height: 100%;
    }
  </style>
@endsection

@section('js')
  <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=console.debug&libraries=maps,marker&v=beta">
  </script>
  <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
  
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap" async defer></script>
  <script>
    let map;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: {{$current_lat}}, lng: {{$current_long}} }, 
            zoom: 10,
        });
        const locations = @json($data_customer_data);
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
      window.location.href='/admin/overview-customer?year='+year;
    }
  </script>
@endsection