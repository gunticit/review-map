@include('layouts.navigation')
<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Menu</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link {!! request()->routeIs('home') ? 'active' : '' !!}" href="{{ route('home') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">home</span>
                    </div> <?= __('menu.overview') ?>
                </a>
                <!-- Sidenav Link (Alerts)-->
                <a class="nav-link {!! request()->routeIs('notification') ? 'active' : '' !!}" href="{{ route('notification') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">notifications_active</span>
                    </div> <?= __('menu.notifications') ?>
                </a>
                <!-- Sidenav Accordion (Nhiemvu)-->
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
                    </nav>
                </div>
                <!-- Sidenav Accordion (Vicuatoi)-->
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
                <!-- Sidenav Admin-->
                <div class="sidenav-menu-heading">Admin</div>
                <a class="nav-link" href="{{ route('home') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">home</span>
                    </div> <?= __('common.overview') ?>
                </a>
                <a class="nav-link" href="{{ route('support') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">support_agent</span>
                    </div> Quản lý đối tác
                </a>
                <!-- Sidenav Heading (Khac)-->
                <div class="sidenav-menu-heading">Khác</div>
                <a class="nav-link" href="{{ route('support') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">support_agent</span>
                    </div> <?= __('menu.request_support') ?>
                </a>
                <a class="nav-link" href="{{ route('faq') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">quiz</span>
                    </div> FAQ
                </a>
                <a class="nav-link link-danger" href="{{ route('logout') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">logout</span>
                    </div> <?= __('menu.logout') ?>
                </a>
            </div>
        </div>
    </nav>
</div>