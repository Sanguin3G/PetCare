import './search';
import './order/getOrder';
import './account/changepass';
import './account/profile';
import { CheckToken } from './checkToken';
import { TotalItemCart, renderCart } from './cart/cart';
export function LoadLayout() {
    const loggedIn = CheckToken();
    document.querySelectorAll('[data-login-prompt]').forEach(prompt => { prompt.hidden = loggedIn; });
    document.querySelector('#dropdown-user')?.classList.toggle('d-none', !loggedIn);
    document.querySelector('.buttonLogin')?.classList.toggle('d-none', loggedIn);
    document.querySelectorAll('.totalInCart').forEach(badge => { badge.textContent = TotalItemCart(); badge.classList.toggle('d-none', !TotalItemCart()); });
    if (document.querySelector('#ListProductInCart')) renderCart();
}
LoadLayout();
const accountContent = document.querySelector('[data-account-content]');
if (accountContent) {
    if (!CheckToken()) window.location.assign('/login?next=' + encodeURIComponent(location.pathname));
    else fetch(accountContent.dataset.accountContent, { headers: { Authorization: `Bearer ${localStorage.getItem('authTokenPassport_user')}`, Accept: 'text/html' } })
        .then(response => { if (!response.ok) throw new Error(); return response.text(); })
        .then(html => { accountContent.innerHTML = html; })
        .catch(() => { accountContent.textContent = 'Không thể tải tài khoản. Vui lòng tải lại trang hoặc đăng nhập lại.'; });
}
document.querySelector('.button-logout')?.addEventListener('click', async event => {
    const button = event.currentTarget; button.disabled = true;
    try {
        const response = await fetch('/api/user/account/logout', { method: 'POST', headers: { Authorization: `Bearer ${localStorage.getItem('authTokenPassport_user')}`, Accept: 'application/json' } });
        if (!response.ok && response.status !== 401) throw new Error();
        localStorage.removeItem('authTokenPassport_user'); localStorage.removeItem('authTokenPassport_user_expired_at'); localStorage.removeItem('Email_User'); window.location.assign('/');
    } catch { button.disabled = false; $.toast({ text: 'Không thể đăng xuất. Vui lòng thử lại.', icon: 'error', position: 'bottom-right' }); }
});
const topButton = document.querySelector('#pc-scroll-top');
window.addEventListener('scroll', () => topButton?.classList.toggle('is-visible', window.scrollY > 360), { passive: true });
topButton?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth' }));
