
<header class="site-header bg-white sticky-top py-1">
    <div class="container">
        <nav class="container d-flex flex-column flex-md-row justify-content-between">
            <div class="logo">
                <a href="/login">
                    <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="login" style="height: 50px;">
                </a>
            </div>
            <a class="py-2 d-none d-md-inline-block" href="{{route('terms', ['slug' => 'intro'])}}">Giới thiệu</a>
            <a class="py-2 d-none d-md-inline-block" href="{{route('terms', ['slug' => 'terms'])}}">Chính sách và điều khoản</a>
            <a class="py-2 d-none d-md-inline-block" href="{{route('terms', ['slug' => 'contact'])}}">Liên hệ của chúng tôi</a>
        </nav>
    </div>
</header>