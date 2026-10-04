<!DOCTYPE html>
<html lang="vi" data-theme="light" data-theme-preference="system">

<head>
    <meta charset="utf-8">
    <script>(() => { try { const preference=localStorage.getItem('petcare-theme') || 'system'; document.documentElement.dataset.themePreference=preference; document.documentElement.dataset.theme=preference === 'system' ? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : preference; } catch(error) {} })();</script>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>PetCare Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Latest compiled JavaScript -->
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    {{-- toast message --}}
    <script src="
                        {{ asset('assets/vendor/toast/jquery.toast.min.js') }}
                        "></script>
    <link href="
    {{ asset('assets/vendor/toast/jquery.toast.min.css') }}
    " rel="stylesheet">
    @vite('resources/js/Admin/account/LogoutAdmin.js')
    @vite(['resources/css/petcare.css', 'resources/js/User/theme.js', 'resources/js/Admin/LayoutAdmin.js'])
</head>

<body class="petcare-admin">
    <a class="admin-skip" href="#main">Đến nội dung chính</a>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.home') }}" style="text-decoration: none;" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/PetCARE.png') }}" alt="PetCare">
                <span style="" class="d-none d-lg-block">Admin</span>
            </a>
            <button type="button" class="admin-menu-toggle" aria-controls="sidebar" aria-expanded="false" aria-label="M? hoặc ??ng menu"><i class="bi bi-list" aria-hidden="true"></i></button>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item me-2">@include('User.partials.theme-toggle')</li>
                <li id="buttonLogin" class="d-none"><a href="{{ route('admin.login') }}">Đăng nhập</a></li>
                <li id="isHasUser" class="nav-item dropdown pe-3 d-none">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <span style="" id="NameUser"
                            class="d-none d-md-block dropdown-toggle ps-2"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6 style="">Admin</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li id="buttonSettingAccount">
                            <a href="{{ route('admin.profile') }}" class="dropdown-item d-flex align-items-center" id="RedirectProfile">
                                <i class="bi bi-gear"></i>
                                <span style="">Cài đặt tài khoản</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li id="buttonCreateAccount">
                            <a href="{{ route('admin.regist') }}" class="dropdown-item d-flex align-items-center" id="RedirectRegistAccount">
                                <i class="fa-solid fa-plus"></i>
                                <span style="">Tạo tài khoản</span>
                            </a>
                        </li>
                        <li id="buttonLogOut">
                            <button class="dropdown-item d-flex align-items-center" id="buttonLogoutAdmin">
                                <i class="bi bi-box-arrow-right"></i>
                                <span style="">Đăng xuất</span>
                            </button>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <nav aria-label="Quản trị PetCare"><ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-heading">Quản trị cửa hàng</li>
            @foreach ([['admin.home', 'bi-house', 'Tổng quan', request()->routeIs('admin.home')], ['admin.product', 'bi-box-seam', 'Sản phẩm', request()->is('admin/product*')], ['admin.category', 'bi-grid', 'Danh mục', request()->is('admin/category*')], ['admin.order', 'bi-bag-check', 'Đơn hàng', request()->is('admin/order*')]] as [$route, $icon, $label, $active])
            <li class="nav-item"><a href="{{ route($route) }}" class="nav-link {{ $active ? 'active' : 'collapsed' }}" @if($active) aria-current="page" @endif><i class="bi {{ $icon }}" aria-hidden="true"></i><span>{{ $label }}</span></a></li>
            @endforeach
            <li class="nav-heading mt-4">Tài khoản</li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : 'collapsed' }}" href="{{ route('admin.profile') }}"><i class="bi bi-person" aria-hidden="true"></i>Hồ sơ</a></li>
            <li class="nav-item"><a class="nav-link collapsed" href="{{ route('user.home') }}"><i class="bi bi-arrow-up-right" aria-hidden="true"></i>Xem cửa hàng</a></li>
        </ul></nav>
    </aside><!-- End Sidebar-->
    <!-- Load view-->
    <main id="main" class="main" tabindex="-1">
        <div id="admin-feedback" role="status" aria-live="polite"></div>
        @yield('content')
    </main>
    <div class="loading-overlay d-none">
        <div class="spinner"></div>
    </div>
</body>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Template Main JS File -->


</html>
