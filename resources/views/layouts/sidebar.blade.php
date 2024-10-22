@include('layouts.navigation')
<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                @if(Auth::user()->getRoleNames()->first() == 'customer')
                    @include('layouts.customer.sidebar')
                @endif
                <!-- Sidenav partner -->
                @if(Auth::user()->getRoleNames()->first() == 'partner')
                    @include('layouts.partner.sidebar')
                @endif
                <!-- Sidenav Admin-->
                @if(Auth::user()->getRoleNames()->first() == 'admin')
                    @include('layouts.admin.sidebar')
                @endif
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
                @if(Auth::user()->getRoleNames()->first() == 'admin')
                <a class="nav-link" href="{{ route('setting') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">
                            settings
                        </span>
                    </div> Cài đặt
                </a>
                @endif
                <a class="nav-link link-danger" href="{{ route('logout') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">logout</span>
                    </div> <?= __('menu.logout') ?>
                </a>
            </div>
        </div>
    </nav>
</div>