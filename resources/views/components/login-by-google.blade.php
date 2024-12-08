<!-- resources/views/components/confirm-modal.blade.php -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Xác nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="confirmModalBody" class="modal-body">
                {{ $message ?? 'Bạn có chắc chắn muốn đăng nhập bằng Google không?' }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="{{ route('auth.google') }}" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var url = window.location.href;
        var role = url.split('.')[0].split('//')[1];
        
        var roleMap = {
            doitac: 'Đối tác',
            khachhang: 'Khách hàng',
            quantri: 'Quản trị'
        };
            if (role && roleMap[role]) {
            var newMessage = 'Bạn có chắc chắn muốn đăng nhập bằng Google với vai trò ' + roleMap[role] + ' không?';
            document.getElementById('confirmModalBody').textContent = newMessage;
        }
    });
    $('#otp1').on('paste', function(e) {
        var pasteData = e.originalEvent.clipboardData.getData('text');
        pasteData = pasteData.substring(0, 4);
        var otpInputs = $('#otp1, #otp2, #otp3, #otp4');
        otpInputs.each(function(index) {
            $(this).val(pasteData[index] || '');
        });
        e.preventDefault();
    });

    $('#otp1, #otp2, #otp3, #otp4').on('paste', function(e) {
        var pasteData = e.originalEvent.clipboardData.getData('text');
        var char = pasteData.substring(0, 1);
        $(this).val(char);
        e.preventDefault();
    });
</script>