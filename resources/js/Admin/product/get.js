const escape = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
let pending;
export async function loadProducts(page = 1) {
    pending?.abort();
    const text = $('#searchProduct').val()?.trim() || '';
    $('#table-product').attr('aria-busy','true');
    pending = $.ajax({
        url: text ? `/api/auth/product/findBySearch?page=${page}` : `/api/admin/product/get?page=${page}`,
        type:text ? 'POST' : 'GET', data:{text},
        headers:{Authorization:`Bearer ${localStorage.getItem('authTokenPassport')}`},
    });
    try {
        const response = await pending;
        const result = response.data;
        if (!result || !Array.isArray(result.product)) throw new Error('Invalid result');
        $('#table-product').html(result.product.map(p => {
            const image = p.image_product?.[0]?.image;
            const href = `/admin/product/change/${encodeURIComponent(p.idPro)}/${encodeURIComponent(p.namePro.replace(/\s+/g,'-'))}`;
            return `<tr><td>${escape(p.idPro)}</td><td>${escape(p.namePro)}</td><td>${image ? `<img src="/assets/img-add-pro/${encodeURIComponent(image)}" alt="${escape(p.namePro)}" loading="lazy">` : '—'}</td><td>${escape(p.count)}</td><td><span class="badge ${p.count > 0 ? 'bg-success' : 'bg-secondary'}">${p.count > 0 ? 'Còn hàng' : 'Hết hàng'}</span></td><td>${Number(p.cost).toLocaleString('vi-VN')} đ</td><td>${p.discount > 0 ? escape(p.discount)+'%' : '—'}</td><td>${p.hot > 0 ? '✓' : '—'}</td><td class="table-td-center"><button class="btn btn-danger btn-sm button-delete-product" data-id="${escape(p.idPro)}" aria-label="Xóa sản phẩm"><i class="fas fa-trash-alt" aria-hidden="true"></i></button> <a class="btn btn-success btn-sm" href="${href}" aria-label="Sửa sản phẩm"><i class="fas fa-edit" aria-hidden="true"></i></a></td></tr>`;
        }).join('') || '<tr><td colspan="9" class="text-center py-5">Không tìm thấy sản phẩm. Thử từ khóa khác.</td></tr>');
        let links='';
        for(let i=1; i<=(result.last_page || 1); i++) links += `<li class="page-item ${i === (result.current_page || 1) ? 'active' : ''}"><button class="page-link page-link-product" data-page="${i}" ${i === (result.current_page || 1) ? 'aria-current="page"' : ''}>${i}</button></li>`;
        $('.pagination').html(result.product.length ? links : '');
    } catch(error) {
        if(error.statusText !== 'abort') $.toast({heading:'Không thể tải sản phẩm',text:'Vui lòng thử lại.',icon:'error',position:'bottom-right'});
    } finally { $('#table-product').removeAttr('aria-busy'); }
}
$(document).on('click','.page-link-product',function(){loadProducts(Number(this.dataset.page));});
