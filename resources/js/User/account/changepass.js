document.addEventListener('submit', async event => {
    if (event.target.id !== 'formChange') return;
    event.preventDefault(); const form = event.target;
    if (form.dataset.busy) return;
    const password = form.querySelector('#yourPassword'); const confirm = form.querySelector('#yourConfirmPassword');
    const feedback = form.querySelector('#password-feedback');
    if (password.value !== confirm.value) { feedback.textContent = 'Mật khẩu xác nhận chưa khớp.'; confirm.focus(); return; }
    const button = form.querySelector('[type="submit"]'); form.dataset.busy = 'true'; button.disabled = true; button.textContent = 'Đang lưu…'; feedback.textContent = '';
    try {
        const response = await fetch('/api/user/account/changepass', { method: 'PATCH', headers: { Accept: 'application/json', 'Content-Type': 'application/json', Authorization: `Bearer ${localStorage.getItem('authTokenPassport_user')}` }, body: JSON.stringify({ old_password: form.querySelector('#currentPassword').value, new_password: password.value }) });
        const data = await response.json();
        if (!response.ok || data.status !== 'success') throw new Error(response.status === 400 ? 'Mật khẩu hiện tại chưa đúng hoặc mật khẩu mới không hợp lệ.' : 'Không thể cập nhật mật khẩu. Vui lòng thử lại.');
        form.reset(); feedback.textContent = 'Đã cập nhật mật khẩu.';
    } catch (error) { feedback.textContent = error.message || 'Không thể kết nối. Vui lòng thử lại.'; }
    finally { delete form.dataset.busy; button.disabled = false; button.textContent = 'Lưu mật khẩu'; }
});
