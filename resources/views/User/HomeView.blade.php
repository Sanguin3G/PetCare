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
                        <a class="btn pc-primary-cta px-4 py-2" href="{{ route('user.product', ['id' => 'all']) }}">
                            Khám phá sản phẩm <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="pc-hero-media">
                    <img class="img-fluid" src="{{ asset('assets/img/img-about.jpg') }}" alt="Chú mèo nhỏ bên một chú chó vàng">
                </div>
            </section>
            <div class="pc-trust-strip" aria-label="Điểm nổi bật của PetCare">
                <div class="pc-trust-card"><i class="fa-solid fa-tags" aria-hidden="true"></i><div><strong>Dễ chọn sản phẩm</strong><small>Xem giá và số lượng còn lại</small></div></div>
                <div class="pc-trust-card"><i class="fa-solid fa-wallet" aria-hidden="true"></i><div><strong>Thanh toán COD</strong><small>Thanh toán khi nhận hàng</small></div></div>
                <div class="pc-trust-card"><i class="fa-solid fa-box" aria-hidden="true"></i><div><strong>Theo dõi đơn hàng</strong><small>Xem trạng thái trong tài khoản</small></div></div>
            </div>
        </div>

        <div class="container pc-section-heading">
            <div>
                <span class="pc-section-kicker"><i class="fa-solid fa-paw" aria-hidden="true"></i> Gợi ý từ PetCare</span>
                <h2 id="hotProductText">Gợi ý nổi bật cho bé</h2>
            </div>
            <p>Khám phá thức ăn, đồ chơi và đồ dùng cho những khoảnh khắc chăm sóc bé mỗi ngày.</p>
        </div>
        <div class="wrapper container">
            <div class="pc-shop-grid">
                @foreach ($product as $product) @include('User.partials.product-card') @endforeach
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
                            <h5>Thức ăn cho bé</h5>
                            <p>Khám phá danh mục thức ăn và chọn sản phẩm phù hợp.</p>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="{{ asset('assets/img/slider_3.webp') }}" class="d-block w-100" alt="Chăm sóc thú cưng mỗi ngày" loading="lazy">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Chăm sóc mỗi ngày</h5>
                            <p>Đồ dùng cho những thói quen nhỏ bên bé.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/Banner3-1.jpg') }}" class="d-block w-100" alt="Sản phẩm cho thú cưng" loading="lazy">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Chọn món bé cần</h5>
                            <p>Tìm theo danh mục, xem chi tiết và thêm vào giỏ.</p>
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


@endsection
