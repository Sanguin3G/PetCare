<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin-Đăng ký tài khoản</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Latest compiled JavaScript -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    {{-- toast message --}}
    <script src=" https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css" rel="stylesheet">
    <!-- Popper.js & Bootstrap JS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Popper.js & Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/Admin/account/RegistAccountAdmin.js')
</head>

<body>
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.php" style="text-decoration: none"
                                    class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('assets/img/PetCARE.png') }}" alt="">
                                    <span class="d-none d-lg-block">AdminPetcare</span>
                                </a>
                            </div><!-- End Logo -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Đăng ký tài khoản</h5>
                                        <p class="text-center small">Nhập các thông tin bên dưới để tạo tài khoản</p>
                                    </div>
                                    <form class="row g-3 needs-validation" id="FormRegisterAdmin" method="post">
                                        <div class="col-12">
                                            <p>Chọn kiểu tài khoản</p>
                                            <select class="form-select" name="role">
                                                <option value="admin">Quản trị</option>
                                                <option value="staff" selected>Nhân viên</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Họ tên</label>
                                            <input type="text" name="name" class="form-control" id="yourName" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="yourEmail"
                                                required>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPhone" class="form-label">Số điện thoại</label>
                                            <input type="text" name="yourPhone" class="form-control" id="yourPhone"
                                                required>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Mật khẩu</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourConfirmPassword" class="form-label">Nhập lại mật
                                                khẩu</label>
                                            <input type="password" name="passwordConfirm" class="form-control"
                                                id="yourConfirmPassword" required>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" id="FormRegisterAdminButton"
                                                type="button">Tạo
                                                tài khoản</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Nếu đã có tài khoản ? <a style="text-decoration: none"
                                                    href="{{ route('admin.login') }}">Đăng nhập</a></p>
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="loading-overlay d-none">
                    <div class="spinner"></div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>