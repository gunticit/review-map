<div class="sidenav-menu-heading">Menu</div>
<a class="nav-link {!! request()->routeIs('partner.overview') ? 'active' : '' !!}" href="{{ route('partner.overview') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            home
        </span>
    </div> Tổng quan
</a>
<a class="nav-link {!! request()->routeIs('mission.index') ? 'active' : '' !!}" href="{{ route('mission.index') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            other_admission
        </span>
    </div> Nhiệm vụ
</a>
<a class="nav-link {!! request()->routeIs('wallet.withdraw') ? 'active' : '' !!}" href="{{ route('wallet.withdraw') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            account_balance_wallet
        </span>
    </div> Ví của tôi
</a>
<a class="nav-link {!! request()->routeIs('store.product') ? 'active' : '' !!}" href="{{ route('store.product') }}">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">
            storefront
        </span>
    </div> Cửa hàng
</a