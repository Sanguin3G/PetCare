@extends('User.partials.auth-layout')
@section('title', 'Khôi phục mật khẩu')
@section('intro', 'Nhận mã xác nhận qua email để đặt mật khẩu mới.')
@section('auth-content')
<form id="send-otp-form"><div class="mb-3"><label for="yourEmail" class="form-label">Email tài khoản</label><input id="yourEmail" name="email" type="email" autocomplete="email" class="form-control" required ></div>
<p class="pc-auth-feedback d-none" data-feedback role="status" aria-live="polite"></p><button type="submit" class="btn btn-primary w-100 mb-4" id="btn-send-OTP">Gửi mã khôi phục</button></form><form class="formResetPass" hidden><h2 class="h5">Đặt mật khẩu mới</h2><div class="mb-3"><label for="yourOTP" class="form-label">Mã xác nhận</label><input id="yourOTP" name="OTP" type="text" autocomplete="one-time-code" class="form-control" required inputmode="numeric"></div>
<div class="mb-3"><label for="yourPassword" class="form-label">Mật khẩu mới</label><div class="pc-password-field"><input id="yourPassword" name="password" type="password" autocomplete="new-password" class="form-control" required minlength="8" aria-describedby="password-hint"><button type="button" class="pc-password-toggle" data-password-toggle="yourPassword" aria-controls="yourPassword" aria-pressed="false">Hiện</button></div></div>
<p id="password-hint" class="small pc-auth-intro">Ít nhất 8 ký tự. Nên kết hợp chữ, số và ký hiệu.</p><div class="mb-3"><label for="yourConfirmPassword" class="form-label">Nhập lại mật khẩu</label><div class="pc-password-field"><input id="yourConfirmPassword" name="password_confirmation" type="password" autocomplete="new-password" class="form-control" required minlength="8"><button type="button" class="pc-password-toggle" data-password-toggle="yourConfirmPassword" aria-controls="yourConfirmPassword" aria-pressed="false">Hiện</button></div></div>
<p class="pc-auth-feedback d-none" data-feedback role="status" aria-live="polite"></p><button type="submit" id="Btn-reset-pass" class="btn btn-primary w-100">Đổi mật khẩu</button></form><p class="mt-4 mb-0"><a href="{{ route('user.login') }}">Trở lại đăng nhập</a></p>
@endsection
@section('auth-script')
@vite('resources/js/User/account/forgetpass.js')
@endsection
