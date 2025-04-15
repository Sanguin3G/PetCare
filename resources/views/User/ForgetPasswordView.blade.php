<!DOCTYPE html>
<html lang="en">

<head>
    <me<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pet Care</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link rel="stylesheet" href="../css/user-responsive.css">
        <link rel="stylesheet" href="../css/user1.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
        {{-- toast message --}}
        <script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css" rel="stylesheet">
        @vite('resources/js/User/account/forgetpass.js')
</head>
</head>

<body>
    <div class="loading-overlay d-none">
        <div class="spinner-grow" role="status">
        </div>
        <span class="ms-3 mt-3">Loading ...</span>
    </div>
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
                        <h3 class="text-center">QUÊN MẬT KHẨU</h3>
                    </div>
                    <form>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Your Email" type="text" id="yourEmail">
                            <button class="input-group-text btn btn-primary" id="btn-send-OTP">Send OTP</button>
                        </div>
                    </form>
                    <form class="formResetPass">
                        <div class="form-group mb-3">
                            <input name="OTP" class="form-control form-control-lg bg-light fs-6" id="yourOTP"
                                placeholder="Nhập mã OTP">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6"
                                id="yourPassword" placeholder="Mật Khẩu mới">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password_confirmation"
                                class="form-control form-control-lg bg-light fs-6" id="yourConfirmPassword"
                                placeholder="Nhập lại mật khẩu">
                        </div>
                        <div class="input-group mb-3 d-flex justify-content-center">
                            <button class="btn btn-lg btn-warning w-50 fs-6" type="button" id="Btn-reset-pass">Đồng
                                ý</button>
                        </div>
                    </form>
                    <a style="text-decoration:none;color:blue;font-size: 1.3vw" class="me-2 ms-2 buttonLogin "
                        href="{{ route('user.login') }}">Đăng
                        Nhập</a>
                </div>
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