<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin-Đăng Nhập</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  {{-- toast message --}}
  <script src="
            {{ asset('assets/vendor/toast/jquery.toast.min.js') }}
            "></script>
  <link href="
            {{ asset('assets/vendor/toast/jquery.toast.min.css') }}
            " rel="stylesheet">
  @vite('resources/js/Admin/account/LoginAdmin.js')
</head>

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="index.php" style="text-decoration: none;" class="logo d-flex align-items-center w-auto">
                  <img src="{{ asset('assets/img/PetCARE.png') }}" alt="">
                  <span class="d-none d-lg-block">Admin-Petcare</span>
                </a>
              </div>
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Đăng Nhập</h5>
                  </div>
                  <form class="row g-3 formLogin" method="post">
                    @csrf
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" required autocomplete="username" name="email" class="form-control" id="yourUsername">
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mật khẩu</label>
                      <input type="password" autocomplete="current-password" name="password" class="form-control" id="yourPassword" required>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="login" type="submit">Đăng nhập</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Liên hệ quản trị viên cửa hàng nếu bạn cần khôi phục tài khoản.
                      </p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="loading-overlay d-none">
      <div class="spinner"></div>
    </div>
  </main><!-- End #main -->

</body>

</html>