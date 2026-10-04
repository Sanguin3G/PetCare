$('#buttonLogoutAdmin').on('click',async function() {
    if(this.disabled) return;
    const button=this; button.disabled=true;
    const csrf=$('meta[name="csrf-token"]').attr('content');
    try {
        const token=localStorage.getItem('authTokenPassport');
        if(token) {
            try { await $.ajax({url:'/api/admin/logout',type:'POST',headers:{Authorization:`Bearer ${token}`,'X-CSRF-TOKEN':csrf}}); }
            catch(error) { if(error.status !== 401 && error.status !== 403) throw error; }
        }
        await $.ajax({url:'/admin/session/clear',type:'POST',headers:{'X-CSRF-TOKEN':csrf}});
        localStorage.removeItem('authTokenPassport');
        window.location.replace('/admin/login');
    } catch(error) { $.toast({heading:'Không thể đăng xuất',text:'Vui lòng thử lại.',icon:'error',position:'bottom-right'}); }
    finally { button.disabled=false; }
});
