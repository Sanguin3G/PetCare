const form=document.getElementById('AddProForm');
const input=document.getElementById('imagepro');
const preview=document.querySelector('.image-preview');
let urls=[];
if(window.CKEDITOR) window.CKEDITOR.replace('mota');
function renderImages() {
    urls.forEach(URL.revokeObjectURL); urls=[]; preview.replaceChildren();
    [...input.files].forEach((file,index) => {
        const container=document.createElement('div'); container.className='preview-container';
        const image=document.createElement('img'); image.className='preview-image'; image.alt=file.name;
        image.src=URL.createObjectURL(file); urls.push(image.src);
        const remove=document.createElement('button'); remove.type='button'; remove.className='remove-btn'; remove.textContent='×'; remove.setAttribute('aria-label',`Bỏ ảnh ${file.name}`);
        remove.addEventListener('click',() => { const transfer=new DataTransfer(); [...input.files].filter((_,i)=> i !== index).forEach(file=>transfer.items.add(file)); input.files=transfer.files; renderImages(); });
        container.append(image,remove); preview.append(container);
    });
}
input.addEventListener('change',() => {
    if([...input.files].some(file=>!['image/jpeg','image/png','image/gif','image/webp'].includes(file.type) || file.size > 2*1024*1024)) {
        input.value=''; $.toast({heading:'Ảnh không hợp lệ',text:'Chọn JPG, PNG, GIF hoặc WebP, tối đa 2 MB mỗi ảnh.',icon:'error',position:'bottom-right'});
    }
    renderImages();
});
form.addEventListener('submit',async event => {
    event.preventDefault();
    const button=document.getElementById('buttonAddPro'); if(button.disabled || !form.reportValidity()) return;
    button.disabled=true; button.textContent='Đang lưu…';
    window.CKEDITOR?.instances.mota?.updateElement();
    const data=new FormData(form); data.append('_token',document.querySelector('meta[name="csrf-token"]').content);
    try {
        const response=await $.ajax({url:'/api/admin/product/create',type:'POST',headers:{Authorization:`Bearer ${localStorage.getItem('authTokenPassport')}`},data,processData:false,contentType:false});
        if(response.status !== 'success') throw {responseJSON:response};
        $.toast({heading:'Đã lưu sản phẩm',text:response.message,icon:'success',position:'bottom-right'});
        form.reset(); window.CKEDITOR?.instances.mota?.setData(''); renderImages();
    } catch(error) {
        const result=error.responseJSON;
        const message=result?.errors ? Object.values(result.errors).flat().join(' ') : result?.message || 'Không thể lưu sản phẩm. Vui lòng thử lại.';
        $.toast({heading:'Không thể lưu',text:message,icon:'error',position:'bottom-right'});
    } finally { button.disabled=false; button.textContent='Thêm sản phẩm'; }
});
