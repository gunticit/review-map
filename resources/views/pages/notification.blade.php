@extends('layouts.app')
@section('content')
<section class="section thong-bao mb-5 mt-5">
    <div class="container">
        <div class="col-inner">
            <h2 class="section-title mb-4">Danh sách thông báo</h2>
            {{-- <form>
                <div class="input-group">
                    <button class="input-group-text" type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                </div>
            </form> --}}
            <table class="table list-table">
                <thead>
                    <tr>
                        <th class="list-table-stt" scope="col">STT</th>
                        <th class="list-table-title" scope="col">Tiêu đề</th>
                        <th class="list-table-creator" scope="col">Người tạo</th>
                        <th class="list-table-progree" scope="col">Trạng thái</th>
                        <th class="list-table-time" scope="col">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $index => $notification)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="list-table-title">
                            <a href="10.1.chi-tiet-thong-bao.php">{{ $notification->title }}</a>
                        </td>
                        <td class="list-table-creator">
                            {{ $notification->user->name }}
                        </td>
                        <td class="list-table-progree">
                            <a class="btn btn-{{ $notification->status == 'Đã đọc' ? 'success' : 'danger' }}">{{
                                $notification->status }}</a>
                        </td>
                        <td class="list-table-time">
                            <a href="#">{{ $notification->created_at->format('d/m/Y') }} <span>{{
                                    $notification->created_at->format('H:i') }}</span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Phần phân trang và các thành phần khác giữ nguyên --}}

            <div class="list-table-footer d-flex justify-content-between align-items-center">
                <div class="list-table-per-page">
                    <span class="form-label">Hiển thị kết quả</span>
                    <select class="form-select d-inline-block" name="perPage" id="perPageSelect" onchange="this.form.submit()"> 
                        <option value="10" {{ $notifications->perPage() == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $notifications->perPage() == 20 ? 'selected' : '' }}>20</option>
                        <option value="30" {{ $notifications->perPage() == 30 ? 'selected' : '' }}>30</option>
                        <option value="40" {{ $notifications->perPage() == 40 ? 'selected' : '' }}>40</option>
                    </select>
                </div>
                <nav aria-label="Page navigation">
                    {{ $notifications->links() }} 
                </nav>
            </div>

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
@endsection