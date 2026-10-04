@extends('User.LayoutTrangChu')
@section('content')
<div class="contentabout pc-about">
  <div class="text-center pc-about-intro">
    <span class="pc-section-kicker"><i class="fa-solid fa-paw" aria-hidden="true"></i> Câu chuyện PetCare</span>
    <h1 id="aboutText">Chăm tốt hơn, vui lâu hơn</h1>
    <p>PetCare là ứng dụng cửa hàng thú cưng bản demo, với sản phẩm mẫu để bạn khám phá trải nghiệm mua sắm.</p>
  </div>
  <div class="about container d-flex justify-content-around mt-3 pc-about-card">
    <div class="about-left d-flex flex-column justify-content-between">
      <div class="about-left-1">
        <h2 class="h5">Tìm món bé cần <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></h2>
        <p>Tìm theo tên, lọc danh mục và sắp xếp sản phẩm để chọn thức ăn, đồ chơi hoặc đồ dùng cho bé.</p>
      </div>
      <div class="about-left-2">
        <h2 class="h5">Thông tin rõ ràng <i class="fa-solid fa-tags" aria-hidden="true"></i></h2>
        <p>Xem hình ảnh, giá và số lượng còn lại trước khi thêm sản phẩm vào giỏ.</p>
      </div>
    </div>
    <div>
      <span class="pc-about-visual"><img class="img-fluid rounded-circle" src="{{ asset('assets/img/img-about.jpg') }}" alt="Thú cưng trong câu chuyện PetCare" loading="lazy"></span>
    </div>
    <div class="about-right d-flex flex-column justify-content-between ms-3">
      <div class="about-right-1">
        <h2 class="h5">Giỏ hàng dễ chỉnh <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i></h2>
        <p>Điều chỉnh số lượng, kiểm tra tổng tiền và nhập thông tin giao hàng trong một luồng đơn giản.</p>
      </div>
      <div class="about-right-2">
        <h2 class="h5">Theo dõi trong tài khoản <i class="fa-solid fa-box" aria-hidden="true"></i></h2>
        <p>Xem lịch sử, chi tiết và trạng thái đơn hàng. Đơn đang chờ xử lý có thể được hủy khi cần.</p>
      </div>
    </div>
  </div>
  <div class="container text-center mt-4">
    <a class="btn pc-primary-cta" href="{{ route('user.product', ['id' => 'all']) }}">Khám phá sản phẩm</a>
  </div>
</div>
@endsection
