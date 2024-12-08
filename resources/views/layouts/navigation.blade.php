<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script>
    function getNotification() {
        $.ajax({
            url: "{{ route('notification.user') }}",
            method: 'GET',
            data: {
                user_id: '{{ Auth::user()->id }}'
            },
            success: function(data) {
            if(data.data.length > 0) {
                $('#no-notification').css('display', 'none');
                var newNotificationHtml = '';
                data.data.forEach(function(item) {
                    const active = !item.read_at ? 'active' : '';
                    newNotificationHtml += `
                        <li>
                            <a class="dropdown-item dropdown-notifications-item ${active}" href="{{ URL('/notification/${item.id}') }}" data-id="${item.id}">
                                <div class="dropdown-notifications-item-content">
                                    <div class="dropdown-notifications-item-content-title">${item.title}</div>
                                    <div class="dropdown-notifications-item-content-text">${item.content}</div>
                                    <div class="dropdown-notifications-item-content-details">
                                        ${new Date(item.created_at).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' })} - 
                                        ${new Date(item.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}
                                    </div>
                                </div>
                            </a>
                        </li>
                    `;
                })
                newNotificationHtml += `
                    <button class="btn btn-info w-100 my-2" onclick="window.location.href='{{ route('notification') }}'">Xem tất cả thông báo</button>
                `;
            } else {
                $('#no-notification').css('display', 'block');
            }
            // Nếu là số lượng thông báo chưa đọc > 0 thì hiện số thông báo
            if (data.countUnread > 0) {
                $('.dropdown-notifications-count').text(data.countUnread);
                $('.dropdown-notifications-count').css('display', 'block');
            }

            $('.list-notifications').prepend(newNotificationHtml);
            }
        });
    }

    readNotification = function(id, event) {
        event.removeClass('active');
        console.log(id);
        if (id) {
            $.ajax({
                url: "{{ route('notification.user.read') }}",
                method: 'PUT',
                data: {
                    id: id
                },
                success: function(data) {
                    getNotification();
                }
            });  
        }
    }

    Pusher.logToConsole = true;

    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
      cluster: 'ap1'
    });
    const channelName = 'send-message';
    const userId = '{{ Auth::user()->id }}';
    const channel = pusher.subscribe(channelName);
    const eventName = 'event-notification-user-' + userId;
    channel.bind(eventName, function(data) {
        if(data) {
            $('#no-notification').css('display', 'none');
        }
        const newNotificationHtml = `
            <li>
                <a class="dropdown-item dropdown-notifications-item ${data.data.read_at ? '' : 'active'}" href="{{ URL('/notification/${data.data.id}') }}" data-id="${data.data.id}">
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
        let notificationCount = $('.dropdown-notifications-count').text();
        // Nếu chưa có thông báo nào thì sô thông báo chưa đọc = 0
        if (notificationCount === '') {
            notificationCount = 0;
        }
        $('.list-notifications').prepend(newNotificationHtml);
        $('.dropdown-notifications-count').text(parseInt(notificationCount) + 1);
        $('.dropdown-notifications-count').css('display', 'block');
    });

    $(document).ready(function() {
        getNotification();
    })

</script>
<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
    <!-- Navbar Brand-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('overview.customer') }}">
        <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="rivi logo">
    </a>
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon d-none" id="sidebarToggle">
        <span class="material-symbols-outlined">chevron_left</span>
    </button>
    <!-- Navbar title-->
    <h1 class="topnav-title">{{ $heading_title ?? '' }}</h1>
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto skeleton">
        <!-- Documentation Dropdown-->
        <li class="nav-item dropdown no-caret d-none d-md-block me-3">
            <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if (config('app.locale') === 'vi')
                    <img src="{{ asset('./assets/img/vi.svg') }}" alt="vi">
                    <div class="fw-500">Tiếng Việt</div>
                @else
                    {{-- <img src="{{ asset('./assets/img/en.svg') }}" alt="en">
                    <div class="fw-500">English</div> --}}
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
                {{-- <a class="dropdown-item " href="{!! route('user.language', ['language'=>'en']) !!}">
                    <div class="dropdown-item-icon">
                        <img src="{{ asset('./assets/img/en.svg') }}" alt="en">
                    </div>
                    <div> English </div>
                </a> --}}
            </div>
        </li>
        <!-- Alerts Dropdown-->
        <li class="nav-item dropdown no-caret  me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="material-symbols-outlined">notifications_active</span>
                <span class="dropdown-notifications-count" style="display: none"></span>
            </a>
            <div id="content-notifications" class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                <h6 class="dropdown-notifications-header"> Thông báo <button class="btn btn-icon">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </h6>
                    <ul class="list-notifications">
                    </ul>
                    <div class="col-sm-12 text-center p-5" id ="no-notification">
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
                <img class="img-fluid" src="{!! !empty($profile['avatar']) ? asset('storage/'.$profile['avatar']) : asset('./assets/img/acount-img.svg') !!}" />
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <a class="dropdown-item text-primary" href="javascript:void(0);">
                    <div class="dropdown-item-icon">
                        <span class="material-symbols-outlined">id_card</span>
                    </div> {{ Auth::user()->name }}
                </a>
                <a class="dropdown-item" href="{{Auth::user()->getRoleNames()->first() === 'partner' ? route('profile.partner.edit') : route('profile.edit') }}">
                    <div class="dropdown-item-icon">
                        <span class="material-symbols-outlined">manage_accounts</span>
                    </div> Tài khoản
                </a>
                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#change-password-form">
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