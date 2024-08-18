@include('layouts.navigation')
<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Menu</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="{{ route('home') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">home</span>
                    </div> <?= __('common.overview') ?>
                </a>
                <!-- Sidenav Link (Alerts)-->
                <a class="nav-link " href="{{ route('notification') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">notifications_active</span>
                    </div> Thông báo
                </a>
                <!-- Sidenav Accordion (Nhiemvu)-->
                <a class="nav-link active" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseNhiemvu" aria-expanded="false" aria-controls="collapseNhiemvu">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">assignment</span>
                    </div> Dự án của tôi <div class="sidenav-collapse-arrow">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </a>
                <div class="collapse show" id="collapseNhiemvu" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavNhiemvuMenu">
                        <a class="nav-link" href="{{ route('project.create') }}">Tạo dự án</a>
                        <a class="nav-link active" href="{{ route('project.list') }}">Danh sách dự án</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Vicuatoi)-->
                <a class="nav-link" href="{{ route('wallet') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div> Ví của tôi
                </a>
                
                <a class="nav-link" href="{{ route('history') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">history</span>
                    </div> Lịch sử hoạt động
                </a>
                <!-- Sidenav Heading (Khac)-->
                <div class="sidenav-menu-heading">Khác</div>
                <a class="nav-link" href="{{ route('support') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">support_agent</span>
                    </div> Yêu cầu hỗ trợ
                </a>
                <a class="nav-link" href="{{ route('faq') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">quiz</span>
                    </div> FAQ
                </a>
                <a class="nav-link link-danger" href="{{ route('logout') }}">
                    <div class="nav-link-icon">
                        <span class="material-symbols-outlined">logout</span>
                    </div> Đăng xuất
                </a>
            </div>
        </div>
    </nav>
</div>