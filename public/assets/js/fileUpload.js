(function ($) {
    var fileUploadCount = 0;

    $.fn.fileUpload = function (options) {
        var settings = $.extend({
            maxFileCount: Infinity
        }, options);

        return this.each(function () {
            var fileUploadDiv = $(this);
            var fileUploadId = `fileUpload-${++fileUploadCount}`;
            var selectedFiles = []; // Mảng lưu trữ các file đã được chọn

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
                        <tbody></tbody>
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

                // Kiểm tra tổng số tệp đã tải lên
                var currentFileCount = tableBody.children().length;

                // Lấy số lượng tệp tối đa cho phép từ options
                var maxFileCount = settings.maxFileCount();

                // Nếu số lượng tệp hiện tại cộng với số tệp mới vượt quá giới hạn
                if (currentFileCount + files.length > maxFileCount) {
                    // Cập nhật nội dung modal
                    $('#modalMessage').text(`Số lượng ảnh không vượt quá ${maxFileCount}! Các tệp đã chọn sẽ được làm mới.`);
                    $('#modalAlert').modal('show');

                    // Reset lại tất cả các tệp
                    tableBody.empty();
                    selectedFiles = []; // Xóa mảng lưu trữ các tệp đã chọn

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
                                <td class="stt">${tableBody.children().length + 1}</td>
                                <td class="fileName">${fileName}</td>
                                <td class="preview">${preview}</td>
                                <td class="fileSize">${fileSize}</td>
                                <td class="fileType">${fileType}</td>
                                <td class="delete"><button type="button" class="deleteBtn"><i class="material-symbols-outlined">delete</i></button></td>
                            </tr>
                        `);

                        selectedFiles.push(file); // Thêm file vào danh sách
                    }
                });

                // Tái khởi tạo các sự kiện nút xóa sau khi thêm tệp mới
                tableBody.find(".deleteBtn").off('click').on('click', function () {
                    var row = $(this).closest("tr");
                    var fileName = row.find(".fileName").text();

                    // Xóa tệp khỏi danh sách
                    selectedFiles = selectedFiles.filter(file => file.name !== fileName);

                    row.remove();

                    if (tableBody.find("tr").length === 0) {
                        tableBody.append('<tr><td colspan="6" class="no-file">No files selected!</td></tr>');
                    }
                });
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

            // Xử lý khi nhấn nút gửi
            $('#btn-submit').on('click', function () {
                var maxFileCount = settings.maxFileCount();
                var currentFileCount = selectedFiles.length;

                // Khi người dùng chưa chọn tệp
                if (currentFileCount === 0) {
                    $('#modalMessage').text('Bạn chưa chọn tệp nào!');  // Cập nhật nội dung modal
                    $('#modalAlert').modal('show');
                    return;
                } else if (currentFileCount < maxFileCount) {
                    $('#modalMessage').text(`Bạn cần tải lên đủ ${maxFileCount} tệp! Hiện tại bạn đã tải lên ${currentFileCount} tệp.`);
                    $('#modalAlert').modal('show');
                    return;
                }

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
