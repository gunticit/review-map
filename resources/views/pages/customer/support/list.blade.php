@extends('layouts.app')
@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-wrap">
  <div class="container">
    
        <div class="row align-items-center">
            <div class="col-xl-9 col-md-8 col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Yêu cầu hỗ trợ</li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-md-8 col-12 text-right">
                <a href="{{ route('support.create') }}" class="btn btn-primary">
                    <span class="material-symbols-outlined">add</span>
                    Tạo yêu cầu
                </a>
            </div>
        </div>

    
    
     
  </div>
</section>

<!-- danh-sach-du-an -->
<section class="section danh-sach-du-an mb-5">
    <div class="container">
        <div class="col-inner">
            <h2 class="section-title mb-4">Yêu cầu hỗ trợ</h2>
            <form>
                <div class="input-group">
                    <button class="input-group-text" type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                </div>
            </form>
            <table class="table list-table">
                <thead>
                    <tr>
                        <th class="list-table-stt" scope="col">STT</th>
                        <th class="list-table-title" scope="col">Tiêu đề</th>
                        <th class="list-table-sku" scope="col">Mã đơn</th>
                        <th class="list-table-time" scope="col">Thời gian</th>
                        <th class="list-table-progree" scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($supports))
                    @foreach ($supports as $support)
                    <tr>
                        <td>1</td>
                        <td class="list-table-title">
                            <a href="#">{{ $support->title }}</a>
                        </td>
                        <td class="list-table-sku">
                            <a href="#">{{ $support->title }}</a>
                        </td>
                        <td class="list-table-time">
                            {!! date('d/m/Y', strtotime($support->created_at)) !!} <span>{!! date('hh:mm', strtotime($support->created_at)) !!}</span>
                        </td>
                        <td class="list-table-progree">
                            <span class="btn btn-primary ">{!! __($support->status) !!}</span>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="list-table-footer d-flex justify-content-between align-items-center">
                <div class="list-table-per-page">
                    <span class="form-label">Hiển thị kết quả</span>
                    <select class="form-select d-inline-block" name="" id="">
                        <option selected>10</option>
                        <option value="">20</option>
                        <option value="">30</option>
                        <option value="">40</option>
                    </select>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <span class="page-link" href="#">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">20</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- end danh-sach-du-an -->
@endsection