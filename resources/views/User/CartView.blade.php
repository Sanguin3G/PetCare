@extends('User.LayoutTrangChu')
@section('content')
<div class="container pc-commerce py-4 py-md-5">
    <div class="pc-commerce-heading"><div><p class="pc-eyebrow">Dành cho người bạn nhỏ</p><h1>Giỏ hàng của bạn</h1></div><span id="countItemInCart" class="text-muted" aria-live="polite"></span></div>
    <div id="checkout-success" class="pc-commerce-panel mb-4" hidden tabindex="-1" role="status"><h2>Đặt hàng thành công!</h2><p>Đơn hàng <strong data-order-id></strong> đang chờ xác nhận.</p><a href="{{ route('user.orderView') }}" class="btn btn-primary">Xem đơn hàng</a></div>
    <div id="cart-empty" class="pc-commerce-empty"><i class="fa-solid fa-basket-shopping" aria-hidden="true"></i><h2>Giỏ hàng đang chờ những món yêu thích</h2><p>Chọn đồ ăn, đồ chơi và những vật dụng chăm sóc cho thú cưng.</p><a href="{{ route('user.product', ['id' => 0]) }}" class="btn btn-primary">Khám phá sản phẩm</a></div>
    <div class="pc-cart-layout" data-cart-filled hidden>
        <section class="pc-commerce-panel"><div id="ListProductInCart"></div><a href="{{ route('user.product', ['id' => 0]) }}" class="pc-continue">← Tiếp tục mua sắm</a></section>
        <aside class="pc-commerce-panel pc-cart-summary"><h2>Tóm tắt giỏ hàng</h2><div class="pc-summary-line"><span>Tạm tính</span><strong data-cart-total></strong></div><p>Giá và số lượng được kiểm tra lại khi đặt hàng.</p><a href="#pay-form" class="btn btn-primary w-100">Tiến hành đặt hàng</a></aside>
    </div>
    <section id="pay-form" class="pc-commerce-panel mt-4" data-cart-filled hidden aria-labelledby="checkout-title">
        <h2 id="checkout-title">Thông tin đặt hàng</h2>
        <ol class="pc-checkout-steps"><li>Liên hệ</li><li>Giao hàng</li><li>Thanh toán</li></ol>
        <form class="form-checkout-cart">
            <div class="pc-checkout-grid"><div>
                <div class="mb-3"><label for="checkout-name" class="form-label">Họ và tên</label><input id="checkout-name" name="Name" class="form-control" required maxlength="100" autocomplete="name"></div>
                <div class="mb-3"><label for="checkout-phone" class="form-label">Số điện thoại</label><input id="checkout-phone" name="Phone" type="tel" class="form-control" required maxlength="20" minlength="8" autocomplete="tel"></div>
                <div class="mb-3"><label for="checkout-address" class="form-label">Địa chỉ giao hàng</label><textarea id="checkout-address" name="Address" class="form-control" required maxlength="255" rows="3" autocomplete="street-address"></textarea></div>
                <div class="mb-3"><label for="checkout-note" class="form-label">Ghi chú <span class="text-muted">(không bắt buộc)</span></label><textarea id="checkout-note" name="Note" class="form-control" maxlength="150" rows="2"></textarea></div>
            </div><div class="pc-payment-review"><h3>Thanh toán khi nhận hàng</h3><p>Thanh toán cho nhân viên giao hàng khi nhận sản phẩm.</p><div class="pc-summary-line"><span>Tổng tiền sản phẩm</span><strong data-cart-total></strong></div><p>Vui lòng kiểm tra địa chỉ và số điện thoại trước khi đặt hàng.</p><div id="checkout-feedback" class="alert alert-danger" role="alert" hidden></div><button class="btn btn-primary w-100" type="submit">Đặt hàng · Thanh toán khi nhận</button><p class="mt-3 mb-0" data-login-prompt><a href="{{ route('user.login') }}">Đăng nhập</a> để hoàn tất đặt hàng.</p></div></div>
        </form>
    </section>
</div>
@endsection
