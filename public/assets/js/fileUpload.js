(function ($) {
    var fileUploadCount = 0;

    $.fn.fileUpload = function (options) {
        var settings = $.extend({
            // Mặc định không có giới hạn
            maxFileCount: Infinity 
        }, options);

        return this.each(function () {
            var fileUploadDiv = $(this);
            var fileUploadId = `fileUpload-${++fileUploadCount}`;

            // Tạo nội dung HTML cho khu vực tải lên tệp
            var fileDivContent = `
                <label for="${fileUploadId}" class="file-upload">
                    <div>
                        <i class="material-symbols-outlined">image</i>
                        <p>Kéo thả hoặc <span class="text-primary">chọn hình ảnh</span> để tải lên</p>
                    </div>
                    <input type="file" accept="image/png, image/gif, image/jpeg" id="${fileUploadId}" name="files[]" multiple hidden />
                </label>
            `;

            fileUploadDiv.html(fileDivContent).addClass("file-container");

            var table = null;
            var tableBody = null;

            // Tạo bảng chứa thông tin các tệp tin đã tải lên
            function createTable() {
                table = $(`
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 30%;">File Name</th>
                                <th>Preview</th>
                                <th style="width: 20%;">Size</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="no-file"><td colspan="6">No files selected!</td></tr>
                        </tbody>
                    </table>
                `);

                tableBody = table.find("tbody");
                fileUploadDiv.append(table);
            }

            // Thêm thông tin của các tệp đã tải lên vào bảng
            function handleFiles(files) {
                if (!table) {
                    createTable();
                }

                // Remove "No files selected!" message if present
                tableBody.find('.no-file').remove();

                // Lấy số lượng tệp tối đa cho phép từ dropdown
                var maxFileCount = settings.maxFileCount();

                // Check if maxFileCount is not set or is zero
                if (!maxFileCount || maxFileCount === 0) {
                    var message = "Bạn cần phải chọn gói review. Số lượng ảnh phù hợp gói số lượng gói đánh giá.";
                    $('#modalMessage').text(message);
                    $('#modalAlert').modal('show');
                    return; // Dừng lại nếu maxFileCount không có hoặc bằng 0
                }

                // Kiểm tra tổng số tệp đã tải lên
                var currentFileCount = tableBody.children('tr').not('.no-file').length;

                // Nếu số lượng tệp hiện tại cộng với số tệp mới vượt quá giới hạn
                if (currentFileCount + files.length > maxFileCount) {
                    var message = `Số lượng ảnh không vượt quá ${maxFileCount}% số lượng gói đánh giá. Định dạng ảnh là (*.jpeg, *.png). Giá của 1 tấm ảnh là 5k/tấm.`;
                    $('#modalMessage').text(message);
                    $('#modalAlert').modal('show');
                    return; // Dừng lại nếu vượt quá giới hạn
                }

                $.each(files, function (index, file) {
                    var fileName = file.name;
                    var fileSize = (file.size / 1024).toFixed(2) + " KB";
                    var fileType = file.type;
                    var preview = fileType.startsWith("image")
                        ? `<img src="${URL.createObjectURL(file)}" alt="${fileName}" height="30">`
                        : `<i class="material-symbols-outlined">visibility_off</i>`;

                    // Kiểm tra xem tệp đã tồn tại trong bảng chưa
                    var fileExists = tableBody.find(`.fileName:contains("${fileName}")`).length > 0;

                    // Chỉ thêm tệp nếu chưa tồn tại
                    if (!fileExists) {
                        tableBody.append(`
                            <tr>
                                <td class="stt">${tableBody.children('tr').not('.no-file').length + 1}</td>
                                <td class="fileName">${fileName}</td>
                                <td class="preview">${preview}</td>
                                <td class="fileSize">${fileSize}</td>
                                <td class="fileType">${fileType}</td>
                                <td class="delete"><button type="button" class="deleteBtn"><i class="material-symbols-outlined">delete</i></button></td>
                            </tr>
                        `);
                    }
                });

                // Clear the file input value to allow re-selection of the same file
                fileUploadDiv.find(`#${fileUploadId}`).val('');

                // Tái khởi tạo các sự kiện nút xóa sau khi thêm tệp mới
                tableBody.find(".deleteBtn").off('click').on('click', function () {
                    $(this).closest("tr").remove();

                    if (tableBody.find("tr").not('.no-file').length === 0) {
                        tableBody.append('<tr class="no-file"><td colspan="6">No files selected!</td></tr>');
                    }
                });

                // Check if the number of uploaded files is less than the maxFileCount
                if (tableBody.children('tr').not('.no-file').length < maxFileCount) {
                    $('#modalMessage').text(message);
                }
            }
            
            // Sự kiện khi kéo thả tệp
            fileUploadDiv.on({
                dragover: function (e) {
                    e.preventDefault();
                    fileUploadDiv.toggleClass("dragover", e.type === "dragover");
                },
                drop: function (e) {
                    e.preventDefault();
                    fileUploadDiv.removeClass("dragover");
                    // Thao tác khi thả tệp
                    handleFiles(e.originalEvent.dataTransfer.files);
                },
            });

            // Sự kiện khi tệp được chọn
            fileUploadDiv.find(`#${fileUploadId}`).change(function () {
                handleFiles(this.files);
            });
        });
    };
})(jQuery);

// Modal HTML
$('body').append(`
    <div class="modal fade" tabindex="-1" id="modalAlert">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-4 pb-1">
                    <h5 class="modal-title text-center">Cảnh báo</h5>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-0"><small class="color-grey" id="modalMessage"></small></p>
                </div>
                <div class="modal-footer mb-4">
                    <button type="button" class="btn btn-primary fw-500" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
`);