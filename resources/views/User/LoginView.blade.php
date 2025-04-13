<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Care</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/user-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user1.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script> --}}
    {{-- toast message --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css" rel="stylesheet">
    @vite('resources/js/User/account/login.js')
</head>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #FFE4DA;">
                <div class="featured-image mb-3">
                    <img src="{{ asset('assets/img/PetCARE.png') }}" class="img-fluid mt-3" style="width:100%">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h3 class="text-center" style="font-weight: 600;">Đăng Nhập</h3>
                    </div>
                    <form id="formLoginn" method="post">
                        <div class="form-group mb-3">
                            <input type="email" class="form-control form-control-lg bg-light fs-6" id="yourUsername"
                                name="email" placeholder="Nhập Email của bạn" required>
                        </div>
                        <div class="form-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" name="password"
                                id="yourPassword" placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Nhớ tài
                                        khoản!</small></label>
                            </div>
                            <div class="forgot">
                                <small><a style="text-decoration:none" href="{{ route('user.forgetPass') }}">Quên Mật
                                        Khẩu?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-warning w-100 fs-6 buttonLogin" type="button">Đăng
                                Nhập</button>
                        </div>
                    </form>
                    <div class="input-group mb-3 align-items-center d-flex justify-content-center">
                        <img src="{{ asset('assets/img/google_logo-google_icongoogle-512.webp') }}"
                            class="img-fluid me-3" style="width:5%;height:5%">
                        <a style="text-decoration: none;color:black" href="#">Đăng nhập bằng
                            Google</a>
                    </div>

                    <div class="row">
                        <small>Bạn chưa có tài khoản? <a style="text-decoration:none"
                                href="{{ route('user.register') }}">Đăng Ký</a></small>
                    </div>

                </div>
            </div>
            <div class="loading-overlay d-none">
                <div class="spinner"></div>
            </div>
        </div>
    </div>
</body>
<style>
    /* Nền tối che toàn màn hình */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: white;
        font-size: 18px;
        z-index: 9999;
    }

    /* Hiệu ứng spinner */
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(255, 255, 255, 0.3);
        border-top: 5px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
</style>

</html>