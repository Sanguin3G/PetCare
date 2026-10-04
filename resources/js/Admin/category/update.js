import { Update } from '../../util';
$('#table-category').on('click','.buttonUpdateCategory',async function(event) {
    event.preventDefault(); if(this.disabled) return;
    const button=this, id=button.dataset.id, input=document.getElementById(`nameCatUpdate${id}`);
    const name=input.value.trim(); if(!name) { input.focus(); input.classList.add('is-invalid'); return; }
    input.classList.remove('is-invalid'); button.disabled=true;
    try {
        const response=await Update('category/update',{idCat:id,name,_token:$('meta[name="csrf-token"]').attr('content')});
        if(response.status !== 'success') throw {responseJSON:response};
        $(button).closest('tr').children('td').eq(1).text(name);
        bootstrap.Modal.getInstance(button.closest('.modal'))?.hide();
        $.toast({heading:'Đã lưu',text:response.message,icon:'success',position:'bottom-right'});
    } catch(error) { $.toast({heading:'Không thể lưu',text:error.responseJSON?.message || 'Vui lòng thử lại.',icon:'error',position:'bottom-right'}); }
    finally { button.disabled=false; }
});
