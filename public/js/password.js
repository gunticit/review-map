document.getElementById('change-password-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngăn chặn submit form mặc định
    
    // Lấy giá trị từ form
    var oldPassword = document.getElementById('old_password').value;
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = document.getElementById('confirm_password').value;

    // Đặt các điều kiện kiểm tra
    var constraints = {
        old_password: {
            presence: { message: "Vui lòng nhập mật khẩu cũ" }
        },
        new_password: {
            presence: { message: "Vui lòng nhập mật khẩu mới" },
            length: {
                minimum: 8,
                message: "Mật khẩu mới phải có ít nhất 8 ký tự"
            }
        },
        confirm_password: {
            presence: { message: "Vui lòng xác nhận mật khẩu" },
            equality: {
                attribute: "new_password",
                message: "Xác nhận mật khẩu không khớp"
            }
        }
    };

    // Validate form dựa trên các điều kiện
    var formValues = {
        old_password: oldPassword,
        new_password: newPassword,
        confirm_password: confirmPassword
    };

    var errors = validate(formValues, constraints);
    
    // Hiển thị lỗi nếu có
    var errorMessages = document.getElementById('error-messages');
    errorMessages.innerHTML = '';
    if (errors) {
        Object.keys(errors).forEach(function(key) {
            errors[key].forEach(function(message) {
                var errorItem = document.createElement('div');
                errorItem.textContent = message;
                errorMessages.appendChild(errorItem);
            });
        });
    } else {
        // Nếu không có lỗi, tiến hành submit form
        alert("Đổi mật khẩu thành công!");
        // Gửi dữ liệu qua AJAX hoặc form submit tại đây
    }
});
