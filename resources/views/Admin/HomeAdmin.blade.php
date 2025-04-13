@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
  <h1>Trang chủ</h1>
  <div class="main-content mt-4">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        {{-- Dữ liệu thống kê doanh thu theo tuần --}}
        <input value="14" id="Monday" hidden>
        <input value="29" id="Tuesday" hidden>
        <input value="30" id="Wednesday" hidden>
        <input value="50" id="Thursday" hidden>
        <input value="60" id="Friday" hidden>
        <input value="50" id="Saturday" hidden>
        <input value="79" id="Sunday" hidden>
        {{-- dữ liệu thống kê theo tháng --}}
        <input value="<?php echo rand(1000, 10000); ?>" id="jan" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="feb" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="mar" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="apr" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="may" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="june" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="july" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="aug" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="sep" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="oc" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="no" hidden>
        <input value="<?php echo rand(1000, 10000); ?>" id="de" hidden>
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-coins" style="color: #FFD43B;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Số đơn hàng hôm nay</p>
                  <h4 class="mb-0">{{ 12 }}</h4>
                </div>
              </div>
              {{--
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>so với tuần trước</p>
              </div> --}}
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-users" style="color: #74C0FC;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Sản phẩm hết hàng</p>
                  <h4 class="mb-0">{{ 1 }}</h4>
                </div>
              </div>
              {{--
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than
                  lask month</p>
              </div> --}}
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-user-check" style="color: #74C0FC;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Tổng khách hàng truy cập</p>
                  <h4 class="mb-0">{{ 12 }}</h4>
                </div>
              </div>
              {{--
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> so với hôm qua</p>
              </div> --}}
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-money-check" style="color: #e60f0f;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Doanh thu</p>
                  <h4 class="mb-0">1.000.000đ</h4>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>so
                  với hôm qua</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2 ">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <div class="chart">
                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <h5 class="mt-2 ">Doanh số tuần (triệu đồng)</h5>
                {{-- <p class="text-sm ">Last Campaign Performance</p> --}}
                <hr class="dark horizontal">
                <div class="d-flex ">
                  {{-- <i class="material-icons text-sm my-auto me-1">schedule</i> --}}
                  {{-- <p class="mb-0 text-sm"> campaign sent 2 days ago </p> --}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2  ">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                  <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <h5 class="mt-2 "> Doanh số tháng (triệu đồng) </h5>
                <p class="text-sm "> (<span class="font-weight-bolder text-success">+15%</span>) tháng nay. </p>
                <hr class="dark horizontal">
                <div class="d-flex ">
                  {{-- <i class="material-icons text-sm my-auto me-1">schedule</i> --}}
                  <p class="mb-0 text-sm"> Cập nhật 4 phút trước </p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="row mb-4">
          <div class="col-lg-8 col-md-7 mb-md-0 mb-4">
            <div class="card" style="border:1px solid black">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h4 class="text-black">Đơn hàng</h4>
                    {{-- <p class="text-sm mb-0">
                      <i class="fa fa-check text-info" aria-hidden="true"></i>
                      <span class="font-weight-bold ms-1">30 done</span> this month
                    </p> --}}
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead class="table-primary">
                      <tr>
                        <th class=" text-xxs font-weight-bolder opacity-7">
                          Khách hàng</th>
                        <th class=" text-xxs font-weight-bolder opacity-7 ps-2">
                          Số điện thoại</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Thanh toán</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Trạng thái</th>
                      </tr>
                    </thead>
                
                  </table>
                </div>
              </div>
            </div>
            {{-- danh sách sản phẩm hot --}}
            <div class="card w-100" style="border:1px solid black">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h4 class="text-black">Sản phẩm HOT</h4>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead class="table-primary">
                      <tr>
                        <th class=" text-xxs font-weight-bolder opacity-7">
                          Tên sản phẩm</th>
                        <th class="ps-2">
                          Hình ảnh</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Giảm giá</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Số lượng mua</th>
                      </tr>
                    </thead>
                  
                  </table>
                </div>
              </div>
            </div>
            {{-- danh sách sản phẩm bán chậm --}}
            <div class="card w-100" style="border:1px solid black">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h4 class="text-black">Sản phẩm bán chậm</h4>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead class="table-primary">
                      <tr>
                        <th class=" text-xxs font-weight-bolder opacity-7">
                          Tên sản phẩm</th>
                        <th class="ps-2">
                          Hình ảnh</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Giảm giá</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Số lượng tồn</th>
                      </tr>
                    </thead>
                  
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-5">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="text-black">Thông báo</h5>
                {{-- <p class="text-sm">
                  <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                  <span class="font-weight-bold">24%</span> this month
                </p> --}}
              </div>
              <div class="card-body p-3">
                <div class="timeline timeline-one-side" style="height:300px;overflow:auto">
                  {{-- @foreach ($CustomerNotice as $row) --}}
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-success text-gradient">thông báo</i>
                    </span>
                    <div class="timeline-content">
                      <h5 class="text-dark text-sm font-weight-bold mb-0">
                        Nam
                      </h5>
                      <p>Đã đăng ký tài khoản thành công</p>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                        13:00h
                      </p>
                    </div>
                  </div>
                  <hr>
                  {{-- @endforeach --}}
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('assets/js/admin/homeadmin.js') }}"></script>
</div>
@endsection