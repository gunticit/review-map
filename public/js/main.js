$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    /* Send AJAX request */
    function sendAjax(params, callback) {
        $.ajax({
            type: params.method || "POST",
            url: params.url,
            data: params.data || {},
            dataType: "json",
            beforeSend: showHideLoading,
            complete: showHideLoading,
            success: function (response) {
                callback(response);
            },
            error: function () {
                showAlert("error", "An error occurred");
            },
        });
    }

    /* Generic alert function */
    function showAlert(type_icon = "info", msg_text = "No messages", reload = true) {
        Swal.fire({
            title: msg_text,
            icon: type_icon, // info, warning, error, success
            showCloseButton: true,
            showConfirmButton: true,
            allowOutsideClick: false,
            confirmButtonText: "OK",
        }).then(() => {
            if (reload) window.location.reload();
        });
    }

    function showHideLoading() {
        $("#loading").fadeToggle(200);
    }
  
});

function generateCoupon(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let coupon = '';
    
    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        coupon += characters[randomIndex];
    }
    
    return coupon;
}  

$(document).ready(function(){
    $('#codeSelect').on('change', function () {
        if($(this).val() == 1){
            let code = generateCoupon(10);
            $('#codeInput').val(code);
            $('#codeInput').attr('readonly', 'readonly');
            $('#codeInput').attr('disabled', 'disabled');
        }else{
            $('#codeInput').val('');
            $('#codeInput').removeAttr('readonly');
            $('#codeInput').removeAttr('disabled');
        }
    })
});
