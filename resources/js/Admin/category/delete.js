import { Delete } from '../../util';
$('#table-category').on('click','.buttonDeleteCategory',async function() {
    if(this.disabled || !confirm('Xác nhận xóa danh mục này?')) return;
    const button=this; button.disabled=true;
    try {
        const response=await Delete('category/delete',{idCat:button.dataset.id,_token:$('meta[name="csrf-token"]').attr('content')});
        if(response.status === 'success') { $(button).closest('tr').remove(); if(!document.querySelector('#table-category tr')) $('#table-category').html('<tr><td colspan="9" class="text-center py-5">Chưa có danh mục.</td></tr>'); }
        $.toast({heading:'Thông báo',text:response.message,icon:response.status === 'success' ? 'success' : 'error',position:'bottom-right'});
    } catch(error) { $.toast({heading:'Không thể xóa',text:error.responseJSON?.message || 'Vui lòng thử lại.',icon:'error',position:'bottom-right'}); }
    finally { button.disabled=false; }
});
