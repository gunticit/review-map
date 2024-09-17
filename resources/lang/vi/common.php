<?php
    // Thông báo thực hiện thao tác (list, store, show, update, delete) thành công
    $action_success =  array(
        'list' => 'Hiển thị danh sách thành công',
        'store' => "Thêm dữ liệu thành công",
        'detail' => "Hiển thị dữ liệu thành công",
        'update' => "Cập nhật dữ liệu thành công",
        'delete' => "Xóa dữ liệu thành công",
    );

    // Thông báo thực hiện thao tác (list, store, show, update, delete) không thành công
    $action_error =  array(
        'list' => 'Hiển thị danh sách không thành công',
        'store' => "Thêm dữ liệu không thành công",
        'detail' => "Hiển thị dữ liệu không thành công",
        'update' => "Cập nhật dữ liệu không thành công",
        'delete' => "Xóa dữ liệu không thành công",
    );

    // Thông báo chung theo mã code
    $response_code = array(
        '200' => "Thực hiện thao tác thành công",
        '500' => "Thực hiện thao tác không thành công",
        '400' => "Bad request",
        '403' => "Không có quyền thực hiện thao tác",
        '404' => "Model not found",
        '405' => "Method not allowed",
        '432' => "Có lỗi xảy ra khi Upload File"
    );

    // Thông báo về token
    $token_error = array(
        'expire' => "Đã hết phiên đăng nhập",
    );

    // Thông báo về về tài khoản
    $account_error = array(
        'inactive' => "Tài khoản chưa được kích hoạt",
    );

    // Label form
    $labels = array(
        'title' => 'Tiêu đề',
        'department' => 'Phòng ban',
        'project' => 'Dự án',
        'content' => 'Nội dung',
        'attachment' => 'Tệp đính kèm'
    );

    $status_notification = [
        'read' => 'Đã đọc',
        'unread' => 'Chưa đọc'
    ];


    return array(
        'action_success' => $action_success,
        'action_error' => $action_error,
        'response_code'  => $response_code,
        'token_error'  => $token_error,
        'account_error'  => $account_error,
        'status_notification' => $status_notification,
        'overview' => 'Tổng quan',
        'total_customer' => 'Tổng số khách hàng',
        'doing' => 'Đang thực hiện',
    );