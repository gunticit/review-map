<!-- Popup Chọn phương thức nhận OTP (chỉ sử dụng Email) -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-register">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="regForm">
                    <!-- Bước 1: Nhập email để nhận OTP -->
                    <div class="tab">
                        <h2>Xác thực danh tính</h2>
                        <p>Vui lòng chọn phương thức nhận liên kết thay đổi mật khẩu.</p>
                        <div class="mb-3">
                            <form id="emailForm" action="{{ route('send.otp') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" required />
                            </form>
                        </div>
                        <a href="javascript:void(0);" class="btn-link fw-700 text-decoration-underline mb-3 d-inline-block" data-bs-dismiss="modal" aria-label="Close">Trở về trang đăng nhập</a>
                    </div>
                
                    <!-- Bước 2: Nhập mã OTP -->
                    <div class="tab">
                        <h2>Nhập mã xác thực</h2>
                        <form id="otpForm" action="{{ route('verify.otp') }}" method="POST">
                            {{ csrf_field() }}
                            <p id="otpMessage"></p>
                            <input type="hidden" class="form-control" id="emailOtp" name="email" placeholder="Email" value="" required />
                            <input type="hidden" class="form-control" id="otpAttempts" name="otp_attempts" value="0"/>    
                            <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
                            <div class="d-flex form-check-number">
                                <div class="p-2">
                                    <input type="number" class="form-control" name="otp[]" id="otp1"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                </div>
                                <div class="p-2">
                                    <input type="number" class="form-control" name="otp[]" id="otp2"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                </div>
                                <div class="p-2">
                                    <input type="number" class="form-control" name="otp[]" id="otp3"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                </div>
                                <div class="p-2">
                                    <input type="number" class="form-control" name="otp[]" id="otp4"  required maxlength="1" min="0" max="9" oninput="limitInputLength(this)" />
                                </div>
                            </div>
                        </form>
                    </div>
                
                    <!-- Bước 3: Đổi mật khẩu mới -->
                    <div class="tab">
                        <h2>Tạo mật khẩu mới</h2>
                        
                        <form id="passwordForm" action="{{ route('password.update') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="emailResetPass" name="email" placeholder="Email" value="" required />
                            <div class="error-message text-danger small d-none" style="font-style: italic;"></div>
                            <div class="input-group mb-3 input-group-password">
                                <span class="input-group-text"><span class="material-symbols-outlined">lock</span></span>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu mới" required />
                            </div>
                            <div class="input-group mb-3 input-group-password">
                                <span class="input-group-text"><span class="material-symbols-outlined">lock</span></span>
                                <input type="password" class="form-control" name="confirmPassword" placeholder="Xác nhận mật khẩu" required />
                            </div>
                        </form>
                    </div>
                
                    <!-- Bước 4: Thành công -->
                    <div class="tab">
                        <h2>Thành công!</h2>
                        <p>Chúc mừng! Bạn đã thay đổi mật khẩu thành công.</p>
                    </div>
                
                    <div class="text-center">
                        <button id="nextBtn" type="submit" class="btn btn-primary">
                            <!-- Loading Message -->
                            <div id="loadingMessage" style="display:none;" class="text-center">
                                <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <span id="buttonText">Tiếp tục</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>