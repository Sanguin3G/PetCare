import '../../../css/commerce.css';
const storageKey = () => `cart_${localStorage.getItem('Email_User') || null}`;
function readCart() {
    try { return (JSON.parse(localStorage.getItem(storageKey())) || []).filter(item => item.idPro && Number(item.count) > 0); }
    catch { return []; }
}
let cart = readCart();
export const getCart = () => cart;
export function saveCart(items) {
    localStorage.setItem(storageKey(), JSON.stringify(items));
    cart = items;
    document.querySelectorAll('.totalInCart').forEach(el => { el.textContent = TotalItemCart(); el.classList.toggle('d-none', !cart.length); });
    window.dispatchEvent(new Event('petcare:cart-changed'));
}
export function Add(item) {
    try {
        const count = Math.max(1, Math.trunc(Number(item.count) || 1));
        const existing = cart.find(entry => entry.idPro === item.idPro);
        if (Number.isFinite(Number(item.maxCount)) && (Number(existing?.count || 0) + count) > Number(item.maxCount)) return false;
        const next = cart.map(entry => ({...entry}));
        const product = next.find(entry => entry.idPro === item.idPro);
        if (product) Object.assign(product, item, {count: Number(product.count) + count});
        else next.push({...item, count});
        saveCart(next); return true;
    } catch { return false; }
}
export function Del(id) { try { saveCart(cart.filter(item => item.idPro !== id)); return true; } catch { return false; } }
export function DestroyCart() { try { saveCart([]); return true; } catch { return false; } }
function setQuantity(id, count) {
    const item = cart.find(item => item.idPro === id);
    if (!item) return false;
    const max = Number.isFinite(Number(item.maxCount)) ? Number(item.maxCount) : 999;
    item.count = Math.max(1, Math.min(Math.max(1, max), Math.trunc(Number(count) || 1)));
    saveCart(cart); return item.count;
}
export const Increase = (id, number) => setQuantity(id, Number(cart.find(item => item.idPro === id)?.count || 1) + number);
export const Decrease = (id, number) => Increase(id, -number);
export const TotalItemCart = () => cart.length;
const money = value => new Intl.NumberFormat('vi-VN', {style:'currency', currency:'VND'}).format(value);
const unitPrice = item => Math.round(Number(item.cost) * (1 - Math.min(100, Math.max(0, Number(item.discount) || 0)) / 100));
export const CalculateCostOfProduct = id => { const item = cart.find(item => item.idPro === id); return item ? unitPrice(item) * item.count : 0; };
export const TotalCostInCart = () => money(cart.reduce((sum, item) => sum + unitPrice(item) * item.count, 0));
const escape = value => String(value ?? '').replace(/[&<>"']/g, character => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[character]));
let submitting = false;
export function renderCart() {
    const list = document.getElementById('ListProductInCart');
    if (!list) return;
    list.innerHTML = cart.map(item => `<article class="pc-cart-row">
        <img src="${escape(item.image || '/assets/img-add-pro/11744768508.webp')}" alt="${escape(item.name)}" loading="lazy">
        <div class="pc-cart-product"><h2><a href="/product/detail/${encodeURIComponent(item.idPro)}/${encodeURIComponent(item.name)}">${escape(item.name)}</a></h2><p>${money(unitPrice(item))} / sản phẩm${item.maxCount === 0 ? ' · Hết hàng' : ''}</p></div>
        <div class="pc-quantity"><button type="button" data-quantity="-1" data-id="${escape(item.idPro)}" aria-label="Giảm số lượng ${escape(item.name)}" ${item.count <= 1 ? 'disabled' : ''}>−</button><input type="number" min="1" max="${escape(item.maxCount || 999)}" value="${item.count}" data-cart-quantity="${escape(item.idPro)}" aria-label="Số lượng ${escape(item.name)}"><button type="button" data-quantity="1" data-id="${escape(item.idPro)}" aria-label="Tăng số lượng ${escape(item.name)}" ${item.maxCount != null && item.count >= item.maxCount ? 'disabled' : ''}>+</button></div>
        <strong class="pc-line-total">${money(unitPrice(item) * item.count)}</strong><button type="button" class="pc-remove-item" data-remove="${escape(item.idPro)}" aria-label="Xóa ${escape(item.name)}">×</button></article>`).join('');
    document.getElementById('countItemInCart').textContent = `${cart.length} sản phẩm`;
    document.getElementById('cart-empty').hidden = !!cart.length;
    document.querySelectorAll('[data-cart-filled]').forEach(el => el.hidden = !cart.length);
    document.querySelectorAll('[data-cart-total]').forEach(el => el.textContent = TotalCostInCart());
}
function showFeedback(message) {
    const feedback = document.getElementById('checkout-feedback');
    if (feedback) { feedback.textContent = message; feedback.hidden = false; }
}
document.addEventListener('click', event => {
    const quantity = event.target.closest('[data-quantity]');
    if (quantity && !submitting) { Increase(quantity.dataset.id, Number(quantity.dataset.quantity)); renderCart(); }
    const remove = event.target.closest('[data-remove]');
    if (remove && !submitting && window.confirm('Xóa sản phẩm này khỏi giỏ hàng?')) { Del(remove.dataset.remove); renderCart(); }
});
document.addEventListener('change', event => {
    if (event.target.matches('[data-cart-quantity]') && !submitting) { setQuantity(event.target.dataset.cartQuantity, event.target.value); renderCart(); }
});
document.addEventListener('submit', async event => {
    const form = event.target.closest('.form-checkout-cart');
    if (!form) return;
    event.preventDefault();
    if (submitting || !cart.length) return;
    if (cart.some(item => item.maxCount != null && item.count > Number(item.maxCount))) {
        showFeedback('Vui lòng cập nhật sản phẩm không còn đủ số lượng trong giỏ hàng.'); return;
    }
    const token = localStorage.getItem('authTokenPassport_user');
    if (!token) { showFeedback('Vui lòng đăng nhập để đặt hàng. Giỏ hàng của bạn vẫn được giữ lại.'); return; }
    submitting = true;
    const submit = form.querySelector('[type=submit]');
    submit.disabled = true; submit.textContent = 'Đang đặt hàng…';
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.getElementById('checkout-feedback').hidden = true;
    try {
        const values = new FormData(form);
        const response = await fetch('/api/user/cart/checkout', {method:'POST', headers:{'Content-Type':'application/json', Accept:'application/json', Authorization:`Bearer ${token}`}, body:JSON.stringify({Name:values.get('Name'), Phone:values.get('Phone'), Address:values.get('Address'), Note:values.get('Note'), Method_Payment:'cod', Cart:cart.map(item => ({idPro:String(item.idPro), count:Number(item.count)}))})});
        const data = await response.json();
        if (!response.ok) {
            Object.keys(data.errors || {}).forEach(name => form.elements.namedItem(name)?.classList.add('is-invalid'));
            throw new Error(response.status === 401 ? 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.' : Object.values(data.errors || {}).flat().join(' ') || data.message || 'Không thể đặt hàng. Vui lòng thử lại.');
        }
        DestroyCart(); renderCart(); form.reset();
        const success = document.getElementById('checkout-success');
        success.hidden = false; success.querySelector('[data-order-id]').textContent = data.data.id;
        success.focus();
    } catch (error) { showFeedback(error.message || 'Không thể kết nối. Vui lòng thử lại.'); }
    finally { submitting = false; submit.disabled = false; submit.textContent = 'Đặt hàng · Thanh toán khi nhận'; }
});
renderCart();
async function refreshCart() {
    if (!document.getElementById('ListProductInCart') || !cart.length) return;
    const token = localStorage.getItem('authTokenPassport_user');
    if (!token) return;
    try {
        const response = await fetch('/api/user/cart/quote', {method:'POST', headers:{'Content-Type':'application/json', Accept:'application/json', Authorization:`Bearer ${token}`}, body:JSON.stringify({ids:cart.map(item => String(item.idPro))})});
        if (!response.ok) return;
        const {data} = await response.json();
        // Preserve the user's quantity so unavailable items can be corrected explicitly.
        saveCart(cart.map(item => ({...item, ...(data.find(product => product.idPro === item.idPro) || {maxCount:0})})));
        renderCart();
        if (cart.some(item => item.maxCount < item.count)) showFeedback('Một số sản phẩm không còn đủ số lượng. Vui lòng giảm số lượng hoặc xóa sản phẩm trước khi đặt hàng.');
    } catch { /* The authoritative checkout still validates stock if the quote is unavailable. */ }
}
refreshCart();
