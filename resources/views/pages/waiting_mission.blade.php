@extends('layouts.app')
@section('content')
<section class="section">
    <div class="container-fluid">
        <div class="col-inner mt-3">
            <div class="text-center mt-5">
                <h3>Thời gian nhận nhiệm vụ tiếp theo</h3>
            </div>
            <div id="countdown"></div>
            <div class="text-center d-flex justify-content-center">
                <button class="mt-2 d-flex gap-2 btn btn-primary my-auto" onclick="window.location.href='{{ route('mission.histories') }}'">
                    <span class="material-symbols-outlined">
                        history
                    </span>
                    <span>Lịch sử nhiệm vụ</span>
                </button>
            </div>
        </div>
        <div class="col-inner mt-3">
            <h3>Cấp độ tài khoản</h3>
            <div class="text-start">
                <p>Lưu ý: Thời gian chờ và hoa hồng của nhiệm vụ tùy thuộc vào cấp bậc của tài khoản người dùng!</p>
            </div>
            <table class="table list-table">
                <thead>
                    <tr>
                        <th scope="col">Cấp độ tài khoản</th>
                        <th scope="col">Thời gian chờ</th>
                        <th scope="col">Điều kiện tăng cấp</th>
                        <th scope="col">Lợi nhuận</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">Tài khoản cấp 01</td>
                        <td class="text-center">12 tiếng</td>
                        <td class="text-center">Không</td>
                        <td class="text-center">10.000 VND/nhiệm vụ</td>
                    </tr>
                    <tr>
                        <td scope="row">Tài khoản cấp 02</td>
                        <td class="text-center">6 tiếng</td>
                        <td class="text-center">Hoàn thành 5 nhiệm vụ</td>
                        <td class="text-center">11.000 VND/nhiệm vụ</td>
                    </tr>
                    <tr>
                        <td scope="row">Tài khoản cấp 03</td>
                        <td class="text-center">3 tiếng</td>
                        <td class="text-center">Hoàn thành 10 nhiệm vụ</td>
                        <td class="text-center">12.000 VND/nhiệm vụ</td>
                    </tr>
                    <tr>
                        <td scope="row">Tài khoản cấp 04</td>
                        <td class="text-center">2 tiếng</td>
                        <td class="text-center">Hoàn thành 50 nhiệm vụ</td>
                        <td class="text-center">13.000 VND/nhiệm vụ</td>
                    </tr>
                    <tr>
                        <td scope="row">Tài khoản cấp 05</td>
                        <td class="text-center">1 tiếng</td>
                        <td class="text-center">Hoàn thành 100 nhiệm vụ</td>
                        <td class="text-center">14.000 VND/nhiệm vụ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
@section('css')
<style>
    /* Định dạng tổng thể của phần tử đếm ngược */
    #countdown {
        font-family: 'Arial', sans-serif;
        font-size: 48px;
        font-weight: bold;
        text-align: center;
        padding: 20px;
        color: #000;
        border-radius: 10px;
        width: 450px;
        max-width: 100%;
        margin: 5px auto;
        transition: all 0.3s ease-in-out;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Hiệu ứng khi đồng hồ đếm ngược gần hết */
    #countdown.warning {
        background-color: #ff6347; /* Màu đỏ cam */
        color: white;
        box-shadow: 0 4px 12px rgba(255, 99, 71, 0.5);
        transform: scale(1.05);
        font-size: 35px;
    }

    /* Thêm hiệu ứng rung cho khi gần hết thời gian */
    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }

    #countdown.shake {
        animation: shake 0.5s ease-in-out;
    }
    @media(max-width: 768px){
        #countdown{
            width: 300px;
            padding: 5px;
        }
        #time-hours, #time-minutes, #time-seconds {
            font-size: 22px;
        }
    }
</style>
@endsection
@section('js')
<script>
    const time = {{$time_waiting}}; // Ví dụ timestamp (có thể là 1 thời điểm tương lai)

    function countdown() {
    const now = new Date().getTime(); // Thời gian hiện tại
    const distance = time - now; // Khoảng cách giữa timestamp và thời gian hiện tại

    const countdownElement = document.getElementById("countdown");

    // Kiểm tra nếu thời gian đã hết hoặc chưa đến
    if (distance <= 0) {
        countdownElement.innerHTML = "Đã đến thời gian!";
        countdownElement.classList.add('warning'); // Thêm lớp cảnh báo khi hết giờ
        clearInterval(timer); // Dừng đếm ngược khi đến thời gian
    } else {
        // Tính toán số giờ, phút và giây còn lại
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Cập nhật hiển thị lên giao diện
        countdownElement.innerHTML =  "<span id='time-hours'>"+(hours <10 ? "0"+hours : hours)+" : </span>" + "<span id='time-minutes'>"+(minutes <10 ? "0"+minutes : minutes)+" : </span>" + "<span id='time-seconds'>"+(seconds <10 ? "0"+seconds : seconds)+"</span>" ;
        
        // Thêm hiệu ứng rung khi gần hết thời gian
        if (distance <= 60000) { // 60 giây còn lại
        countdownElement.classList.add('shake');
        } else {
        countdownElement.classList.remove('shake');
        }
    }
    }

    // Cập nhật thời gian mỗi giây
    const timer = setInterval(countdown, 1000);
</script>
@endsection