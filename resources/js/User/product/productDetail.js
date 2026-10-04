import { CheckToken } from '../checkToken';
import { Add, TotalItemCart, getCart } from '../cart/cart';
const input = document.querySelector('#countToAdd');
const button = document.querySelector('#buttonAddToCart');
const feedback = document.querySelector('#purchase-feedback');
const stock = Number(button?.dataset.stock || 0);
const clamp = () => { input.value = Math.min(Math.max(1, Math.trunc(Number(input.value) || 1)), Math.max(1, stock)); };
input?.addEventListener('change', clamp);
document.querySelector('#buttonDown')?.addEventListener('click', () => { input.value = Number(input.value) - 1; clamp(); });
document.querySelector('#buttonUp')?.addEventListener('click', () => { input.value = Number(input.value) + 1; clamp(); });
document.querySelectorAll('[data-image]').forEach(thumbnail => thumbnail.addEventListener('click', () => {
    document.querySelector('.main-img-product').src = thumbnail.dataset.image;
    document.querySelector('.pc-lightbox-image').src = thumbnail.dataset.image;
    document.querySelectorAll('[data-image]').forEach(item => { item.classList.toggle('active', item === thumbnail); item.setAttribute('aria-pressed', String(item === thumbnail)); });
}));
document.querySelector('#product-purchase-form')?.addEventListener('submit', event => {
    event.preventDefault(); clamp();
    if (!CheckToken()) { window.location.assign('/login?next=' + encodeURIComponent(location.pathname)); return; }
    const count = Number(input.value);
    const existing = getCart().find(item => item.idPro === button.dataset.id);
    if ((existing?.count || 0) + count > stock) { feedback.textContent = 'Số lượng trong giỏ vượt quá hàng khả dụng.'; return; }
    const success = Add({ idPro: button.dataset.id, name: button.dataset.name, cost: Number(button.dataset.cost), discount: Number(button.dataset.discount), count, image: button.dataset.image, maxCount: stock });
    feedback.textContent = success ? 'Đã thêm vào giỏ hàng.' : 'Không thể lưu giỏ hàng. Vui lòng thử lại.';
    document.querySelectorAll('.totalInCart').forEach(badge => { badge.textContent = TotalItemCart(); badge.classList.toggle('d-none', !TotalItemCart()); });
});
