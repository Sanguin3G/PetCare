@extends('User.LayoutTrangChu')
@section('content')
    <?php use Illuminate\Support\Str; ?>
    <div class="contentuser pc-home">
        <div class="container">
            <section class="pc-hero" aria-labelledby="home-title">
                <div class="pc-hero-copy">
                    <span class="pc-eyebrow"><i class="fa-solid fa-paw" aria-hidden="true"></i> Pet wellness, made simple</span>
                    <h1 id="home-title">Mỗi ngày của bé, <span>thêm một chút yêu thương.</span></h1>
                    <p>Thức ăn, đồ chơi và những món chăm sóc được chọn để hành trình nuôi thú cưng nhẹ nhàng hơn.</p>
                    <div>
                        <a class="btn pc-primary-cta px-4 py-2" href="{{ route('user.product', ['id' => ' ']) }}">
                            Khám phá sản phẩm <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="pc-hero-media">
                    <img class="img-fluid" src="{{ asset('assets/img/banner_collection.webp') }}" alt="Bộ sưu tập sản phẩm PetCare">
                </div>
            </section>
            <div class="pc-trust-strip" aria-label="Điểm nổi bật của PetCare">
                <div class="pc-trust-card"><i class="fa-solid fa-leaf" aria-hidden="true"></i><div><strong>Chọn lọc tử tế</strong><small>Ưu tiên sản phẩm an toàn</small></div></div>
                <div class="pc-trust-card"><i class="fa-solid fa-truck-fast" aria-hidden="true"></i><div><strong>Đóng gói cẩn thận</strong><small>Giao nhanh, gọn, sạch</small></div></div>
                <div class="pc-trust-card"><i class="fa-solid fa-heart" aria-hidden="true"></i><div><strong>Luôn có người hỗ trợ</strong><small>Tư vấn khi bạn cần</small></div></div>
            </div>
        </div>

        <div class="container pc-section-heading">
            <div>
                <span class="pc-section-kicker"><i class="fa-solid fa-sparkles" aria-hidden="true"></i> Được yêu thích</span>
                <h2 id="hotProductText">Gợi ý nổi bật cho bé</h2>
            </div>
            <p>Những lựa chọn được yêu thích để bữa ăn ngon hơn, giờ chơi vui hơn và việc chăm sóc trở nên dễ dàng.</p>
        </div>
        <div class="wrapper container">
            <div class="carouselHome ">
                <!-- san pham 1 -->
                @foreach ($product as $row)
                    <div class="col-xl-9 col-lg-9 col-md-6 mb-3 ps-3" style="position:relative">
                        <div class="product-box">
                            <div class="product-inner-box ">
                                <div class="icons d-flex justify-content-end">
                                    <a class="text-decoration-none text-dark"><i class="fa-solid fa-heart"
                                            style="color: #ec0e0e;"></i></a>
                                </div>
                                <div class="onsale">
                                    @if ($row->discount > 0)
                                        <span style="position: absolute;top:40px" class="badge rounded-2"><i
                                                class="fa-solid fa-arrow-down"></i>{{ $row->discount }}%</span>
                                    @endif
                                    <?php
                                    $nameProduct = Str::slug($row->namePro);
                                    ?>
                                    <a
                                        href="{{ route('user.productDetail', ['id' => $row->idPro, 'name' => $nameProduct]) }}"><img
                                            src="{{ asset('assets/img-add-pro/' . $row->getImgProduct($row->idPro)) }}"
                                            class="img-fluid" loading="lazy" alt="{{ $row->namePro }}"></a>
                                </div>
                                <div class="cart" style="position:absolute;top:0px">
                                    {{-- @if (Auth::guard('customer')->check()) --}}
                                    <button class="btn btn-white shadow-sm rounded-pill buy-btn buttonBuy d-none"
                                        data-id="{{ $row->idPro }}" data-name="{{ $row->namePro }}"
                                        data-cost="{{ $row->cost }}" data-discount="{{ $row->discount }}"
                                        data-image="{{ asset('assets/img-add-pro/' . $row->getImgProduct($row->idPro)) }}"
                                        id="buy"><i class="fa-solid fa-cart-shopping text-danger"></i>
                                        Mua</button>
                                    {{-- @else --}}
                                    <button class=" btn btn-white shadow-sm rounded-pill buttonBuyNoUser d-none"><a
                                            href="{{ route('user.login') }}"
                                            style="text-decoration:none;color:black;font-size:2vw;font-size:2vh;cursor: pointer;"><i
                                                class="fa-solid fa-cart-shopping text-danger"></i>
                                            Mua
                                        </a></button>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-name mt-2">
                                    <h3><b>{{ $row->namePro }}</b></h3>
                                </div>
                                <span class="rating secondary-font">
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    5.0</span>
                                <div class="product-price">
                                    @if ($row->discount > 0)
                                        <p class=" text-secondary text-decoration-line-through mb-0">
                                            {{ number_format($row->cost) }}đ
                                        </p>
                                        <p class=" text-danger fs-5">
                                            {{ number_format($row->cost - ($row->cost * $row->discount) / 100) }}đ
                                        @else
                                        <p class=" text-danger mb-0">{{ number_format($row->cost) }}đ</p>
                                    @endif

                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container mt-4">
            <div id="carouselExampleDark" class="carousel carousel-dark slide pc-story-carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner" style="font-size:1.3vw">
                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="{{ asset('assets/img/banner.jpg') }}" class="d-block w-100" alt="Thức ăn đa dạng cho thú cưng" loading="lazy">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Đa dạng cái loại đồ ăn</h5>
                            <p>Chúng tôi luôn đem đến da dạng các loại đồ ăn cho thú cưng</p>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="{{ asset('assets/img/slider_3.webp') }}" class="d-block w-100" alt="Dịch vụ tận tâm tại PetCare" loading="lazy">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Dịch vụ tận tâm</h5>
                            <p>Chúng tôi luôn quan tâm đến trải nghiệm người dùng </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/Banner3-1.jpg') }}" class="d-block w-100" alt="Sản phẩm chất lượng cho thú cưng" loading="lazy">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Uy tín, chất lượng</h5>
                            <p>Chúng tôi luôn đặt uy tín, chất lượng lên hàng đầu</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

    </div>
    <script src="{{ asset('assets/js/home.js') }}"></script>
    @vite('resources/js/User/home.js')
@endsection
