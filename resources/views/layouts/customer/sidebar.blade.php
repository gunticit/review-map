<div class="sidenav-menu-heading">Menu</div>
<a class="nav-link {!! request()->routeIs('customer.overview') ? 'active' : '' !!}" href="{{ route('customer.overview') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">home</span>
    </div> <?= __('menu.overview') ?>
</a>
<a class="nav-link {!! request()->routeIs('notification') ? 'active' : '' !!}" href="{{ route('notification') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">notifications_active</span>
    </div> <?= __('menu.notifications') ?>
</a>
<a class="nav-link {!! request()->routeIs('project.create') || request()->routeIs('project.list') ? 'active' : '' !!}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseNhiemvu" aria-expanded="false" aria-controls="collapseNhiemvu">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">assignment</span>
    </div> <?= __('menu.project') ?> <div class="sidenav-collapse-arrow">
        <span class="material-symbols-outlined">chevron_right</span>
    </div>
</a>
<div class="collapse {!! request()->routeIs('project.create') || request()->routeIs('project.list') ? 'show' : '' !!}" id="collapseNhiemvu" data-bs-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavNhiemvuMenu">
        <a class="nav-link {!! request()->routeIs('project.create') ? 'active' : '' !!}" href="{{ route('project.create') }}"><?= __('menu.create_project') ?></a>
        <a class="nav-link {!! request()->routeIs('project.list') ? 'active' : '' !!}" href="{{ route('project.list') }}"><?= __('menu.list_project') ?></a>
        <a class="nav-link" href="{{ route('partner.support') }}/">
            <div class="nav-link-icon">
                Yêu cầu bảo hành
            </div>
        </a>
    </nav>
</div>
<a class="nav-link {!! request()->routeIs('wallet') ? 'active' : '' !!}" href="{{ route('wallet') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">account_balance_wallet</span>
    </div> <?= __('menu.wallet') ?>
</a>

<a class="nav-link {!! request()->routeIs('history') ? 'active' : '' !!}" href="{{ route('history') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">history</span>
    </div> <?= __('menu.activity_history') ?>
</a>