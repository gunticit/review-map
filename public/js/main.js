// main.js
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Xuất các hàm ra ngoài
    window.sendAjax = sendAjax;
    window.showAlert = showAlert;
    window.setupFileInput = setupFileInput;
    window.setCookie = setCookie;
    window.getCookie = getCookie;
    window.checkCookie = checkCookie;

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

    function showAlert(type_icon = "info", msg_text = "No messages", redirect = '') {
        Swal.fire({
            title: 'Thông báo',
            text: msg_text,
            icon: type_icon, // info, warning, error, success
            showCloseButton: true,
            showConfirmButton: true,
            allowOutsideClick: false,
            confirmButtonText: "OK",
        }).then(() => {
            if (redirect) window.location.href=redirect;
        });
    }

    function showHideLoading() {
        $("#loading").fadeToggle(200);
    }
  

    function setupFileInput(inputFileSelector, fileListSelector, fileErrorSelector, maxSizeMB = 2) {
        let selectedFiles = []; // Array to store selected files
    
        // Event handler for when the user selects files
        $(inputFileSelector).on('change', function () {
            $(fileErrorSelector).hide(); // Hide error message if any
    
            var files = this.files; // Get the list of selected files
            var maxSize = maxSizeMB * 1024 * 1024; // File size limit (MB)
    
            // Loop through each selected file
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
    
                // Check if the file is too large
                if (file.size > maxSize) {
                    $(fileErrorSelector).show().text('Tệp quá lớn: ' + file.name); // Show error if file exceeds limit
                    continue; // Skip this file if it's too large
                }
    
                selectedFiles.push(file); // Add the file to the selectedFiles array
    
                // Create HTML element to display file information
                var fileItem = $('<div>')
                    .addClass('file-item')
                    .attr('data-file-index', selectedFiles.length - 1); // Store index of the file
    
                var fileName = $('<span>')
                    .addClass('file-name')
                    .text(file.name); // Display file name
    
                var fileSize = $('<span>')
                    .addClass('file-size')
                    .text((file.size / 1024).toFixed(1) + ' KB'); // Display file size
    
                var fileSuccess = $('<span>')
                    .addClass('material-symbols-outlined file-success')
                    .text('check_circle'); // Success icon (if any)
    
                var fileRemove = $('<span>')
                    .addClass('material-symbols-outlined file-remove')
                    .text('cancel'); // Remove file icon
    
                // Append child elements to the fileItem
                fileItem.append(fileName)
                    .append(fileSize)
                    .append(fileSuccess)
                    .append(fileRemove);
    
                // Append fileItem to the fileList
                $(fileListSelector).append(fileItem);
            }
        });
    
        // Event handler for when the user clicks the remove file button
        $(document).on('click', `${fileListSelector} .file-remove`, function () {
            var fileIndex = $(this).closest('.file-item').attr('data-file-index'); // Get index of the file to remove
    
            selectedFiles.splice(fileIndex, 1); // Remove the file from selectedFiles array
    
            $(this).closest('.file-item').remove(); // Remove the corresponding HTML element
    
            // Update the indices of the remaining files
            $(`${fileListSelector} .file-item`).each(function (index) {
                $(this).attr('data-file-index', index);
            });
        });
    
        // Return a function to get the currently selected files
        return function getSelectedFiles() {
            return selectedFiles; // Return the selected files array
        };
    }

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/" + ";SameSite=None;Secure";
    }
      
    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
    }
    
    function checkCookie(cname) {
        let cookie = getCookie(cname);
        if (cookie != "") {
            showAlert("Cookie đã được cài đặt " + cookie);
        } else {
            showAlert("Cookie chưa được caài đặt");
        }
    }
});
