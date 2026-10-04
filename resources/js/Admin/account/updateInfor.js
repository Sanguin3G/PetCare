const headers={Authorization:`Bearer ${localStorage.getItem('authTokenPassport')}`,'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content};
const profile=document.getElementById('FormUpdateInforAdmin');
function feedback(form,message,success=false) {
    const box=form.querySelector('[data-form-feedback]'); box.className=`alert ${success ? 'alert-success' : 'alert-danger'}`; box.textContent=message;
}
$.ajax({url:'/api/admin/profile',headers}).done(response => {
    if(!response.data) { feedback(profile,'Không thể tải thông tin tài khoản. Vui lòng tải lại trang.'); return; }
    profile.elements.name.value=response.data.name; profile.elements.email.value=response.data.email;
    document.getElementById('admin-profile-fields').disabled=false;
}).fail(() => {
    document.getElementById('admin-profile-fields').disabled=false;
    feedback(profile,'Không thể tải thông tin tài khoản. Vui lòng tải lại trang trước khi lưu.');
    profile.querySelector('[type="submit"]').disabled=true;
});
function attachForm(form,url,onSuccess) {
    form.addEventListener('submit',async event => {
        event.preventDefault(); const button=form.querySelector('[type="submit"]');
        if(button.disabled || !form.reportValidity()) return;
        form.querySelectorAll('.is-invalid').forEach(input=>input.classList.remove('is-invalid'));
        form.querySelector('[data-form-feedback]').className='alert d-none';
        if(form.elements.new_password && form.elements.new_password.value !== form.elements.new_password_confirmation.value) {
            const input=form.elements.new_password_confirmation; input.classList.add('is-invalid'); form.querySelector('[data-error-for="new_password_confirmation"]').textContent='Mật khẩu nhập lại chưa khớp.'; input.focus(); return;
        }
        const label=button.textContent; button.disabled=true; button.textContent='Đang lưu…';
        const data=Object.fromEntries(new FormData(form)); if(data.name) data.name=data.name.trim(); if(data.email) data.email=data.email.trim();
        try {
            const response=await $.ajax({url,type:'PATCH',headers,data});
            if(response.status !== 'success') throw {responseJSON:response};
            onSuccess(); feedback(form,'Đã lưu thay đổi.',true);
        } catch(error) {
            const result=error.responseJSON;
            Object.entries(result?.errors || {}).forEach(([name,messages]) => {
                const input=form.elements[name], message=form.querySelector(`[data-error-for="${name}"]`);
                if(input && message) { input.classList.add('is-invalid'); message.textContent=messages[0]; }
            });
            feedback(form,result?.message || 'Không thể lưu thay đổi. Vui lòng thử lại.');
            form.querySelector('.is-invalid')?.focus();
        } finally { button.disabled=false; button.textContent=label; }
    });
}
attachForm(profile,'/api/admin/profile',()=>$('#NameUser').text(profile.elements.name.value));
const password=document.getElementById('FormUpdatePassWordAdmin');
attachForm(password,'/api/admin/account/changepass',()=>password.reset());
