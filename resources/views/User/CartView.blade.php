@extends('User.LayoutTrangChu')
@section('content')
<div class="container-fluid cartView" style="height:max-height">
  {{-- cartSmallView --}}
  <div class="cartSmallView mt-2">
    <section class="h-100" style="background-color: #d2c9ff;margin-bottom:50px">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
              <div class="card-body p-0">
                <div class="row g-0">
                  <div class="col-lg-8">
                    <div class="p-5">
                      <div class="d-flex justify-content-between align-items-center mb-5">
                        <h3 class="fw-bold mb-0">Shopping Cart <i class="fa-solid fa-cart-plus"></i></h3>
                        <h6 class="mb-0 text-muted" id="countItemInCart">
                        </h6>
                      </div>
                      <hr class="my-4">
                      <div id="ListProductInCart" class="d-none">
                        {{-- Danh sách các sản phẩm trong giỏ hàng --}}
                      </div>
                      {{-- <div class="pt-3 text-end">
                        <button type="submit" class="btn btn-dark"><i class="fa-solid fa-box-archive"></i> Cập nhật
                        </button>
                      </div> --}}
                      <div class="pt-2">
                        <h6 class="mb-0"><a href="{{ route('user.home') }}" class="text-body"><i
                              class="fas fa-long-arrow-alt-left me-2"></i>Trở về </a>
                        </h6>

                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 bg-body-tertiary d-none right-part-cart">
                    <div class="p-5">
                      <h3 class="fw-bold mb-5 mt-2 pt-1">Tổng thanh toán </h3>
                      <hr class="my-4">
                      <h5 class="text-uppercase mb-3">Voucher</h5>

                      <div class="mb-5">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                          data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Sử dụng
                          Voucher</button>
                      </div>
                      <hr class="my-4">
                      <div class="mb-5 d-flex flex-column">
                        <div class="d-flex justify-content-between">
                          <h5>Tổng tiền</h5>
                          <h5 class="text-end CountTotalCost">
                            {{-- tổng tiền thanh toán --}}
                          </h5>
                        </div>
                        <div id="voucher">

                        </div>
                        <div class="discount">
                          <div class="d-flex justify-content-between">
                            <h5 class="">Giảm giá </h5>
                            <h5 id="discount" class="text-danger">
                              {{-- phần trăm giảm giá của voucher --}}
                              0%
                            </h5>
                          </div>
                        </div>
                        <div class="totalcost">
                          <div class="d-flex justify-content-between">
                            <h5 class="me-5">Thành tiền</h5>
                            <h5 id="totalcost" class="text-danger">
                              {{-- số tiền phải trả --}}
                            </h5>
                          </div>
                        </div>
                      </div>
                      <a href="#pay-form" style="text-decoration:none;color:white"><button class="buttonThanhToan"
                          type="button"><span class="shadow"></span>
                          <span class="edge"></span>
                          <span class="front text"> Thanh toán
                          </span></button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  @vite('resources/js/User/cart/cart.js')
  <style>
    /* From Uiverse.io by Cybercom682 */
    .number-control {
      display: flex;
      align-items: center;
    }

    .number-left::before,
    .number-right::after {
      content: attr(data-content);
      background-color: #333333;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid black;
      width: 20px;
      color: white;
      transition: background-color 0.3s;
      cursor: pointer;
    }

    .number-left::before {
      content: "-";
    }

    .number-right::after {
      content: "+";
    }

    .number-quantity {
      padding: 0.25rem;
      border: 1px solid black;
      width: 50px;
      -moz-appearance: textfield;
      border-top: 1px solid black;
      border-bottom: 1px solid black;
    }

    .number-left:hover::before,
    .number-right:hover::after {
      background-color: #666666;
    }

    @media (min-width: 1025px) {
      .h-custom {
        height: 100vh !important;
      }
    }

    .card-registration .select-input.form-control[readonly]:not([disabled]) {
      font-size: 1rem;
      line-height: 2.15;
      padding-left: .75em;
      padding-right: .75em;
    }

    .card-registration .select-arrow {
      top: 13px;
    }
  </style>
