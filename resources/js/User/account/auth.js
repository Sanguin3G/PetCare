import '../../../css/auth-polish.css';
export function feedback(form, message, success = false) {
    const target = form.querySelector('[data-feedback]');
    target.textContent = message;
    target.classList.toggle('d-none', !message);
    target.classList.toggle('is-success', success);
}
export async function request(form, url, data, busyText = 'Đang xử lý…') {
    if (form.dataset.busy) return null;
    const button = form.querySelector('[type="submit"]');
    const label = button.textContent;
    form.dataset.busy = 'true';
    form.setAttribute('aria-busy', 'true');
    button.disabled = true;
    button.textContent = busyText;
    feedback(form, '');
    try {
        const response = await fetch(url, {method: 'POST', headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, body: JSON.stringify(data)});
        const result = await response.json();
        if (!response.ok || result.status !== 'success') {
            const errors = result.errors ? Object.values(result.errors).flat().join(' ') : '';
            throw new Error(errors || result.message || 'Không thể thực hiện. Vui lòng thử lại.');
        }
        return result;
    } catch (error) {
        feedback(form, error.message === 'Failed to fetch' ? 'Không thể kết nối. Kiểm tra mạng và thử lại.' : error.message);
        return null;
    } finally {
        delete form.dataset.busy;
        form.removeAttribute('aria-busy');
        button.disabled = false;
        button.textContent = label;
    }
}
export function passwordsMatch(form) {
    const password = form.querySelector('[name="password"]');
    const confirmation = form.querySelector('[name="password_confirmation"]');
    confirmation.setCustomValidity(confirmation.value === password.value ? '' : 'Mật khẩu nhập lại chưa khớp.');
    return form.reportValidity();
}
document.querySelectorAll('[name="password_confirmation"]').forEach(input => input.addEventListener('input', () => input.setCustomValidity('')));
document.querySelectorAll('[data-password-toggle]').forEach(button => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.passwordToggle);
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.textContent = show ? 'Ẩn' : 'Hiện';
        button.setAttribute('aria-pressed', String(show));
    });
});
