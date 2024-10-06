(function ($) {
    var fileUploadCount = 0;

    $.fn.fileUpload = function () {
        return this.each(function () {
            var fileUploadDiv = $(this);
            var fileUploadId = `fileUpload-${++fileUploadCount}`;

            // Biến lưu trữ các file đã được chọn
            var selectedFiles = [];

            var fileDivContent = `
                <label for="${fileUploadId}" class="file-upload">
                    <div>
                        <i class="material-symbols-outlined">image</i>
                        <p>Kéo thả hoặc <span class="text-primary">chọn hình ảnh</span> để tải lên</p>
                    </div>
                    <input type="file" accept="image/png, image/gif, image/jpeg" id="${fileUploadId}" name="images[]" multiple hidden />
                </label>
            `;

            fileUploadDiv.html(fileDivContent).addClass("file-container");

            var table = null;
            var tableBody = null;

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
                        </tbody>
                    </table>
                `);

                tableBody = table.find("tbody");
                fileUploadDiv.append(table);
            }

            function handleFiles(files) {
                if (!table) {
                    createTable();
                }

                $.each(files, function (index, file) {
                    if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        selectedFiles.push(file);

                        var fileName = file.name;
                        var fileSize = (file.size / 1024).toFixed(2) + " KB";
                        var fileType = file.type;
                        var preview = fileType.startsWith("image")
                            ? `<img src="${URL.createObjectURL(file)}" alt="${fileName}" height="30">`
                            : `<i class="material-symbols-outlined">visibility_off</i>`;

                        tableBody.append(`
                            <tr>
                                <td class="stt">${selectedFiles.length}</td>
                                <td class="fileName">${fileName}</td>
                                <td class="preview">${preview}</td>
                                <td class="fileSize">${fileSize}</td>
                                <td class="fileType">${fileType}</td>
                                <td class="delete"><button type="button" class="deleteBtn"><i class="material-symbols-outlined">delete</i></button></td>
                            </tr>
                        `);
                    }
                });

                tableBody.find(".deleteBtn").click(function () {
                    var row = $(this).closest("tr");
                    var fileName = row.find(".fileName").text();
                    var fileSize = parseFloat(row.find(".fileSize").text());

                    // Xóa file khỏi danh sách selectedFiles
                    selectedFiles = selectedFiles.filter(f => !(f.name === fileName && (f.size / 1024).toFixed(2) == fileSize));

                    row.remove();

                    // Cập nhật lại STT sau khi xóa
                    tableBody.find("tr").each(function (index) {
                        $(this).find(".stt").text(index + 1);
                    });

                    if (tableBody.find("tr").length === 0) {
                        tableBody.append('<tr style="width: 100% !important"><td colspan="6" class="no-file">Không có file nào được chọn!</td></tr>');
                    }
                });
            }

            fileUploadDiv.on({
                dragover: function (e) {
                    e.preventDefault();
                    fileUploadDiv.toggleClass("dragover", e.type === "dragover");
                },
                drop: function (e) {
                    e.preventDefault();
                    fileUploadDiv.removeClass("dragover");
                    handleFiles(e.originalEvent.dataTransfer.files);
                },
            });

            fileUploadDiv.find(`#${fileUploadId}`).change(function () {
                let package = $('#inputReview').val();
                if(package == 1){
                    limit = 10;
                }else if(package == 2){
                    limit = 50;
                }else if(package == 3){
                    limit = 100;
                }else if(package == 4){
                    limit = 200;
                }
                let lenght = this.files.length;
                if(lenght < limit || lenght > limit){
                    $('#fileUpload').append(`<small class="text-danger">Vui lòng nhập đủ số lượng hình của gói là ${limit} hình</small>`);
                    setTimeout(() => {
                        $('#fileUpload small').remove();
                    }, 5000);
                    return;
                }else{
                    $('#text-danger .text-danger').remove();
                }
                if(package && this.files){
                    handleFiles(this.files);
                }
            });
        });
    };
})(jQuery);