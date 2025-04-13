<!-- user infor -->
<div class="inforUserView" style="min-height: 500px">
    <div class="row g-3 align-items-center mx-auto ">
        <div class="col-3">
            <div class="card border-0 ">
                @if ($user->image != '')
                <img src="{{ asset('assets/img-avt-customer/' . Auth('customer')->$user->image) }}"
                    class="card-img-top rounded-circle w-50 mx-auto" alt="">
                @else
                <img src="{{ asset('assets/img/avatar-trang-99.jpg') }}"
                    class="card-img-top rounded-circle w-50 mx-auto" alt="">
                @endif
            </div>
        </div>
        <div class="col-6">
            <div class="container">
                <form id="formChange" method="post">
                    <h2 class="text-center" style="color:#EA9E1E">Đổi mật khẩu</h2>
                    <div>
                        <div class="row">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" placeholder="Nhập mật khẩu" id="currentPassword" name="currentPass"
                                class="form-control" required>
                        </div>
                        <div class="row">
                            <label class="form-label">Mật khẩu mới</label> <input id="yourPassword" class="form-control"
                                required type="password" name="newPass" placeholder="Nhập mật khẩu mới"
                                class="full-width">
                        </div>
                        <div class="row mt-2">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input id="yourConfirmPassword" class="form-control" type="password" required
                                name="confirmPass" class="full-width" placeholder="Nhập lại mật khẩu">
                        </div>
                        <div class="row mt-3 d-flex justify-content-center">
                            <button type="submit" id="submit" style="width:30%" name="submit"
                                class="btn btn-primary">Xác
                                nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@vite("resources/js/User/account/changepass.js")