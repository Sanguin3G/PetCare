import {request, feedback, passwordsMatch} from './auth';
const sendForm = document.getElementById('send-otp-form');
const resetForm = document.querySelector('.formResetPass');
let verifiedEmail;
sendForm.addEventListener('submit', async event => {
    event.preventDefault();
    if (!sendForm.reportValidity()) return;
    const email = sendForm.email.value.trim();
    const result = await request(sendForm, '/api/auth/user/account/forgetpass/request/sendOTP', {email}, 'Đang gửi mã…');
    if (!result) return;
    verifiedEmail = email;
    resetForm.hidden = false;
    feedback(sendForm, 'Đã gửi mã xác nhận. Kiểm tra hộp thư và thư rác.', true);
    document.getElementById('yourOTP').focus();
});
sendForm.email.addEventListener('input', () => { verifiedEmail = null; resetForm.hidden = true; feedback(sendForm, ''); });
resetForm.addEventListener('submit', async event => {
    event.preventDefault();
    if (!verifiedEmail || !passwordsMatch(resetForm)) return;
    const result = await request(resetForm, '/api/auth/user/account/forgetpass/request/resetPass', {email: verifiedEmail, OTP: resetForm.OTP.value.trim(), password: resetForm.password.value}, 'Đang đổi mật khẩu…');
    if (!result) return;
    feedback(resetForm, 'Đã đổi mật khẩu. Đang chuyển tới đăng nhập…', true);
    resetForm.querySelector('[type="submit"]').disabled = true;
    setTimeout(() => location.assign('/login'), 1000);
});
