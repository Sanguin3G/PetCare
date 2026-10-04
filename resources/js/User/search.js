const money = value => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
document.querySelectorAll('[data-product-search]').forEach(root => {
    const input = root.querySelector('input');
    const results = root.querySelector('.pc-search-results');
    const clear = root.querySelector('.pc-search-reset');
    const announcement = root.querySelector('[role="status"]');
    let timer, controller, version = 0, active = -1;
    const close = () => { ++version; clearTimeout(timer); controller?.abort(); results.hidden = true; input.setAttribute('aria-expanded', 'false'); active = -1; };
    const state = message => {
        results.replaceChildren();
        const p = document.createElement('p'); p.textContent = message; results.append(p);
        results.hidden = false; input.setAttribute('aria-expanded', 'true'); announcement.textContent = message;
    };
    input.addEventListener('input', () => {
        clearTimeout(timer); controller?.abort(); const requestVersion = ++version;
        const q = input.value.trim(); clear.hidden = !q; active = -1;
        if (q.length < 2) { close(); return; }
        state('Đang tìm sản phẩm…');
        timer = setTimeout(async () => {
            controller = new AbortController();
            try {
                const response = await fetch(`/api/products/search?q=${encodeURIComponent(q)}`, { signal: controller.signal, headers: { Accept: 'application/json' } });
                if (!response.ok) throw new Error();
                const { data } = await response.json();
                if (version !== requestVersion) return;
                results.replaceChildren();
                if (!data.length) state('Chưa có sản phẩm phù hợp. Thử một tên khác.');
                for (const product of data) {
                    const link = document.createElement('a'); link.href = product.url; link.className = 'pc-search-result';
                    const img = document.createElement('img'); img.src = product.image; img.alt = ''; img.width = 48; img.height = 48;
                    const text = document.createElement('span'); const name = document.createElement('strong'); name.textContent = product.name;
                    const category = document.createElement('small'); category.textContent = product.category;
                    const price = document.createElement('span'); price.textContent = money(product.price); price.className = 'pc-search-price';
                    text.append(name, category); link.append(img, text, price); results.append(link);
                }
                const all = document.createElement('a'); all.href = `/product/all?q=${encodeURIComponent(q)}`; all.textContent = 'Xem tất cả kết quả →'; all.className = 'pc-search-all'; results.append(all);
                announcement.textContent = `${data.length} gợi ý sản phẩm`;
            } catch (error) { if (error.name !== 'AbortError' && version === requestVersion) state('Không thể tải gợi ý. Nhấn Enter để tìm trong cửa hàng.'); }
        }, 250);
    });
    clear.addEventListener('click', () => { input.value = ''; input.dispatchEvent(new Event('input')); input.focus(); });
    input.addEventListener('focus', () => { if (input.value.trim().length >= 2 && results.childElementCount) { results.hidden = false; input.setAttribute('aria-expanded', 'true'); } });
    root.addEventListener('keydown', event => {
        const links = [...results.querySelectorAll('a')];
        if (event.key === 'Escape') { close(); input.focus(); }
        if (!results.hidden && links.length && ['ArrowDown', 'ArrowUp'].includes(event.key)) {
            event.preventDefault(); active = active < 0 ? (event.key === 'ArrowDown' ? 0 : links.length - 1) : (active + (event.key === 'ArrowDown' ? 1 : -1) + links.length) % links.length; links[active].focus();
        }
    });
    document.addEventListener('pointerdown', event => { if (!root.contains(event.target)) { ++version; controller?.abort(); clearTimeout(timer); close(); } });
    root.addEventListener('focusout', () => { setTimeout(() => { if (!root.contains(document.activeElement)) close(); }, 0); });
});
