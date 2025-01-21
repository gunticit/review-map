@extends('layouts.app-noheader')
@section('content')
    <style>
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: #fff;
        }

        .main-content {
            min-height: 100vh;
            padding-bottom: 50px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            position: relative;
            text-align: center;
        }
    </style>
    <!-- Header -->
    @include('layouts.header-terms')

    <!-- Nội dung trang điều khoản -->
    <div class="main-content container py-5">
        <section class="terms-content mt-5">
            <div class="card">
                <div class="card-body">
                    <h1>{{ $heading_title }}</h1>
                    <?= $content; ?>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <b class="mb-0">&copy; 2025 RIVI.</b>
    </footer>
@endsection