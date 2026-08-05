import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/Admin/LayoutAdmin.js',
                'resources/js/Admin/account/LoginAdmin.js',
                'resources/js/Admin/account/LogoutAdmin.js',
                'resources/js/Admin/account/RegistAccountAdmin.js',
                'resources/js/Admin/account/updateInfor.js',
                'resources/js/Admin/category/create.js',
                'resources/js/Admin/category/delete.js',
                'resources/js/Admin/category/update.js',
                'resources/js/Admin/order/detail.js',
                'resources/js/Admin/product/changeProduct.js',
                'resources/js/Admin/product/CreateProduct.js',
                'resources/js/Admin/product/delete.js',
                'resources/js/Admin/product/get.js',
                'resources/js/Admin/product/productView.js',
                'resources/js/User/Layout.js',
                'resources/js/User/account/changepass.js',
                'resources/js/User/account/create.js',
                'resources/js/User/account/forgetpass.js',
                'resources/js/User/account/login.js',
                'resources/js/User/cart/cart.js',
                'resources/js/User/home.js',
                'resources/js/User/product/get.js',
                'resources/js/User/product/productDetail.js',
            ],
            refresh: true,
        }),
    ],
});
