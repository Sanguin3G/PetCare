const headers={Authorization:`Bearer ${localStorage.getItem('authTokenPassport')}`};
$(document).on('click','.btn-getdetail-order',async function() {
    if(this.disabled) return;
    const button=this; button.disabled=true;
    try {
        const html=await $.ajax({url:`/api/admin/order/detail/get/${button.dataset.id}`,headers});
        if(typeof html !== 'string') throw new Error('No detail');
        $('#main').html(html); document.getElementById('main').focus();
    } catch(error) { $.toast({heading:'Không thể tải Đơn hàng',text:'Vui lòng thử lại.',icon:'error',position:'bottom-right'}); }
    finally { button.disabled=false; }
});
$(document).on('click','.btn-delivery',async function() {
    if(this.disabled || !confirm('Xác nhận Đơn hàng đã được giao?')) return;
    const button=this; button.disabled=true;
    try {
        const response=await $.ajax({url:`/api/admin/order/delivery/${button.dataset.id}`,type:'PATCH',headers,data:{_token:$('meta[name="csrf-token"]').attr('content')}});
        if(response.status !== 'success') throw new Error('Update failed');
        $(button).closest('tr').find('.order-status').html('<span class="badge bg-success">Đã giao hàng</span>');
        button.remove();
        $.toast({heading:'Đã cập nhật',text:'Đơn hàng đã được giao.',icon:'success',position:'bottom-right'});
    } catch(error) { $.toast({heading:'Không thể cập nhật',text:error.responseJSON?.message || 'Vui lòng thử lại.',icon:'error',position:'bottom-right'}); }
    finally { button.disabled=false; }
});
