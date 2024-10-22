<?php

namespace App\Models;

use Spatie\Permission\Models\Role as PackageRole;

class Role extends PackageRole
{
    // Admin: Người quyền hạn cao nhất
    // Customer: Khách hàng trả tiền cho dự án
    // Partner: Người thực hiên các nhiệm vụ
    const ADMIN_ROLE = 'admin';
    const CUSTOMER_ROLE = 'customer';
    const PARTNER_ROLE = 'partner';
}
