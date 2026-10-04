@extends('User.LayoutTrangChu')
@section('content')
<div class="container pc-customer-profile py-4 py-md-5">
    <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('user.home') }}">Trang chủ</a></li><li class="breadcrumb-item active" aria-current="page">Tài khoản</li></ol></nav>
    <div class="row g-4">
        <aside class="col-lg-4">
            <div class="pc-account-panel">
                <span class="pc-section-kicker">Tài khoản PetCare</span>
                <h1 class="h3 mt-2">Thông tin của bạn</h1>
                <p class="pc-account-muted">Cập nhật thông tin liên hệ và quản lý mua sắm tại PetCare.</p>
                <nav aria-label="Tài khoản" class="pc-account-links">
                    <a class="active" aria-current="page" href="{{ route('user.account') }}"><i class="fa-regular fa-user" aria-hidden="true"></i> Thông tin tài khoản</a>
                    <a href="{{ route('user.orderView') }}"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Đơn hàng của tôi</a>
                    <a href="{{ route('user.changePassForm') }}"><i class="fa-solid fa-lock" aria-hidden="true"></i> Bảo mật</a>
                </nav>
            </div>
        </aside>
        <div class="col-lg-8">
            <section class="pc-account-panel">
                <h2 class="h4 mb-2">Thông tin liên hệ</h2><p class="pc-account-muted mb-4">Email được dùng để đăng nhập và nhận thông tin đơn hàng.</p>
                <p data-profile-loading role="status">Đang tải thông tin…</p>
                <form id="customer-profile-form" hidden>
                    <div class="mb-3"><label for="profile-name" class="form-label">Họ và tên</label><input class="form-control" id="profile-name" name="name" required maxlength="50" autocomplete="name" aria-describedby="profile-name-error"><div class="invalid-feedback" id="profile-name-error" data-profile-error="name"></div></div>
                    <div class="mb-4"><label for="profile-email" class="form-label">Email</label><input class="form-control" id="profile-email" name="email" type="email" required maxlength="255" autocomplete="email" aria-describedby="profile-email-error"><div class="invalid-feedback" id="profile-email-error" data-profile-error="email"></div></div>
                    <p data-profile-feedback role="status" aria-live="polite"></p><button class="btn pc-primary-cta" type="submit">Lưu thông tin</button>
                </form>
                <div data-profile-failure hidden><p role="alert">Không thể tải thông tin tài khoản.</p><button class="btn pc-secondary-cta" type="button" data-profile-retry>Thử lại</button> <a href="{{ route('user.login') }}">Đăng nhập lại</a></div>
            </section>
        </div>
    </div>
</div>
@endsection
