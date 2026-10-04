import { Delete } from '../../util';
$('#table-product').on('click','.button-delete-product',async function() {
    if(this.disabled || !confirm('Xác nhận xóa sản phẩm này?')) return;
    const button=this; button.disabled=true;
    try {
        const response=await Delete('product/delete',{idPro:button.dataset.id,_token:$('meta[name="csrf-token"]').attr('content')});
        if(response.status === 'success') { $(button).closest('tr').remove(); if(!document.querySelector('#table-product tr')) $('#table-product').html('<tr><td colspan="9" class="text-center py-5">Chưa có sản phẩm.</td></tr>'); }
        $.toast({heading:'Thông báo',text:response.message,icon:response.status === 'success' ? 'success' : 'error',position:'bottom-right'});
    } catch(error) { $.toast({heading:'Không thể xóa',text:error.responseJSON?.message || 'Vui lòng thử lại.',icon:'error',position:'bottom-right'}); }
    finally { button.disabled=false; }
});
