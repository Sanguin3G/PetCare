<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin-Petcare</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Latest compiled JavaScript -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script href="{{ asset('assets/js/chart.js') }}"></script>
    {{-- toast message --}}
    <script src="
                    https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js
                    "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css
    " rel="stylesheet">
    {{-- data table --}}
    <link href="
        https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css
        " rel="stylesheet">
    <script src="
                       https://cdn.datatables.net/2.2.2/js/dataTables.min.js
                        "></script>
    <script src="
                        https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js
                        "></script>
    @vite('resources/js/Admin/account/LogoutAdmin.js')
    @vite('resources/js/Admin/LayoutAdmin.js')
</head>
<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.home') }}" style="text-decoration: none;" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/PetCARE.png') }}">
                <span style="font-size:3vw;font-size:3vh" class="d-none d-lg-block">Admin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                <li id="buttonLogin" class="d-none"><a href="{{ route('admin.login') }}">Đăng nhập</a></li>
                <li id="isHasUser" class="nav-item dropdown pe-3 d-none">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <span style="font-size:1.5vw;font-size:1.5vh" id="NameUser"
                            class="d-none d-md-block dropdown-toggle ps-2"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6 style="font-size:2vw;font-size:2vh">Admin</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li id="buttonSettingAccount">
                            <button class="dropdown-item d-flex align-items-center" id="RedirectProfile">
                                <i class="bi bi-gear"></i>
                                <span style="font-size:1.5vw;font-size:1.5vh">Cài đặt tài khoản</span>
                            </button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li id="buttonCreateAccount">
                            <button class="dropdown-item d-flex align-items-center" id="RedirectRegistAccount">
                                <i class="fa-solid fa-plus"></i>
                                <span style="font-size:1.5vw;font-size:1.5vh">Tạo tài khoản</span>
                            </button>
                        </li>
                        <li id="buttonLogOut">
                            <button class="dropdown-item d-flex align-items-center" id="buttonLogoutAdmin">
                                <i class="bi bi-box-arrow-right"></i>
                                <span style="font-size:1.5vw;font-size:1.5vh">Đăng xuất</span>
                            </button>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav" stype="width:100%">
            <li class="nav-item" id="RedirectHome" >
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link">
                    <i class="fa-solid fa-house-user"></i>
                    <span>Trang chủ</span>
                </button>
            </li>
            <li id="RedirectSchedule" class="nav-item">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Lịch làm việc</span>
                </button>
            </li>

            <li class="nav-item" id="RedirectCustomer">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-person"></i></i><span>Quản lý khách hàng</span>
                </button>
            </li>
            {{-- <li class="nav-item" id="RedirectStaff">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-users-gear"></i><span>Quản lý nhân viên</span>
                </button>
            </li> --}}

            <li class="nav-item" id="RedirectProduct">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-brands fa-product-hunt"></i><span>Quản lý sản phẩm</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectCategory">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-book-open"></i><span>Quản lý danh mục</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectService">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-brands fa-servicestack"></i><span>Quản lý dịch vụ</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectCart">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-cart-shopping"></i><span>Quản lý đơn hàng</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectDiscount">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-tags"></i><span>Quản lý khuyến mại</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectVoucher">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-ticket"></i><span>Quản lý Voucher</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectBooking">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-comments"></i><span>Quản lý lịch hẹn</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectPost">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-book"></i><span>Quản lý bài viết</span>
                </button>
            </li>
            <li class="nav-item" id="RedirectAccount">
                <button style="font-size:1.5vw;font-size:1.5vh;width:100%" class="nav-link ">
                    <i class="fa-solid fa-circle-user"></i><span>Quản lý tài khoản</span>
                </button>
            </li>

        </ul>
    </aside><!-- End Sidebar-->
    <!-- Load view-->
    <div id="main" class="main">
        @yield('content')
    </div>

</body>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>

</html>