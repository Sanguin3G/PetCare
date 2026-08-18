<?php
use Illuminate\Support\Facades\DB;
use App\Models\product;
use Illuminate\Support\Str;
$product = product::select()->get();
?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/user-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user1.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- toast message --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css" rel="stylesheet">
    {{-- Slick carousel --}}
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/slick-carousel/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/slick-carousel/slick/slick-theme.css') }}">
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"> --}}
    <script src="{{ asset('assets/slick-carousel/slick/slick.min.js') }}"></script>
    @vite(['resources/css/petcare.css', 'resources/js/User/theme.js', 'resources/js/User/Layout.js'])
</head>

<body class="pc-site">
    <a class="pc-skip-link" href="#main-content">Bỏ qua đến nội dung</a>
    <!--Header -->
    <div class="header container-fluid mb-3 fixed-top">
        <div class="pc-topbar d-flex justify-content-between py-2 px-lg-5 flex-wrap text-center align-items-center">
            <div class="text-left mb-2 mb-lg-0 d-inline-flex">
                <a class="text-white px-3" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-white px-3" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-white px-3" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-white px-3" href="">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-white px-3" href="">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
            <div class=" d-inline-flex align-items-right justify-content-end px-0">
                <div class="d-inline-flex align-items-center ">
                    <a style="font-size:1.3vw 1.3vh;text-decoration:none" class="text-white px-3" href=""><i
                            class="fa-solid fa-phone mx-1"></i>0123456789</a>
                </div>
            </div>
        </div>
        {{-- <div class="d-flex justify-content-center mt-2" class="collapse-down">
            <i class="fa-solid fa-angle-down fa-xl"></i>
        </div> --}}
        <div class="row navbar navbar-dark bg-white shadow navbarSlideToggle pc-main-nav" id="petcare-main-nav">
            <nav class="navbar navbar-expand-xl d-flex flex-column">
                <div class="container-fluid d-flex justify-content-around">
                    <div class="nav-brand ps-2 text-center d-flex align-items-center flex-wrap pc-brand">
                        <img class="img-fluid" src="{{ asset('assets/img/PetCARE.png') }}" alt="PetCare">
                        <a class="navbar-brand mx-0" href="{{ route('user.home') }}">PetCare</a>
                    </div>
                    <div>
                        <button class="navbar-toggler mt-2" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <button class="btn text-dark ms-2 me-3" id="btnSearchNav" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                            aria-controls="collapseExample">
                            <i class="fa-solid fa-magnifying-glass" style="font-size: 1.3vw 1.3vh"></i>
                        </button>
                    </div>
                    {{-- search --}}
                    <div id="InputContainer" class="pc-search-desktop" style="width:40%;position: relative;left:-8%">
                        <div class="InputContainer">
                            <i class="fa-solid fa-magnifying-glass pc-search-icon" aria-hidden="true"></i>
                            <input placeholder="Tìm món ngon, đồ chơi, phụ kiện..." id="input" class="input" name="text" type="search" autocomplete="off" aria-label="Tìm kiếm sản phẩm">
                            <button type="button" class="pc-search-clear" data-search-clear="input" aria-label="Xóa tìm kiếm">
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div style="position: absolute;z-index:1">
                            <div id="list-search-product" class="d-flex mt-1 flex-wrap bg-white"
                                style="overflow-y:visible;overflow-x:hidden;max-height:400px;width:100%;z-index:1;border-radius:5px">
                                @foreach ($product as $row)
                                <div class="listPro2" style="display:none;z-index:2">
                                    <div style="width:100%;padding-left:10px;padding-right:20px "
                                        class="d-flex justify-content-start bg-white ">
                                        <?php
                                            $nameProduct = Str::slug($row->namePro);
                                            ?>
                                        <a style="text-decoration:none"
                                            href="{{ route('user.productDetail', ['id' => $row->idPro, 'name' => $nameProduct]) }}">
                                            <img src="{{ asset('assets/img-add-pro/' . $row->getImgProduct($row->idPro)) }}"
                                                class="img-fluid" style="max-width:100px;height:100%"></a>
                                        <p id="product-name-search1" class="ms-3" style="width:100%;font-size:1vw">
                                            {{ $row->namePro }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="buttonInforUser">
                        @include('User.partials.theme-toggle')
                        {{-- @if (!Auth::guard('customer')->check()) --}}
                        <a style="text-decoration:none;color:black;font-size: 1.3vw"
                            class="me-2 ms-2 buttonLogin d-none" href="{{ route('user.login') }}">Đăng
                            Nhập</a><span></span>
                        {{-- @else --}}
                        <div class="nav-item dropdown me-5 d-none" id="dropdown-user">
                            <a class=" login-button dropdown-toggle" style="width:190px" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i>

                            </a>
                            <ul class="dropdown-menu me-5" style="top:60px">
                                <li><button class="dropdown-item button-redirect-order-view" style=""><i
                                            class="fa-solid fa-cart-shopping pe-2" style="color: #cf1717"></i>Đơn
                                        hàng</button>
                                </li>
                                {{-- <li>
                                    @csrf<a style="" class="dropdown-item" href="{{ route('user.infor') }}"><i
                                            class="fa-solid fa-gear pe-2"></i>Cài
                                        đặt</a>
                                </li> --}}
                                <li><button style="" class="dropdown-item btn-changepass"><i
                                            class="fa-solid fa-key pe-2 text-primary"></i>Đổi mật khẩu</button></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><button class="dropdown-item button-logout">Đăng
                                        Xuất<i class="fa-solid fa-right-from-bracket text-secondary ps-2"></i></button>
                                </li>
                            </ul>
                        </div>
                        {{-- @endif --}}
                    </div>
                </div>
                {{-- navbar --}}
                <div>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <div>
                                <span class="pc-section-kicker"><i class="fa-solid fa-paw" aria-hidden="true"></i> PetCare</span>
                                <h5 class="offcanvas-title mt-1" id="offcanvasNavbarLabel">Đi đâu hôm nay?</h5>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body menuOffCanvas">
                            <ul class="navbar-nav d-flex">
                                <li class="nav-item me-4">
                                    <a class="nav-link " aria-current="page" href="{{ route('user.home') }}"><b>Trang
                                            chủ </b></a>
                                </li>
                                <li class="nav-item me-4">
                                    <a class="nav-link" href="{{ route('user.about') }}"><b>Giới thiệu </b></a>
                                </li>
                                {{-- <li class="nav-item me-4">
                                    <a class="nav-link" href="{{ route('user.service') }}"><b> Dịch vụ</b></a>
                                </li> --}}
                                <li class="nav-item dropdown me-4">
                                    <a class="nav-link" href="{{ route('user.product', ['id' => ' ']) }}"><b> Sản
                                            phẩm</b></a>
                                </li>
                                {{-- <li class="nav-item me-4">
                                    <a class="nav-link"
                                        href="{{ route('user.book', ['id' => $firstIdService->id]) }}"><b>Đặt
                                            lịch </b></a>
                                </li> --}}
                                {{-- <li class="nav-item me-4">
                                    <a class="nav-link" href="{{ route('user.contact') }}"><b>Liên hệ </b></a>
                                </li> --}}
                                <li class="nav-item me-4">
                                    <a class="nav-link" type="button" href="{{ route('user.cart') }}"><b>Giỏ hàng
                                        </b><i class="fa-solid fa-cart-shopping ms-1">
                                            {{-- @if (session('cart') && Auth::guard('customer')->check()) --}}
                                            <span
                                                class="position-absolute top-0 ms-2 translate-middle badge rounded-pill bg-danger totalInCart d-none">
                                            </span>
                                            {{-- @endif --}}
                                        </i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </nav>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <button class="btn btn-secondary" id="collapseButton" type="button" aria-controls="petcare-main-nav"
                aria-expanded="true" aria-label="Thu gọn menu" title="Thu gọn menu">
                <i class="fa-solid fa-angle-up fa-xl" aria-hidden="true"></i>
            </button>
        </div>
        <div>
            <div class="row my-2" style="overflow-y:hidden">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="collapse mb-1" id="collapseExample" data-bs-backdrop="static">
                        <div class="input-group flex-nowrap" role=" search">
                            <input id="search_pro" class="form-control me-2" type="search"
                                placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                        </div>
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
                <div id="list-search-product2" class="d-flex mt-1 flex-wrap bg-white" role="listbox"
                style="overflow-y:visible;overflow-x:hidden;max-height:300px;max-width:400px">
                @foreach ($product as $row)
                <div class="listPro bg-white" style="display:none">
                    <div style="height:50px;max-width:400px;padding-left:10px;padding-right:20px "
                        class="d-flex justify-content-start  ">
                        <?php
                                                            $nameProduct = Str::slug($row->namePro);
                                                            ?>
                        <a style="text-decoration:none"
                            href="{{ route('user.productDetail', ['id' => $row->idPro, 'name' => $nameProduct]) }}">
                            <img src="{{ asset('assets/img-add-pro/' . $row->getImgProduct($row->idPro)) }}"
                                class="img-fluid" style="max-width:100px;height:100%" alt="{{ $row->namePro }}"></a>
                        <p id="product-name-search" class="ms-2" style="width:100%;font-size:1.2vw;font-size:1.2vh">
                            {{ $row->namePro }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <main class="content" id="main-content">
        @yield('content')
    </main>
    <button type="button" id="pc-scroll-top" aria-label="Về đầu trang" title="Về đầu trang">
        <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
    </button>
    <script>
        $(function() {
            $(".collapse-down").hide();

            const $mainNav = $("#petcare-main-nav");
            const $collapseButton = $("#collapseButton");

            function updateCollapseButton() {
                const isExpanded = $mainNav.is(":visible");
                const $icon = $collapseButton.find("i");
                $icon.toggleClass("fa-angle-up", isExpanded).toggleClass("fa-angle-down", !isExpanded);
                $collapseButton.attr({
                    "aria-expanded": String(isExpanded),
                    "aria-label": isExpanded ? "Thu gọn menu" : "Mở rộng menu",
                    title: isExpanded ? "Thu gọn menu" : "Mở rộng menu",
                });
            }

            $("#collapseButton").on("click", function() {
                $mainNav.stop(true, true).slideToggle(180, updateCollapseButton);
            });
            updateCollapseButton();

            function filterProducts(inputSelector, itemSelector, nameSelector, listSelector) {
                const query = $(inputSelector).val().trim().toLowerCase();
                let matches = 0;

                $(itemSelector).each(function() {
                    const name = $(this).find(nameSelector).text().trim().toLowerCase();
                    const visible = !query || name.includes(query);
                    $(this).toggle(visible);
                    if (visible) matches++;
                });

                $(listSelector).toggle(Boolean(query) || document.activeElement === $(inputSelector)[0]);
                $(inputSelector).siblings(".pc-search-clear").toggleClass("is-visible", Boolean(query));
                $(inputSelector).attr("aria-expanded", String(Boolean(query) || matches > 0));
            }

            $("#input").on("focus input", function() {
                filterProducts("#input", ".listPro2", "#product-name-search1", "#list-search-product");
            });
            $("#search_pro").on("focus input", function() {
                filterProducts("#search_pro", ".listPro", "#product-name-search", "#list-search-product2");
            });

            $("[data-search-clear]").on("click", function() {
                const input = $(this).data("search-clear");
                $("#" + input).val("").trigger("input").focus();
            });

            $(document).on("click", function(event) {
                if (!$(event.target).closest("#InputContainer, #list-search-product, #collapseExample, #list-search-product2, #search_pro").length) {
                    $("#list-search-product, #list-search-product2").hide();
                }
            });

            $(window).on("scroll", function() {
                $("#pc-scroll-top").toggleClass("is-visible", window.scrollY > 360);
            });
            $("#pc-scroll-top").on("click", function() {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
    </script>
    <style>
        .img_product_search {
            flex: 1;
        }

        .name_product_search {
            flex: 3;
        }

        /* Nền tối che toàn màn hình */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            font-size: 18px;
            z-index: 9999;
        }
    </style>
    <footer class="pc-footer container-fluid d-flex justify-content-around flex-wrap bg-dark mt-5">
        <div class="footer1 d-flex align-items-center flex-column p-3">
            <h1 class="mb-3 mt-4 text-capitalize">PetCare</h1>
            <p>Chăm kỹ từng ngày, vui khỏe dài lâu.</p>
            <p>Giờ hoạt động: 8:00 – 22:00</p>
        </div>
        <div class="footer2 mt-3 text-white d-flex flex-column justify-content-between p-3">
            <h3>Liên hệ</h3>
            <span>
                <h6><i class="fa-solid fa-envelope-circle-check fa-lg me-3"></i>petcare@gmail.com
                </h6>
            </span>
            <span>
                <h6><i class="fa-solid fa-phone fa-lg me-4"></i>0912345678</h6>
            </span>
            <span>
                <h6><i class="fa-solid fa-location-dot fa-lg me-4"></i>Láng
                    Thượng, Đống Đa, Hà
                    Nội
                </h6>
            </span>
        </div>
        <div class="footer3 d-flex text-white flex-column mt-3 p-3 text-center">
            <h3>Cộng đồng PetCare</h3>
            <a href="#" class="mb-4" aria-label="PetCare trên Facebook"><i class="fa-brands fa-facebook fa-lg me-3"></i></a>
            <a href="#" class="mb-4" aria-label="PetCare trên Instagram"><i class="fa-brands fa-instagram fa-lg me-3"></i></a>
            <a href="#" class="mb-4" aria-label="PetCare trên YouTube"><i class="fa-brands fa-youtube fa-lg me-3"></i></a>
        </div>

    </footer>
    <div class="loading-overlay d-none">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!--footer end-->
</body>
<script src="{{ asset('assets/js/script.js') }}"></script>

</html>
