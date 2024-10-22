$(document).ready(function () {
    function generateRandomCoupon(length = 10) {
        const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let result = '';
        const charactersLength = characters.length;
    
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
    
        return result;
    }
    $('#codeSelect').on('change', function () {
        if ($(this).val() == 1) {
            $('#codeInput').val(generateRandomCoupon());
            $('#codeInput').attr('readonly', true);
        }else{
            $('#codeInput').val('');
            $('#codeInput').attr('readonly', false);
            $('#codeInput').focus();
        }
    });
});