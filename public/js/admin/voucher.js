$(document).ready(function () {
    const form = $("#form-create-voucher");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(form);
        let callback = function (resp) {
            if (data.status) {
                showAlertSuccess("Voucher created successfully!");
                window.location.href = "/admin/voucher";
            } else {
                showAlert("error", "An error occurred: " + data.message);
            }
        };
        sendAjax(
            { method: "POST", url: form.action, data: formData },
            callback
        );
    });
});
