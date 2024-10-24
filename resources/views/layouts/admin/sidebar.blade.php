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
<a class="nav-link" href="{{ route('statistics.index') }}">
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
<div class="collapse {!! request()->routeIs('home') || request()->routeIs('list.notificate.partner') || request()->routeIs('list.notificate.customer') ? 'show' : '' !!}" id="collapseNotification" data-bs-parent="#accordionNotification">
    <nav class="sidenav-menu-nested nav accordion" id="accordionNotificationChild">
        <a class="nav-link {!! request()->routeIs('list.notificate.customer') ? 'active' : '' !!}" href="{{ route('list.notificate.customer') }}">Thông báo khách hàng</a>
        <a class="nav-link {!! request()->routeIs('list.notificate.partner') ? 'active' : '' !!}" href="{{ route('list.notificate.partner') }}">Thông báo đối tác</a>
    </nav>
</div>
<a class="nav-link" href="{{ route('manage-customer.index') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            group
        </span>
    </div> Quản lý khách hàng
</a>
<a class="nav-link" href="{{ route('project.list') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            description
        </span>
    </div> Quản lý dự án
</a>
<a class="nav-link" href="{{ route('approve.project') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            fact_check
        </span>
    </div> <span>Kiểm duyệt</span> 
    {{-- <span class="badge bg-danger rounded-pill ms-2">2</span> --}}
</a>
<a class="nav-link {!! request()->routeIs('admin.manage.partner.info') ? 'active' : '' !!}" href="{{ route('admin.manage.partner.info') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            group
        </span>
    </div> Quản lý đối tác
</a>
<a class="nav-link {!! request()->routeIs('order') ? 'active' : '' !!}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#" aria-expanded="false" aria-controls="collapseOrder">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">list_alt</span>
    </div> Quản lý đơn hàng <div class="sidenav-collapse-arrow">
        <span class="material-symbols-outlined">chevron_right</span>
    </div>
</a>
<div class="collapse {!! request()->routeIs('home') || request()->routeIs('overview.customer') || request()->routeIs('overview.partner') ? 'show' : '' !!}" id="collapseOrder" data-bs-parent="#accordionOrder">
    <nav class="sidenav-menu-nested nav accordion" id="accordionHomeChild">
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
<div class="collapse {!! request()->routeIs('category.index') || request()->routeIs('product.index') || request()->routeIs('order.index') ? 'show' : '' !!}" id="collapseProduct" data-bs-parent="#accordionProduct">
    <nav class="sidenav-menu-nested nav accordion" id="accordionProductChild">
        <a class="nav-link {!! request()->routeIs('category.index') ? 'active' : '' !!}" href="{{ route('category.index') }}">Danh mục sản phẩm</a>
        <a class="nav-link {!! request()->routeIs('product.index') ? 'active' : '' !!}" href="{{ route('product.index') }}">Danh sách sản phẩm</a>
        <a class="nav-link {!! request()->routeIs('order.index') ? 'active' : '' !!}" href="{{ route('order.index') }}">Quản lý đơn đặt hàng</a>
    </nav>
</div>
<a class="nav-link" href="{{ route('voucher.index') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            barcode_scanner
        </span>
    </div> Quản lý mã giảm giá
</a>