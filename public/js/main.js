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
