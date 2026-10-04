@extends('User.partials.auth-layout')
@section('title', 'Khôi phục mật khẩu')
@section('intro', 'Dùng mã xác nhận qua email để đặt mật khẩu mới.')
@section('auth-content')
<a class="btn btn-primary w-100" href="{{ route('user.forgetPass') }}">Gửi mã khôi phục</a>
@endsection
