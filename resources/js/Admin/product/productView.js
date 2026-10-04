import { loadProducts } from './get';
let timer;
$('#searchProduct').on('input', function() { clearTimeout(timer); timer=setTimeout(() => loadProducts(1),300); });
