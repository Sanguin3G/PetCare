import {request, feedback, passwordsMatch} from './auth';
const form = document.getElementById('loginForm');
const otpForm = document.getElementById('otp-form');
const modalElement = document.getElementById('OTP');
const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
let account;
form.addEventListener('submit', async event => {
    event.preventDefault();
    if (!passwordsMatch(form)) return;
    const data = {role: 'user', name: form.elements.namedItem('name').value.trim(), email: form.email.value.trim(), phone: form.phone.value.trim(), password: form.password.value, passwordConfirm: form.password_confirmation.value};
    const result = await request(form, '/api/auth/user/register/sendOTP', data, 'Đang gửi mã…');
    if (!result) return;
    account = data;
    otpForm.reset();
    feedback(otpForm, '');
    document.getElementById('otp-email').textContent = account.email;
    modal.show();
});
modalElement.addEventListener('shown.bs.modal', () => document.getElementById('yourOTP').focus());
otpForm.addEventListener('submit', async event => {
    event.preventDefault();
    if (!account || !otpForm.reportValidity()) return;
    const result = await request(otpForm, '/api/auth/user/register', {...account, OTP: otpForm.OTP.value.trim()}, 'Đang xác nhận…');
    if (!result) return;
    feedback(otpForm, 'Tài khoản đã sẵn sàng. Đang chuyển tới đăng nhập…', true);
    otpForm.querySelector('[type="submit"]').disabled = true;
    account = null;
    setTimeout(() => location.assign('/login'), 1000);
});
