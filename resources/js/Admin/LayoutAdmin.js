import '../../css/admin-polish.css';

const token = localStorage.getItem('authTokenPassport');
const feedback = document.getElementById('admin-feedback');
if (!token) window.location.replace('/admin/login');
else {
    $('#buttonCreateAccount').hide();
    $.ajax({ url:'/api/admin/profile', headers:{Authorization:`Bearer ${token}`} })
        .done(response => {
            if (!response.data) return;
            $('#isHasUser').removeClass('d-none');
            $('#NameUser').text(response.data.name);
            if (response.data.role === 'admin') $('#buttonCreateAccount').show();
        }).fail(xhr => {
            if (xhr.status === 401 || xhr.status === 403) window.location.replace('/admin/login');
            else if (feedback) { feedback.className='alert alert-warning'; feedback.textContent='Không thể tải thông tin tài khoản. Vui lòng tải lại trang.'; }
        });
}
const menu = document.querySelector('.admin-menu-toggle');
menu?.addEventListener('click', () => {
    document.body.classList.toggle('toggle-sidebar');
    menu.setAttribute('aria-expanded', String(window.innerWidth < 1200 ? document.body.classList.contains('toggle-sidebar') : !document.body.classList.contains('toggle-sidebar')));
});
document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && window.innerWidth < 1200) { document.body.classList.remove('toggle-sidebar'); menu?.setAttribute('aria-expanded','false'); }
});
// Search controls on these paginated tables explicitly search the visible page.
[['searchOrders','table-order'],['searchNV','table-category']].forEach(([inputId, tableId]) => {
    const input=document.getElementById(inputId), table=document.getElementById(tableId);
    input?.addEventListener('input', () => {
        const query=input.value.toLocaleLowerCase('vi').trim();
        [...table.rows].forEach(row => { row.hidden=!row.textContent.toLocaleLowerCase('vi').includes(query); });
    });
});
document.querySelectorAll('.modal').forEach(modal => modal.addEventListener('shown.bs.modal', () => modal.querySelector('input')?.focus()));