</div>
<div id="pay-form" class="d-none">
  <div class="container mt-4 d-flex flex-column justify-content-center" id="pay-form">
    <div class="customer-detail bg-light" style="border:1px solid gray;border-radius:5px;padding:10px">
      <div class="mt-3"><strong>Thông tin khách hàng</strong></div>
      <form class="mt-4 form-checkout-cart" method="post">
        {{-- Tổng tiền của đơn hàng --}}
        {{-- bankCode --}}
        <input hidden id="bankCode" name="bankCode" value="">
        {{-- language --}}
        <input hidden id="language" name="language" value="vn">
        <input id="name" name="name" type="text" class="form-control mb-3" placeholder="Họ và tên" required>
        <input id="phonenumber" name="phone" type="text" class="form-control" placeholder="Số điện thoại" required>
        <input id="address" type="text" class="form-control mt-2" placeholder="Địa chỉ giao hàng" name="address"
          required>
        <p hidden><input id="idVoucher" name="idVoucher" value=""></p>
        {{-- <input onclick="checkCustomerDetailEmail()" onkeyup="checkCustomerDetailEmail()" id="email" type="email"
          class="form-control" placeholder="Email" required> --}}
        <p>Ghi chú (nếu có)</p>
        <input id="description" type="text" name="note" class="form-control"
          style="width:100%;resize:none;border-radius:5px;min-height:100px">

        <div class="payment mt-5 bg-light" id="payment" style=" border:1px solid gray;border-radius:5px;padding:10px">
          <div class="mb-2">
            <strong>
              Chọn phương thức thanh toán
            </strong>
          </div>
          <div class="payment-1">
            <input type="radio" value="Thanh toán bằng phương thức COD" name="payment" id="payment1">
            <label style="font-weight: bolder;" for="payment-1">Thanh toán bằng phương thức COD</label>
            <div class="payment1-detail">
              <p>
                - Quý khách vui lòng thanh toán toàn bộ giá trị đơn hàng cho nhân viên giao hàng
              </p>
              <span>
                <strong>Lưu ý: </strong>
                <p>Trong trường hợp có bất cứ vấn đề gì về đơn hàng sau khi thanh toán quý khách vui
                  lòng liên hệ qua
                  bên tổng đài qua số Hotline: <strong>0912345669</strong></p>
              </span>
            </div>
          </div>

          <div class="payment-2">
            <input type="radio" value="Thanh toán bằng phương thức chuyển khoản" name="payment" id="payment2">
            <label style="font-weight: bolder;" for="payment-2">Thanh toán bằng phương thức chuyển
              khoản</label>
            <div class="payment2-detail">
              <p>
                Chủ tài khoản: NGUYEN PHUONG NAM
              </p>
              <p>Số tài khoản: 0123456789</p>
              <p>Nội dung chuyển khoản: <span class="text-danger"> [Họ tên khách hàng + số điện thoại] -
                  Vui lòng nhập
                  thông tin đúng với thông tin đã điền ở phía trên</span></p>
              <span>
                <strong>Lưu ý: </strong>
                <p>Trong trường hợp có bất cứ vấn đề gì về đơn hàng sau khi thanh toán quý khách vui
                  lòng liên hệ qua
                  bên tổng đài qua số Hotline: <strong>0912345669</strong></p>
              </span>
            </div>
          </div>

          {{-- vnpay --}}
          <div class="payment-3">
            <input type="radio" value="Thanh toán bằng VNPAY" name="payment" id="payment3">
            <label style="font-weight: bolder;" for="payment-3">Thanh toán bằng VNPAY</label>
            <div class="payment3-detail">
              <button class="btn btn-white d-flex" type="submit" style="width:300px;height:80px">
                <p class="mt-3 me-2"><strong>Thanh toán VNPay </strong></p>
                <img src="{{ asset('assets/img/vnpay-logo-vinadesign-25-12-57-55.jpg') }}"
                  style="width:80px;height:80px" class="img-fluid">
              </button>
            </div>
          </div>

          <br>
          <button type="submit" style="width:15%" id="confirm-payment" class="btn btn-danger mt-3">
            Xác nhận thanh toán
          </button>
        </div>
      </form>
    </div>
  </div>


</div>
<div class="container-fluid text-center">
  <img class="img-fluid" src="{{ asset('assets/img/618lwjSdN6L._AC_UF1000,1000_QL80_.jpg') }}">
</div>
{{-- <script src="{{ asset('assets/js/script.js') }}"></script> --}}
@endsection