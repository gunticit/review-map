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
  <div class="container">
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
  <div class="container">
    <div class="col-inner">
      <div class="row">
        <div class="col-md-10 col-12">
          <div class="section-title d-flex">
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
      <div id="map-customer" style="height: 290px; max-width: 100%; margin: 0px auto;"></div>
    </div>
  </div>
</section>
@endsection

@section('css')