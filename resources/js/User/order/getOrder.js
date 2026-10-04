import '../../../css/commerce.css';
document.addEventListener('click', async event => {
    const button = event.target.closest('[data-cancel-order]');
    if (!button || button.disabled) return;
    if (!window.confirm('Hủy đơn hàng này? Sản phẩm sẽ được hoàn lại vào kho.')) return;
    const page = button.closest('[data-order-page]');
    const feedback = page.querySelector('[data-order-feedback]');
    feedback.hidden = true;
    button.disabled = true; button.textContent = 'Đang hủy…';
    try {
        const response = await fetch(`/api/user/order/${encodeURIComponent(button.dataset.cancelOrder)}/cancel`, {method:'PATCH', headers:{Accept:'application/json', Authorization:`Bearer ${localStorage.getItem('authTokenPassport_user')}`}});
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Không thể hủy đơn. Vui lòng thử lại.');
        button.closest('[data-order-id]').querySelector('[data-order-status]').textContent = 'Đã hủy';
        button.remove();
        feedback.className = 'alert alert-success'; feedback.textContent = data.message; feedback.hidden = false;
    } catch (error) {
        feedback.className = 'alert alert-danger'; feedback.textContent = error.message || 'Không thể kết nối. Vui lòng thử lại.'; feedback.hidden = false;
        button.disabled = false; button.textContent = 'Hủy đơn hàng';
    }
});
