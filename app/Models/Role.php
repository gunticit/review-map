<?php

namespace App\Models;

use Spatie\Permission\Models\Role as PackageRole;

class Role extends PackageRole
{
    const ADMIN_ROLE = 'admin';
    const CUSTOMER_ROLE = 'customer';
    const GUEST_ROLE = 'guest';
}
