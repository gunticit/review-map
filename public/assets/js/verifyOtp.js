$(document).ready(function () {
    let currentTab = 0;

    // Hàm hiển thị tab hiện tại
    function showTab(n) {
        $(".tab").hide(); // Ẩn tất cả các tab
        $(".tab").eq(n).show(); // Hiển thị tab được chỉ định
    }

    // Hàm gửi yêu cầu AJAX
    function sendAjaxRequest(form, successCallback) {
        $.ajax({
            url: form.attr('action'), // Lấy URL từ thuộc tính action của form
            method: 'POST', // Phương thức gửi dữ liệu
            data: form.serialize(), // Chuỗi hóa dữ liệu từ form
            success: function (response) {
                if (response.success) {
                    successCallback(response); // Gọi lại hàm callback nếu thành công
                } else {
                    showAlert(response.message || 'Có lỗi xảy ra!'); // Hiển thị thông báo lỗi
                }
            },
            error: function (xhr) {
                handleAjaxError(xhr, form); // Xử lý lỗi AJAX
            },
            complete: function () {
                // Ẩn thông báo/loading, hiển thị lại nút và kích hoạt lại nút
                $('#loadingMessage').hide();
                $('#buttonText').show();
                $('#nextBtn').prop('disabled', false);
            }
        });
    }

    // Hàm xử lý lỗi AJAX
    function handleAjaxError(xhr, form) {
        if (xhr.status === 422) {
            const response = xhr.responseJSON; // Lấy phản hồi JSON từ server
            form.find('.error-message').text("*" + response.message || 'Có lỗi xảy ra!').removeClass('d-none'); // Hiển thị thông báo lỗi từ server
        } else {
            showAlert('Đã xảy ra lỗi khi gửi dữ liệu. Vui lòng thử lại.'); // Thông báo lỗi chung
        }
        // Xử lý lỗi cho OTP
        if (form.attr('id') === 'otpForm') {
            let otpAttemptsInput = $('#otpAttempts');
            let currentAttempts = parseInt(otpAttemptsInput.val()) || 0;
            otpAttemptsInput.val(currentAttempts + 1); // 

            if (currentAttempts + 1 >= 5) {
                showAlert('Bạn đã nhập sai mã OTP quá nhiều lần. Vui lòng thử lại sau.');
                setTimeout(function () {
                    location.reload(); 
                }, 5000); 
            }
        }
    }

    // Xử lý sự kiện khi nút "Tiếp tục" được click
    $('#nextBtn').click(function () {
        let currentTabElement = $(".tab").eq(currentTab); // Lấy tab hiện tại

        // Kiểm tra xem form hiện tại có hợp lệ không
        if (currentTabElement.find('input').get(0).checkValidity()) {
            $('#loadingMessage').show(); // Hiển thị thông báo/loading
            $('#buttonText').hide(); // Ẩn văn bản "Tiếp tục"
            $('#nextBtn').prop('disabled', true); // Vô hiệu hóa nút để ngăn nhiều lần click

            // Kiểm tra tab hiện tại và gửi dữ liệu tương ứng
            if (currentTab === 0) {
                sendAjaxRequest($('#emailForm'), function (response) {
                    $('#emailOtp').val(response.data.email);
                    $('#otpMessage').text('Vui lòng nhập mã OTP đã gửi đến email của bạn: ' + response.data.email);
                    currentTab++;
                    showTab(currentTab); 
                });
            } else if (currentTab === 1) {
                // Gửi dữ liệu OTP
                sendAjaxRequest($('#otpForm'), function (response) {
                    $('#emailResetPass').val(response.data.email);
                    currentTab++;
                    showTab(currentTab); 
                });
            } else if (currentTab === 2) {
                sendAjaxRequest($('#passwordForm'), function () {

                    $('#nextBtn').hide(); // Ẩn nút nếu thành công
                    currentTab++;
                    showTab(currentTab); // Chuyển sang tab tiếp theo
                });
            }
        } else {
            currentTabElement.find('input')[0].reportValidity(); // Hiển thị thông báo lỗi nếu form không hợp lệ
        }
    });

    showTab(currentTab); // Hiển thị tab đầu tiên khi trang được tải
});

// Hàm giới hạn chỉ cho phép nhập 1 chữ số
function limitInputLength(input) {
    if (input.value.length > 1) {
        input.value = input.value.slice(0, 1); // Cắt giá trị chỉ giữ lại 1 chữ số
    }
}
