// register.js
export const RegisterForm = {
    init: function() {
        this.cacheElements();
        this.bindEvents();
    },

    cacheElements: function() {
        this.$btnRegister = $('#btn-register');
        this.$checkPolicy = $('#check-policy');
        this.$registerForm = $('#registerForm');
        this.$groupPolicy = $('.group-policy');
        this.$fullname = $('#ip-fullname');
        this.$telephone = $('#ip-telephone');
        this.$email = $('#ip-email');
        this.$password = $('#ip-password');
        this.$confirmPassword = $('#ip-password-confirm');
    },

    bindEvents: function() {
        this.$btnRegister.on('click', this.handleRegisterClick.bind(this));
        this.$fullname.on('input', this.handleChangeInput.bind(this));
        this.$telephone.on('input', this.handleChangeInput.bind(this));
        this.$email.on('input', this.handleChangeInput.bind(this));
        this.$password.on('input', this.handleChangeInput.bind(this));
        this.$confirmPassword.on('input', this.handleChangeInput.bind(this));
    },

    handleRegisterClick: function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.$groupPolicy.find('.text-danger').remove();

        try {
            let checkValidate = this.validateRegister();
            if (checkValidate) {
                if (this.$checkPolicy.prop('checked')) {
                    // Nộp form nếu đã có dữ liệu hợp lệ
                    this.$registerForm.submit();
                } else {
                    this.$groupPolicy.append('<p class="text-danger m-0">Vui lòng nhấn đọc, hiểu, đồng ý tất cả điều khoản và chính sách của chúng tôi</p>');
                }
            }
        } catch (error) {
            console.error("Đã xảy ra lỗi khi kiểm tra checkbox chính sách:", error);
        }
    },

    handleChangeInput: function(e) {
        // Khi người dùng thay đổi giá trị trong trường, kiểm tra lại và xóa lỗi nếu có
        let $target = $(e.target);
        this.removeError($target);  // Gọi hàm removeError cho trường vừa thay đổi
    },

    validateRegister: function() {
        let fullname = this.$fullname.val();
        let telephone = this.$telephone.val();
        let email = this.$email.val();
        let password = this.$password.val();
        let confirmPassword = this.$confirmPassword.val();
        let hasError = false;

        this.removeError();  // Xóa tất cả lỗi trước khi kiểm tra lại

        if (!fullname) {
            this.showError(this.$fullname, 'Họ và tên là bắt buộc');
            hasError = true;
        }
        if (!telephone) {
            this.showError(this.$telephone, 'Số điện thoại là bắt buộc');
            hasError = true;
        }
        if (!email) {
            this.showError(this.$email, 'Email là bắt buộc');
            hasError = true;
        }
        if (!password) {
            this.showError(this.$password, 'Mật khẩu là bắt buộc');
            hasError = true;
        }
        if (!confirmPassword) {
            this.showError(this.$confirmPassword, 'Mật khẩu xác nhận là bắt buộc');
            hasError = true;
        } else if (password && confirmPassword && password !== confirmPassword) {
            this.showError(this.$confirmPassword, 'Mật khẩu không trùng khớp');
            hasError = true;
        }

        return !hasError;
    },

    removeError: function($element) {
        // Nếu có tham số $element, chỉ xóa lỗi trong trường đó
        console.log($element);
        if ($element) {
            $element.parent().find('.text-danger').remove();
        } else {
            // Nếu không có tham số, xóa lỗi của tất cả các trường
            this.$fullname.parent().find('.text-danger').remove();
            this.$telephone.parent().find('.text-danger').remove();
            this.$email.parent().find('.text-danger').remove();
            this.$password.parent().find('.text-danger').remove();
            this.$confirmPassword.parent().find('.text-danger').remove();
        }
    },

    showError: function($element, message) {
        // Hiển thị thông báo lỗi cho trường
        $element.parent().append(`<p class="text-danger text-start">${message}</p>`);
    }
};
