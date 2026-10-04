@extends('User.partials.auth-layout')
@section('title', 'Đăng nhập')
@section('intro', 'Tiếp tục chăm sóc bé cùng PetCare.')
@section('auth-content')
<form id="formLoginn"><div class="mb-3"><label for="yourUsername" class="form-label">Email</label><input id="yourUsername" name="email" type="email" autocomplete="username" class="form-control" required ></div>
<div class="mb-3"><label for="yourPassword" class="form-label">Mật khẩu</label><div class="pc-password-field"><input id="yourPassword" name="password" type="password" autocomplete="current-password" class="form-control" required ><button type="button" class="pc-password-toggle" data-password-toggle="yourPassword" aria-controls="yourPassword" aria-pressed="false">Hiện</button></div></div>
<p class="pc-auth-feedback d-none" data-feedback role="status" aria-live="polite"></p><div class="text-end mb-3"><a href="{{ route('user.forgetPass') }}">Quên mật khẩu?</a></div><button type="submit" class="btn btn-primary w-100">Đăng nhập</button></form><p class="mt-4 mb-0">Chưa có tài khoản? <a href="{{ route('user.register') }}">Đăng ký</a></p>
@endsection
@section('auth-script')
@vite('resources/js/User/account/login.js')
@endsection
