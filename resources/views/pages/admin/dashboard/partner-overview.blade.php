@extends('layouts.app')
@section('content')
<!-- thong ke -->
<section class="thong-ke">
  <div class="container-fluid">
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
  <div class="container-fluid">
    <div class="col-inner">
      <div class="row">
        <div class="col-md-10 col-12">
          <div class="section-title">
            <span>Bản đồ</span>
            <h2>Số lượng, vị trí đối tác</h2>
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
      <div id="map-partner" style="height: 290px; max-width: 100%; margin: 0px auto;"></div>
    </div>
  </div>
</section>
@endsection