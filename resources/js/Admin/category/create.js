$('#formCreateCategory').on('submit',async function(event) {
    event.preventDefault();
    const button=this.querySelector('[type="submit"]'); if(button.disabled || !this.reportValidity()) return;
    const name=$('#nameCategory').val().trim(); if(!name) return;
    button.disabled=true;
    try {
        const response=await $.ajax({url:'/api/admin/category/create',type:'POST',headers:{Authorization:`Bearer ${localStorage.getItem('authTokenPassport')}`},data:{name,_token:$('meta[name="csrf-token"]').attr('content')}});
        if(response.status !== 'success') throw {responseJSON:response};
        // Reload the canonical paginated rows so new categories have the same edit controls.
        window.location.reload();
    } catch(error) { $.toast({heading:'Không thể tạo danh mục',text:error.responseJSON?.message || 'Vui lòng thử lại.',icon:'error',position:'bottom-right'}); }
    finally { button.disabled=false; }
});
