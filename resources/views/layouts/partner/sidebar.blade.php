<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Menu</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link {!! request()->routeIs('partner.overview') ? 'active' : '' !!}" href="{{ route('partner.overview') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">home</span>
                    </div> Tổng quan
                </a>
                <!-- Sidenav Link (Alerts)-->
                <a class="nav-link {!! request()->routeIs('notification') ? 'active' : '' !!}" href="{{ route('notification') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">notifications_active</span>
                    </div> Thông báo
                </a>

                <!-- Sidenav Accordion (Nhiemvu)-->
                <a class="nav-link {!! request()->routeIs('mission.index') || request()->routeIs('mission.histories') ? 'active' : '' !!}" href="{{ route('mission.index') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">assignment</span>
                    </div> Nhiệm vụ
                </a>
                <!-- Sidenav Accordion (Nhiemvu)-->
                <div class="collapse show" id="collapseNhiemvu" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavNhiemvuMenu">
                        <a class="nav-link {!! request()->routeIs('mission.index') ? 'active' : '' !!}" href="#" id="btn-get-mission" data-bs-target="#nhanNhiemVuModal">Nhận nhiệm vụ</a>
                        <a class="nav-link {!! request()->routeIs('mission.histories') ? 'active' : '' !!}" href="{{ route('mission.histories') }}">Lịch sử nhiệm vụ</a>
                    </nav>
                </div>


                <!-- Sidenav Accordion (Vicuatoi)-->
                <a class="nav-link " href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseVicuatoi" aria-expanded="false" aria-controls="collapseVicuatoi">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div> Ví của tôi 
                    <div class="sidenav-collapse-arrow">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </a>
                <div class="collapse " id="collapseVicuatoi" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavVicuatoiMenu">
                        <a class="nav-link {!! request()->routeIs('wallet.withdraw') ? 'active' : '' !!}" href="{{ route('wallet.withdraw') }}">Rút tiền</a>
                        <a class="nav-link" href="6.1.lich-su-so-du.php">Lịch sử số dư</a>
                    </nav>
                </div>
                
                <a class="nav-link" href="{{ route('history') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">history</span>
                    </div> Lịch sử hoạt động
                </a>

                <a class="nav-link {!! request()->routeIs('store.product') ? 'active' : '' !!}" href="{{ route('store.product') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">storefront</span>
                    </div> Cửa hàng
                </a>

                <!-- Sidenav Heading (Khac)-->
                <div class="sidenav-menu-heading">Khác</div>
                <a class="nav-link" href="{{ route('support') }}/">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">support_agent</span>
                    </div> Yêu cầu hỗ trợ
                </a>
                <a class="nav-link" href="{{ route('faq') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">quiz</span>
                    </div> FAQ
                </a>
                <a class="nav-link link-danger" href="login.php">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">logout</span>
                    </div> Đăng xuất
                </a>
            </div>
        </div>
    </nav>
</div>