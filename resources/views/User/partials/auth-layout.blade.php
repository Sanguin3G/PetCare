<!DOCTYPE html>
<html lang="vi" data-theme="light" data-theme-preference="system">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | PetCare</title>
    <script>try { const p = localStorage.getItem('petcare-theme') || 'system'; document.documentElement.dataset.themePreference = p; document.documentElement.dataset.theme = p === 'system' ? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : p; } catch (e) {}</script>
    <link rel="icon" href="{{ asset('assets/img/PetCARE.png') }}">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @vite(['resources/css/petcare.css', 'resources/js/User/theme.js'])
    @yield('auth-script')
</head>
<body class="pc-auth">
    <div class="pc-auth-theme">@include('User.partials.theme-toggle')</div>
    <main class="container pc-auth-wrap">
        <div class="row rounded-5 p-3 box-area w-100 mx-0">
            <div class="col-md-5 rounded-4 left-box d-flex align-items-center justify-content-center flex-column">
                <a href="{{ route('user.home') }}" aria-label="PetCare — Trang chủ"><img src="{{ asset('assets/img/PetCARE.png') }}" class="img-fluid" alt="PetCare" width="280" height="280"></a>
                <p class="text-center px-3">Một tài khoản, nhiều niềm vui cho bé.</p>
            </div>
            <div class="col-md-7 right-box">
                <a href="{{ route('user.home') }}" class="pc-auth-back">← Về PetCare</a>
                <h1 class="h3 fw-bold mt-3">@yield('title')</h1>
                <p class="pc-auth-intro">@yield('intro')</p>
                @yield('auth-content')
            </div>
        </div>
    </main>
</body>
</html>
