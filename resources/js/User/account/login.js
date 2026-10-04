import {request, feedback} from './auth';
const form = document.getElementById('formLoginn');
form.addEventListener('submit', async event => {
    event.preventDefault();
    if (!form.reportValidity()) return;
    const email = form.email.value.trim();
    const result = await request(form, '/api/auth/user/login', {email, password: form.password.value}, 'Đang đăng nhập…');
    if (!result) return;
    if (typeof result.data !== 'string' || !result.data) { feedback(form, 'Không thể đăng nhập. Vui lòng thử lại.'); return; }
    try {
        localStorage.setItem('authTokenPassport_user', result.data);
        localStorage.setItem('authTokenPassport_user_expired_at', Date.now() + 15 * 24 * 60 * 60 * 1000);
        localStorage.setItem('Email_User', email);
    } catch { feedback(form, 'Cho phép lưu trữ trình duyệt để đăng nhập.'); return; }
    const next = new URLSearchParams(location.search).get('next');
    let destination = '/';
    if (next?.startsWith('/') && !next.startsWith('//')) {
        try { const url = new URL(next, location.origin); if (url.origin === location.origin) destination = url.pathname + url.search + url.hash; } catch {}
    }
    location.assign(destination);
});
