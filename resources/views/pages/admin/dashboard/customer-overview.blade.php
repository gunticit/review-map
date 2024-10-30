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
<section class="thong-ke">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-4 col-md-4 col-6 mb-4">
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
      <div class="col-xl-4 col-md-4 col-6 mb-4">
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
      <div class="col-xl-4 col-md-4 col-6 mb-4">
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
      <div class="col-xl-4 col-md-4 col-6 mb-4">
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
      <div class="col-xl-4 col-md-4 col-6 mb-4">
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
      <div class="col-xl-4 col-md-4 col-6 mb-4">
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
        <div class="col-md-10 col-12">
          <div class="section-title d-flex align-center justify-content-center">
            <span class="material-symbols-outlined">
              home_pin
            </span> 
            <h2>Bản đồ, số lượng và vị trí khách hàng</h2>
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
      <!-- end chart  -->
      <div id="map-customer" style="height: 290px; max-width: 100%; margin: 0px auto;">
          <gmp-map center="40.12150192260742,-100.45039367675781" zoom="4" map-id="DEMO_MAP_ID">
            <gmp-advanced-marker position="40.12150192260742,-100.45039367675781" title="My location"></gmp-advanced-marker>
          </gmp-map>
      </div>
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
  <script>
    async function initMap() {
      // Request needed libraries.
      const { Map, InfoWindow } = await google.maps.importLibrary("maps");
      const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
        "marker",
      );
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 3,
        center: { lat: -28.024, lng: 140.887 },
        mapId: "DEMO_MAP_ID",
      });
      const infoWindow = new google.maps.InfoWindow({
        content: "",
        disableAutoPan: true,
      });
      // Create an array of alphabetical characters used to label the markers.
      const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      // Add some markers to the map.
      const markers = locations.map((position, i) => {
        const label = labels[i % labels.length];
        const pinGlyph = new google.maps.marker.PinElement({
          glyph: label,
          glyphColor: "white",
        });
        const marker = new google.maps.marker.AdvancedMarkerElement({
          position,
          content: pinGlyph.element,
        });

        // markers can only be keyboard focusable when they have click listeners
        // open info window when marker is clicked
        marker.addListener("click", () => {
          infoWindow.setContent(position.lat + ", " + position.lng);
          infoWindow.open(map, marker);
        });
        return marker;
      });

      // Add a marker clusterer to manage the markers.
      const markerCluster = new markerClusterer.MarkerClusterer({ markers, map });
    }

    const locations = [
      { lat: -31.56391, lng: 147.154312 },
      { lat: -33.718234, lng: 150.363181 },
      { lat: -33.727111, lng: 150.371124 },
      { lat: -33.848588, lng: 151.209834 },
      { lat: -33.851702, lng: 151.216968 },
      { lat: -34.671264, lng: 150.863657 },
      { lat: -35.304724, lng: 148.662905 },
      { lat: -36.817685, lng: 175.699196 },
      { lat: -36.828611, lng: 175.790222 },
      { lat: -37.75, lng: 145.116667 },
      { lat: -37.759859, lng: 145.128708 },
      { lat: -37.765015, lng: 145.133858 },
      { lat: -37.770104, lng: 145.143299 },
      { lat: -37.7737, lng: 145.145187 },
      { lat: -37.774785, lng: 145.137978 },
      { lat: -37.819616, lng: 144.968119 },
      { lat: -38.330766, lng: 144.695692 },
      { lat: -39.927193, lng: 175.053218 },
      { lat: -41.330162, lng: 174.865694 },
      { lat: -42.734358, lng: 147.439506 },
      { lat: -42.734358, lng: 147.501315 },
      { lat: -42.735258, lng: 147.438 },
      { lat: -43.999792, lng: 170.463352 },
    ];

    initMap();
  </script>
@endsection