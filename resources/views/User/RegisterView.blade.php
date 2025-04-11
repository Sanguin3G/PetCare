<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Care</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/user-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user1.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- toast message --}}
    <script src="
                                        https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js
                                        "></script>
    <link href="
        https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css
        "
        rel="stylesheet">
    @vite('resources/js/user/account/create.js')
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background:  #FFE4DA;">
                <div class="featured-image mb-3">
                    <img src="{{ asset('assets/img/PetCARE.png') }}" class="img-fluid mt-3" style="width:100%">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center text-center">
                    <div class="header-text mb-4">
                        <h3 style="font-family: 'Courier New', Courier, monospace;font-weight: 600;">Đăng Ký</h3>
                    </div>
                    <form id="loginForm" method="post">
                        <div class="form-group mb-3">
                            <input type="username" name="name" class="form-control form-control-lg bg-light fs-6"
                                id="yourName" placeholder="Tên người dùng">
                        </div>
                        <div class="form-group mb-3">
                            <input name="email" class="form-control form-control-lg bg-light fs-6" id="yourEmail"
                                placeholder="Địa chỉ Email">
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" name="phone" class="form-control form-control-lg bg-light fs-6"
                                id="yourPhone" placeholder="Số điện thoại">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6"
                                id="yourPassword" placeholder="Mật Khẩu">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password_confirmation"
                                class="form-control form-control-lg bg-light fs-6" id="yourConfirmPassword"
                                placeholder="Nhập lại mật khẩu">
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-warning w-100 fs-6" type="submit" name="dangky"
                                id="FormRegisterUserButton">Đăng Ký</button>
                        </div>
                    </form>
                    <!-- Modal OTP -->
                    <div class="modal fade" id="OTP" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="yourOTP" class="form-label">Mã OTP</label>
                                    <input style="border: 1px solid black" type="text" name="yourOTP"
                                        class="form-control" id="yourOTP" required>
                                    <i>Vui lòng kiểm tra Gmail và nhập mã OTP</i>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="submitOTP" class="btn btn-primary">Đồng
                                        ý</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <small>Bạn đã có tài khoản? <a href="{{ route('user.login') }}">Đăng Nhập</a></small>
                    </div>
                    <div class="loading-overlay d-none">
                        <div class="spinner"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>

</html>
