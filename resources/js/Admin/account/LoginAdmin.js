const form=document.querySelector('.formLogin');
const button=form.querySelector('[type="submit"]');
const csrf=document.querySelector('meta[name="csrf-token"]').content;
let busy=false;
function showError(message) { $.toast({heading:'Không thể đăng nhập',text:message,icon:'error',position:'bottom-right'}); }
async function connectSession(token) {
    await $.ajax({url:'/admin/session',type:'POST',headers:{Authorization:`Bearer ${token}`,'X-CSRF-TOKEN':csrf}});
}
form.addEventListener('submit',async event => {
    event.preventDefault(); if(busy || !form.reportValidity()) return;
    busy=true; button.disabled=true; button.textContent='Đang đăng nhập…';
    try {
        const response=await $.ajax({url:'/api/auth/admin/login',type:'POST',data:{email:$('#yourUsername').val().trim(),password:$('#yourPassword').val(),_token:csrf}});
        if(response.status !== 'success' || typeof response.data !== 'string') throw {responseJSON:response};
        // Preserve existing API authentication; the cookie authenticates native admin pages.
        await connectSession(response.data);
        localStorage.setItem('authTokenPassport',response.data);
        window.location.replace('/admin');
    } catch(error) { showError(error.responseJSON?.message || 'Vui lòng thử lại.'); }
    finally { busy=false; button.disabled=false; button.textContent='Đăng nhập'; }
});
// Existing valid logins can reconnect after their browser-session cookie expires.
const stored=localStorage.getItem('authTokenPassport');
if(stored) {
    busy=true; button.disabled=true;
    connectSession(stored).then(() => window.location.replace('/admin')).catch(error => {
        if(error.status === 401 || error.status === 403) localStorage.removeItem('authTokenPassport');
        else showError('Không thể khôi phục phiên đăng nhập. Vui lòng thử lại.');
    }).finally(() => { busy=false; button.disabled=false; });
}
