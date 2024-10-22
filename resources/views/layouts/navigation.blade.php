<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
      cluster: 'ap1'
    });
    const role = '{{ Auth::user()->getRoleNames()->first() }}';
    const channelName = 'send-' + role;
    const channel = pusher.subscribe(channelName);
    const eventName = 'event-notification-' + role;
    channel.bind(eventName, function(data) {
        const newNotificationHtml = `
            <li>
                <a class="dropdown-item dropdown-notifications-item active" href="#!">
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-title">${data.data.title}</div>
                        <div class="dropdown-notifications-item-content-text">${data.data.content}</div>
                        <div class="dropdown-notifications-item-content-details">
                            ${new Date(data.data.created_at).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' })} - 
                            ${new Date(data.data.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}
                        </div>
                    </div>
                </a>
            </li>
        `;

        $('.list-notifications').prepend(newNotificationHtml);
    });
</script>
<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
    <!-- Navbar Brand-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('overview.customer') }}">
        <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="rivi logo">
    </a>
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon" id="sidebarToggle">
        <span class="material-symbols-outlined">chevron_left</span>
    </button>
    <!-- Navbar title-->
    <h1 class="topnav-title">{{ $heading_title ?? 'Quản lý dự án' }}</h1>
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
        <!-- Documentation Dropdown-->
        <li class="nav-item dropdown no-caret d-none d-md-block me-3">
            <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if (config('app.locale') === 'vi')
                    <img src="{{ asset('./assets/img/vi.svg') }}" alt="vi">
                    <div class="fw-500">Tiếng Việt</div>
                @else
                    <img src="{{ asset('./assets/img/en.svg') }}" alt="en">
                    <div class="fw-500">English</div>
                @endif
                <span class="material-symbols-outlined">chevron_right</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0 me-sm-n15 me-lg-0 o-hidden animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                <a class="dropdown-item " href="{!! route('user.language', ['language'=>'vi']) !!}">
                    <div class="dropdown-item-icon">
                        <img src="{{ asset('./assets/img/vi.svg') }}" alt="vi">
                    </div>
                    <div> {{ __('auth.vietnamese') }} </div>
                </a>
                <a class="dropdown-item " href="{!! route('user.language', ['language'=>'en']) !!}">
                    <div class="dropdown-item-icon">
                        <img src="{{ asset('./assets/img/en.svg') }}" alt="en">
                    </div>
                    <div> English </div>
                </a>
            </div>
        </li>
        <!-- Alerts Dropdown-->
        <li class="nav-item dropdown no-caret  me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="material-symbols-outlined">notifications_active</span>
                {{-- <span class="dropdown-notifications-count">9</span> --}}
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                <h6 class="dropdown-notifications-header"> Thông báo <button class="btn btn-icon">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </h6>
                    <ul class="list-notifications">
                    </ul>
                    <div class="col-sm-12 text-center p-5">
                        <span class="material-symbols-outlined" style="font-size: 45px">
                            notifications_off
                        </span>
                        <h6>Không có thông báo mới </h6>
                    </div>
            </div>
        </li>
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-fluid" src="{{ asset('./assets/img/profile-1.png') }}" />
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <a class="dropdown-item text-primary" href="#">
                    <div class="dropdown-item-icon">
                        <span class="material-symbols-outlined">id_card</span>
                    </div> {{ auth()->user()->name }}
                </a>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <div class="dropdown-item-icon">
                        <span class="material-symbols-outlined">manage_accounts</span>
                    </div> Tài khoản
                </a>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#change-password-form">
                    <div class="dropdown-item-icon">
                        <span class="material-symbols-outlined">key</span>
                    </div> Đổi mật khẩu
                </a>
                <a class="dropdown-item link-danger" href="{{ route('logout') }}">
                    <div class="dropdown-item-icon">
                        <span class="material-symbols-outlined">logout</span>
                    </div> Đăng xuất
                </a>
            </div>
        </li>
    </ul>
</nav>