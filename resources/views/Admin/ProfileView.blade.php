@extends('Admin.Layout')
@section('content')
<div class="pagetitle"><h1>Tài khoản quản trị</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Tổng quan</a></li><li class="breadcrumb-item active" aria-current="page">Tài khoản</li></ol></nav></div>
<div class="row g-4">
    <div class="col-lg-7"><section class="card h-100"><div class="card-body p-4">
        <h2 class="h5 mb-2">Thông tin tài khoản</h2><p class="text-muted mb-4">Cập nhật tên và email dùng cho công việc tại PetCare.</p>
        <form id="FormUpdateInforAdmin"><fieldset disabled id="admin-profile-fields">
            <div class="mb-3"><label for="name">Họ và tên</label><input class="form-control" id="name" name="name" required maxlength="255" autocomplete="name"><div class="invalid-feedback" data-error-for="name"></div></div>
            <div class="mb-4"><label for="email">Email</label><input class="form-control" id="email" name="email" type="email" required maxlength="255" autocomplete="email"><div class="invalid-feedback" data-error-for="email"></div></div>
            <div class="alert d-none" data-form-feedback role="status" aria-live="polite"></div><button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </fieldset></form>
    </div></section></div>
    <div class="col-lg-5"><section class="card h-100"><div class="card-body p-4">
        <h2 class="h5 mb-2">Đổi mật khẩu</h2><p class="text-muted mb-4">Sử dụng mật khẩu mới có ít nhất 8 ký tự.</p>
        <form id="FormUpdatePassWordAdmin">
            <div class="mb-3"><label for="old_password">Mật khẩu hiện tại</label><input class="form-control" id="old_password" name="old_password" type="password" required autocomplete="current-password"><div class="invalid-feedback" data-error-for="old_password"></div></div>
            <div class="mb-3"><label for="new_password">Mật khẩu mới</label><input class="form-control" id="new_password" name="new_password" type="password" required minlength="8" maxlength="255" autocomplete="new-password"><div class="invalid-feedback" data-error-for="new_password"></div></div>
            <div class="mb-4"><label for="new_password_confirmation">Nhập lại mật khẩu mới</label><input class="form-control" id="new_password_confirmation" name="new_password_confirmation" type="password" required minlength="8" maxlength="255" autocomplete="new-password"><div class="invalid-feedback" data-error-for="new_password_confirmation"></div></div>
            <div class="alert d-none" data-form-feedback role="status" aria-live="polite"></div><button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
        </form>
    </div></section></div>
</div>
@vite('resources/js/Admin/account/updateInfor.js')
@endsection
