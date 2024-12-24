<div class="sidenav-menu-heading">Menu</div>
<a class="nav-link {!! request()->routeIs('home') ? 'active' : '' !!}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseHome" aria-expanded="false" aria-controls="collapseHome">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">home</span>
    </div> <?= __('common.overview') ?> <div class="sidenav-collapse-arrow">
        <span class="material-symbols-outlined">chevron_right</span>
    </div>
</a>
<div class="collapse {!! request()->routeIs('home') || request()->routeIs('overview.customer') || request()->routeIs('overview.partner') ? 'show' : '' !!}" id="collapseHome" data-bs-parent="#accordionHome">
    <nav class="sidenav-menu-nested nav accordion" id="accordionHomeChild">
        <a class="nav-link {!! request()->routeIs('overview.customer') ? 'active' : '' !!}" href="{{ route('overview.customer') }}"><?= __('menu.home_customer') ?></a>
        <a class="nav-link {!! request()->routeIs('overview.partner') ? 'active' : '' !!}" href="{{ route('overview.partner') }}"><?= __('menu.home_partner') ?></a>
    </nav>
</div>
<a class="nav-link {!! request()->routeIs('statistics.index') ? 'active' : '' !!}" href="{{ route('statistics.index') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            monitoring
        </span>
    </div> Thống kê
</a>
<a class="nav-link {!! request()->routeIs('home') ? 'active' : '' !!}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseNotification" aria-expanded="false" aria-controls="collapseNotification">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">home</span>
    </div> Quản lý thông báo <div class="sidenav-collapse-arrow">
        <span class="material-symbols-outlined">chevron_right</span>
    </div>
</a>
<div class="collapse {!! request()->routeIs('home') || request()->routeIs('list.notificate.partner') || request()->routeIs('create.notificate.partner') || request()->routeIs('create.notificate.customer') || request()->routeIs('list.notificate.customer') ? 'show' : '' !!}" id="collapseNotification" data-bs-parent="#accordionNotification">
    <nav class="sidenav-menu-nested nav accordion" id="accordionNotificationChild">
        <a class="nav-link {!! request()->routeIs('list.notificate.customer') || request()->routeIs('create.notificate.customer') ? 'active' : '' !!}" href="{{ route('list.notificate.customer') }}">Thông báo khách hàng</a>
        <a class="nav-link {!! request()->routeIs('list.notificate.partner') || request()->routeIs('create.notificate.partner') ? 'active' : '' !!}" href="{{ route('list.notificate.partner') }}">Thông báo đối tác</a>
    </nav>
</div>
<a class="nav-link {!! request()->routeIs('manage-customer.index') ? 'active' : '' !!}" href="{{ route('manage-customer.index') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            group
        </span>
    </div> Quản lý khách hàng
</a>
<a class="nav-link {!! request()->routeIs('project.list') ? 'active' : '' !!}" href="{{ route('project.list') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            description
        </span>
    </div> Quản lý dự án
</a>
<a class="nav-link {!! request()->routeIs('approve.project') ? 'active' : '' !!}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#accordionApprove" aria-expanded="false" aria-controls="accordionApprove">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">fact_check</span>
    </div> Kiểm duyệt <div class="sidenav-collapse-arrow">
        <span class="material-symbols-outlined">chevron_right</span>
    </div>
</a>
<div class="collapse {!! request()->routeIs('approve.project') || request()->routeIs('approve.withdraw') ? 'show' : '' !!}" id="accordionApprove" data-bs-parent="#accordionApprove">
    <nav class="sidenav-menu-nested nav accordion" id="accordionApproveChild">
        <a class="nav-link {!! request()->routeIs('approve.project') || request()->routeIs('approve.project') ? 'active' : '' !!}" href="{{ route('approve.project') }}">Duyệt nhiệm vụ</a>
        <a class="nav-link {!! request()->routeIs('approve.withdraw') || request()->routeIs('approve.withdraw') ? 'active' : '' !!}" href="{{ route('approve.withdraw') }}">Duyệt rút tiền</a>
    </nav>
</div>

<a class="nav-link {!! request()->routeIs('admin.manage.partner.list') || request()->routeIs('admin.manage.partner.info') || request()->routeIs('admin.manage.partner.wallet') || request()->routeIs('admin.manage.partner.project') || request()->routeIs('admin.manage.partner.edit') ? 'active' : '' !!}" href="{{ route('admin.manage.partner.list') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            group
        </span>
    </div> Quản lý đối tác
</a>
<div class="collapse show" id="collapseGuarantee" data-bs-parent="#accordionGuarantee">
    <nav class="sidenav-menu-nested nav accordion" id="accordionGuaranteeChild">
        <a class="nav-link {!! request()->routeIs('overview.customer') ? 'active' : '' !!}" href="{{ route('overview.customer') }}">Quản lý bảo hành</a>
    </nav>
</div>
<a class="nav-link {!! request()->routeIs('order') ? 'active' : '' !!}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">list_alt</span>
    </div> Quản lý cửa hàng <div class="sidenav-collapse-arrow">
        <span class="material-symbols-outlined">chevron_right</span>
    </div>
</a>
<div class="collapse {!! request()->routeIs('category.index') || request()->routeIs('category.create') || request()->routeIs('product.index') || request()->routeIs('product.create') || request()->routeIs('order.index') || request()->routeIs('order.create') ? 'show' : '' !!}" id="collapseProduct" data-bs-parent="#accordionProduct">
    <nav class="sidenav-menu-nested nav accordion" id="accordionProductChild">
        <a class="nav-link {!! request()->routeIs('category.index') || request()->routeIs('category.create') ? 'active' : '' !!}" href="{{ route('category.index') }}">Danh mục sản phẩm</a>
        <a class="nav-link {!! request()->routeIs('product.index') || request()->routeIs('product.create') ? 'active' : '' !!}" href="{{ route('product.index') }}">Sản phẩm</a>
        <a class="nav-link {!! request()->routeIs('order.index') || request()->routeIs('order.create') ? 'active' : '' !!}" href="{{ route('order.index') }}">Quản lý đơn đặt hàng</a>
    </nav>
</div>
<a class="nav-link {!! request()->routeIs('voucher.index') || request()->routeIs('voucher.create') ? 'active' : '' !!}" href="{{ route('voucher.index') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            barcode_scanner
        </span>
    </div> Quản lý mã giảm giá
</a>