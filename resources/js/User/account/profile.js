import '../../../css/account-profile.css';
import { CheckToken } from '../checkToken';

const form=document.getElementById('customer-profile-form');
if(form) {
    const page=form.closest('.pc-customer-profile');
    const loading=page.querySelector('[data-profile-loading]');
    const failure=page.querySelector('[data-profile-failure]');
    const headers=() => ({ Authorization:`Bearer ${localStorage.getItem('authTokenPassport_user')}`, Accept:'application/json', 'Content-Type':'application/json' });
    const login=() => window.location.assign('/login?next=%2Faccount');
    async function load() {
        if(!CheckToken()) { login(); return; }
        loading.hidden=false; failure.hidden=true; form.hidden=true;
        try {
            const response=await fetch('/api/user/account/profile',{headers:headers()});
            if(response.status === 401) { login(); return; }
            const result=await response.json();
            if(!response.ok || !result.data) throw new Error();
            form.elements.name.value=result.data.name;
            form.elements.email.value=result.data.email;
            form.hidden=false;
        } catch { failure.hidden=false; }
        finally { loading.hidden=true; }
    }
    page.querySelector('[data-profile-retry]').addEventListener('click',load);
    load();
    document.addEventListener('submit',async event => {
        if(event.target !== form) return;
        event.preventDefault();
        const button=form.querySelector('[type="submit"]');
        if(button.disabled || !form.reportValidity()) return;
        const feedback=form.querySelector('[data-profile-feedback]');
        feedback.textContent='';
        form.querySelectorAll('.is-invalid').forEach(input=> { input.classList.remove('is-invalid'); input.removeAttribute('aria-invalid'); });
        button.disabled=true; button.textContent='Đang lưu…';
        try {
            const values={name:form.elements.name.value.trim(),email:form.elements.email.value.trim()};
            const response=await fetch('/api/user/account/profile',{method:'PATCH',headers:headers(),body:JSON.stringify(values)});
            if(response.status === 401) { login(); return; }
            const result=await response.json();
            if(!response.ok || result.status !== 'success') {
                Object.entries(result.errors || {}).forEach(([name,messages]) => {
                    const input=form.elements[name], error=form.querySelector(`[data-profile-error="${name}"]`);
                    if(input && error) { input.classList.add('is-invalid'); input.setAttribute('aria-invalid','true'); error.textContent=messages[0]; }
                });
                throw new Error(result.message || 'Không thể lưu thông tin. Vui lòng thử lại.');
            }
            localStorage.setItem('Email_User',values.email);
            form.elements.name.value=values.name; form.elements.email.value=values.email;
            feedback.dataset.state='success'; feedback.textContent='Đã cập nhật thông tin tài khoản.';
        } catch(error) {
            feedback.dataset.state='error'; feedback.textContent=error.message || 'Không thể lưu thông tin. Vui lòng thử lại.';
            form.querySelector('.is-invalid')?.focus();
        } finally { button.disabled=false; button.textContent='Lưu thông tin'; }
    });
}
