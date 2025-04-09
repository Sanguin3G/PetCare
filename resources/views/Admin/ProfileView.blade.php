@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
  <h1 style="font-size:3vw;font-size:3vh">Trang cá nhân</h1>
  <nav>
    <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
      <li class="breadcrumb-item"><button type="button" id="RedirectHomeInProfile">Home</button></li>
      <li class="breadcrumb-item">Users</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

          <img src="{{ asset('assets/img/PetCARE.png') }}" alt="Profile" class="rounded-circle">
          <h2 id="UserName">
          </h2>
          <div class="social-links mt-2">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-8">
      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered" style="font-size:2vw;font-size:2vh">
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Cài đặt</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Đổi mật
                khẩu</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile">Thông tin tài
                khoản</button>
            </li>
          </ul>
          <div class="tab-content pt-2">
            <div class="tab-pane fade pt-3" id="profile-settings">
              <!-- Settings Form -->
              <form>
                <div class="row mb-3" style="font-size:2vw;font-size:2vh">
                  <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Thông báo Email</label>
                  <div class="col-md-8 col-lg-9">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="changesMade" checked>
                      <label class="form-check-label" for="changesMade">
                        Thay đổi tài khoản
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="newProducts" checked>
                      <label class="form-check-label" for="newProducts">
                        Thông báo về sản phẩm và dịch vụ mới
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="proOffers">
                      <label class="form-check-label" for="proOffers">
                        Các chiến lược marketing
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="securityNotify" checked>
                      <label class="form-check-label" for="securityNotify">
                        Thông báo hệ thống
                      </label>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" style="font-size:2vw;font-size:2vh" class="btn btn-primary">Lưu</button>
                </div>
              </form><!-- End settings Form -->
            </div>
            <div class="tab-pane fade pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <form method="post" style="font-size:2vw;font-size:2vh" id="FormUpdatePassWordAdmin">
                <div class="row mb-3">
                  <label for="currentPassword_update" class="col-md-4 col-lg-3 col-form-label">Mật khẩu hiện tại</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="currentPassword_update" type="password" class="form-control"
                      style="border: 1px solid black" id="currentPassword_update">
                  </div>
                  </p>
                </div>
                <div class="row mb-3">
                  <label for="newPassword_update" class="col-md-4 col-lg-3 col-form-label">Mật khẩu mới</label>
                  <div class="col-md-8 col-lg-9">
                    <input style="border: 1px solid black" name="newPassword_update" type="password"
                      class="form-control" id="newPassword_update">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="renewPassword_update" class="col-md-4 col-lg-3 col-form-label">Nhập lại mật khẩu
                    mới</label>
                  <div class="col-md-8 col-lg-9">
                    <input style="border: 1px solid black" name="renewPassword_update" type="password"
                      class="form-control" id="renewPassword_update">
                  </div>
                  </p>
                </div>
                <div class="text-center">
                  <button type="submit" name="changePassAdmin" style="font-size:2vw;font-size:2vh"
                    class="btn btn-primary">Đổi mật khẩu</button>
                </div>
              </form>
            </div>
            {{-- account detail --}}
            <div class="tab-pane fade pt-3" id="profile">
              <form style="font-size:2vw;font-size:2vh" method="post" id="FormUpdateInforAdmin">
                <div class="row mb-3">
                  <label for="name" class="col-md-4 col-lg-3 col-form-label">Họ và tên</label>
                  <div class="col-md-8 col-lg-9">
                    <input style="font-size:2vw;font-size:2vh" name="name" value="" type="text" class="form-control"
                      id="name" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input style="font-size:2vw;font-size:2vh" name="email" type="email" value="" class="form-control"
                      id="email" required>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" style="font-size:2vw;font-size:2vh" name="changePassAdmin"
                    class="btn btn-primary">Cập nhật thông tin</button>
                </div>
              </form><!-- End Change Password Form -->
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>
    </div>
  </div>
  <div class="loading-overlay d-none">
    <div class="spinner"></div>
  </div>
</section>
@vite('resources/js/Admin/account/updateInfor.js')
@endsection