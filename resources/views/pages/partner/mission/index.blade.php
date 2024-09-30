@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container">
            <div class="row">
                <div class="clear col-sm-12 text-right">
                    <button class="btn btn-primary my-3" type="button" onclick="window.location.href='{{ route('category.create') }}'">
                        <i class="fas fa-plus"></i> Tạo danh mục
                    </button>
                </div>
            </div>
            <div class="col-inner">
                <div class="card text-center">
                    <div class="card-header">
                      Nhận nhiệm vụ
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">Special title treatment</h5>
                      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                      <a href="#" class="btn btn-primary">Bước tiếp</a>
                    </div>
                    <div class="card-footer text-muted">
                      
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection