@include('layouts.navigation')
<div id="layoutSidenav_nav" class="d-none">
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
                @php
                    $roleSupport = Auth::user()->getRoleNames()->first() . '.support';
                @endphp
                <!-- Sidenav Heading (Khac)-->
                <div class="sidenav-menu-heading">Khác</div>
                <a class="nav-link {!! request()->routeIs($roleSupport) || request()->routeIs('customer.support.create') ? 'active' : '' !!}" href="{{ route($roleSupport) }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">support_agent</span>
                    </div> <?= __('menu.request_support') ?>
                </a>
                @if(Auth::user()->getRoleNames()->first() != 'admin')
                    <a class="nav-link {!! request()->routeIs('faq') ? 'active' : '' !!}" href="{{ route('faq') }}">
                        <div class="nav-link-icon">
                            <span class="material-symbols-outlined">quiz</span>
                        </div> FAQ
                    </a>
                @else
                    <a class="nav-link {!! request()->routeIs('admin-faq.index') ? 'active' : '' !!}" href="{{ route('admin-faq.index') }}">
                        <div class="nav-link-icon">
                            <span class="material-symbols-outlined">quiz</span>
                        </div> FAQ
                    </a>
                @endif
                @if(Auth::user()->getRoleNames()->first() == 'admin')
                <a class="nav-link {!! request()->routeIs('setting') ? 'active' : '' !!}" href="{{ route('setting') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">
                            settings
                        </span>
                    </div> Cài đặt
                </a>
                @endif
                <a class="nav-link link-danger {{ request()->routeIs('logout') ? 'active' : '' }}" href="{{ route('logout') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">logout</span>
                    </div> <?= __('menu.logout') ?>
                </a>
            </div>
        </div>
    </nav>
</div>
<div id="sideNav_skeleton" class="skeleton">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
                <!-- Sidenav Heading (Khac)-->
                <div class="sidenav-menu-heading">Khác</div>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
                <a class="nav-link" href="#"></a>
            </div>
        </div>
    </nav>
</div>
<script>
    $(window).on('load', function() {
        $('#layoutSidenav_nav, #sidebarToggle').removeClass('d-none');
        $('#sideNav_skeleton').remove();
        $('.skeleton').removeClass('skeleton');
    })
</script>