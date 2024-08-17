@extends('layouts.app')
@section('content')
<!-- lich-su-hoat-dong -->
<section class="section lich-su-hoat-dong mb-5 mt-5">
    <div class="container">
        <div class="col-inner">
            <h2 class="section-title mb-4">Lịch sử hoạt động</h2>
            <form>
                <div class="row section-form">
                    <div class="col-xl-9 col-md-8 col-12">
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-12">
                        <input type="text" class="form-control datepick" name="datepick" id="datepick">
                    </div>
                </div>
                    
            </form>
            <table class="table list-table">
                <thead>
                    <tr>
                        <th class="list-table-stt" scope="col">STT</th>
                        <th class="list-table-time" scope="col">Thời gian</th>
                        <th class="list-table-title" scope="col">Nhật ký hoạt động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title"> Nạp thành công số tiền <strong>1.000.000</strong> vào tài khoản</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title">Nạp tiền thất bại</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title">Đăng nhập thành công</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title">Tạo dự án <strong>[Dự án cho Gói Review Map Đánh Giá Cho Nhà Hàng]</strong></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title">Đã thanh toán cho <strong> [Dự án cho Gói Review Map Đánh Giá Cửa hàng ABC]</strong> với số tiền <strong>5.000.000 VND</strong></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title"> Nạp thành công số tiền <strong>1.000.000</strong> vào tài khoản</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title"> Nạp thành công số tiền <strong>1.000.000</strong> vào tài khoản</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title"> Nạp thành công số tiền <strong>1.000.000</strong> vào tài khoản</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title"> Nạp thành công số tiền <strong>1.000.000</strong> vào tài khoản</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td class="list-table-time">27/06/2024 <span>07:28</span></td>
                        <td class="list-table-title"> Nạp thành công số tiền <strong>1.000.000</strong> vào tài khoản</td>
                    </tr>
                    
                    
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

<!-- Jquery daterangepicker -->
<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.min.js"></script>

<script>
    // Jquery 
    jQuery(document).ready(function($) {
        //Jquery daterangepicker
        $('.datepick').daterangepicker();
    });
</script> 
@endsection