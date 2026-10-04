<!DOCTYPE html>
<html lang="vi" data-theme="light" data-theme-preference="system">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PetCare | Chăm sóc thú cưng mỗi ngày</title>
    <script>
        (() => {
            try {
                const preference = localStorage.getItem('petcare-theme') || 'system';
                const resolved = preference === 'system'
                    ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
                    : preference;
                document.documentElement.dataset.themePreference = preference;
                document.documentElement.dataset.theme = resolved;
            } catch (error) {}
        })();
    </script>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/user-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user1.css') }}">
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- toast message --}}
    <script src="{{ asset('assets/vendor/toast/jquery.toast.min.js') }}"></script>
    <link href="{{ asset('assets/vendor/toast/jquery.toast.min.css') }}" rel="stylesheet">
    @vite(['resources/css/petcare.css', 'resources/js/User/theme.js', 'resources/js/User/Layout.js'])
</head>

<body class="pc-site">
    <a class="pc-skip-link" href="#main-content">Bỏ qua đến nội dung</a>
    <header class="pc-shell">
        <nav class="navbar navbar-expand-xl pc-main-nav" aria-label="Điều hướng chính" id="petcare-main-nav">
            <div class="container pc-shell-row">
                <a class="pc-brand navbar-brand d-flex align-items-center" href="{{ route('user.home') }}"><img src="{{ asset('assets/img/PetCARE.png') }}" alt=""><span>PetCare</span></a>
                <div class="pc-global-search" data-product-search>
                    <form action="{{ route('user.product', ['id' => 'all']) }}" role="search">
                        <label class="visually-hidden" for="nav-search">Tìm sản phẩm</label>
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        <input type="search" name="q" id="nav-search" placeholder="Tìm món ngon, đồ chơi…" maxlength="100" autocomplete="off" aria-controls="nav-search-results" aria-expanded="false">
                        <button class="pc-search-reset" type="button" aria-label="Xóa tìm kiếm" hidden>×</button>
                    </form>
                    <div class="pc-search-results" id="nav-search-results" hidden></div>
                    <span class="visually-hidden pc-search-announcement" role="status" aria-live="polite"></span>
                </div>
                <div class="pc-shell-actions">
                    @include('User.partials.theme-toggle')
                    <a class="buttonLogin btn d-none" href="{{ route('user.login') }}">Đăng nhập</a>
                    <div class="dropdown d-none" id="dropdown-user">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Tài khoản"><i class="fa-regular fa-user" aria-hidden="true"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="{{ route('user.account') }}">Thông tin tài khoản</a></li><li><a class="dropdown-item" href="{{ route('user.orderView') }}">Đơn hàng của tôi</a></li><li><a class="dropdown-item" href="{{ route('user.changePassForm') }}">Đổi mật khẩu</a></li><li><hr class="dropdown-divider"></li><li><button class="dropdown-item button-logout" type="button">Đăng xuất</button></li></ul>
                    </div>
                    <a class="btn pc-cart-link" href="{{ route('user.cart') }}" aria-label="Giỏ hàng"><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i><span class="badge totalInCart d-none"></span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Mở menu"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header"><h2 class="offcanvas-title fs-5" id="offcanvasNavbarLabel">PetCare</h2><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Đóng menu"></button></div>
                    <div class="offcanvas-body"><ul class="navbar-nav">
                        @foreach (['user.home' => 'Trang chủ', 'user.product' => 'Sản phẩm', 'user.about' => 'Giới thiệu'] as $route => $label)
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs($route, $route === 'user.product' ? 'user.productDetail' : $route) ? 'active' : '' }}" @if(request()->routeIs($route, $route === 'user.product' ? 'user.productDetail' : $route)) aria-current="page" @endif href="{{ $route === 'user.product' ? route($route, ['id' => 'all']) : route($route) }}">{{ $label }}</a></li>
                        @endforeach
                    </ul></div>
                </div>
            </div>
        </nav>
    </header>
    <main class="content" id="main-content">
        @yield('content')
    </main>
    <button type="button" id="pc-scroll-top" aria-label="Về đầu trang" title="Về đầu trang">
        <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
    </button>
    <footer class="pc-footer container-fluid d-flex justify-content-around flex-wrap bg-dark mt-5">
        <div class="footer1 d-flex align-items-center flex-column p-3">
            <h2 class="mb-3 mt-4 text-capitalize">PetCare</h2>
            <p>Chăm kỹ từng ngày, vui khỏe dài lâu.</p>
            <p>Ứng dụng cửa hàng thú cưng · Bản demo</p>
        </div>
        <div class="footer2 mt-3 text-white d-flex flex-column justify-content-between p-3">
            <h3>Trải nghiệm PetCare</h3>
            <p>Khám phá sản phẩm, giỏ hàng và theo dõi đơn.</p>
            <p>Dữ liệu mẫu dùng để trải nghiệm ứng dụng.</p>
        </div>
        <div class="footer3 mt-3 p-3"><h3>Khám phá</h3><a href="{{ route('user.product', ['id' => 'all']) }}">Cửa hàng</a><a href="{{ route('user.about') }}">Về PetCare</a></div>

    </footer>
    <div class="loading-overlay d-none">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!--footer end-->
</body>


</html>
