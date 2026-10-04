@extends('User.LayoutTrangChu')
@section('content')
@php
    $image = $product->ImageProduct->first();
    $imageUrl = $image ? asset('assets/img-add-pro/'.$image->image) : asset('assets/img/PetCARE.png');
    $price = round($product->cost * (1 - ($product->discount ?? 0) / 100));
@endphp
<div class="container pc-detail-page">
    <nav aria-label="Đường dẫn" class="pc-breadcrumb"><a href="{{ route('user.home') }}">Trang chủ</a><span aria-hidden="true">/</span><a href="{{ route('user.product', ['id' => 'all']) }}">Sản phẩm</a><span aria-hidden="true">/</span><span>{{ $product->namePro }}</span></nav>
    <div class="pc-detail-grid">
        <section class="pc-gallery" aria-label="Hình ảnh sản phẩm">
            <button type="button" class="pc-main-image-button" data-bs-toggle="modal" data-bs-target="#product-image-modal" aria-label="Phóng to hình sản phẩm"><img class="main-img-product" src="{{ $imageUrl }}" alt="{{ $product->namePro }}" width="600" height="600"></button>
            @if ($product->ImageProduct->count() > 1)<div class="pc-thumbnails">@foreach ($product->ImageProduct as $photo)<button class="pc-thumbnail {{ $loop->first ? 'active' : '' }}" type="button" data-image="{{ asset('assets/img-add-pro/'.$photo->image) }}" aria-label="Xem ảnh {{ $loop->iteration }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}"><img src="{{ asset('assets/img-add-pro/'.$photo->image) }}" alt="" loading="lazy" width="72" height="72"></button>@endforeach</div>@endif
        </section>
        <section class="pc-purchase-panel">
            <span class="pc-section-kicker">Một món nhỏ, nhiều niềm vui</span><h1>{{ $product->namePro }}</h1>
            <p class="pc-product-code">Mã sản phẩm: {{ $product->idPro }}</p>
            <p class="pc-price pc-detail-price">{{ number_format($price) }}đ @if ($product->discount > 0)<del>{{ number_format($product->cost) }}đ</del><span class="pc-sale-badge">−{{ $product->discount }}%</span>@endif</p>
            <p class="pc-stock">{{ $product->count > 0 ? 'Còn hàng · '.$product->count.' sản phẩm khả dụng' : 'Tạm hết hàng' }}</p>
            <form id="product-purchase-form">
                <label for="countToAdd" class="form-label">Số lượng</label>
                <div class="pc-quantity"><button type="button" id="buttonDown" aria-label="Giảm số lượng" @disabled($product->count <= 0)>−</button><input type="number" id="countToAdd" value="1" min="1" max="{{ max(1, $product->count) }}" required @disabled($product->count <= 0)><button type="button" id="buttonUp" aria-label="Tăng số lượng" @disabled($product->count <= 0)>+</button></div>
                <button type="submit" class="btn pc-primary-cta pc-add-cart" id="buttonAddToCart" data-id="{{ $product->idPro }}" data-name="{{ $product->namePro }}" data-cost="{{ $product->cost }}" data-discount="{{ $product->discount ?? 0 }}" data-stock="{{ $product->count }}" data-image="{{ $imageUrl }}" @disabled($product->count <= 0)><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i> {{ $product->count > 0 ? 'Thêm vào giỏ hàng' : 'Tạm hết hàng' }}</button>
                <p id="purchase-feedback" role="status" aria-live="polite"></p>
            </form>
            <a href="{{ route('user.cart') }}">Xem giỏ hàng →</a>
        </section>
    </div>
    <section class="pc-product-description"><h2>Thông tin sản phẩm</h2><p>{{ $product->description ?: 'Thông tin chi tiết đang được cập nhật.' }}</p></section>
    @if ($productRelated->isNotEmpty())<section><div class="pc-section-heading"><h2>Cùng chăm bé mỗi ngày</h2><a href="{{ route('user.product', ['id' => $product->idCat]) }}">Xem danh mục →</a></div><div class="pc-shop-grid">@foreach ($productRelated as $product) @include('User.partials.product-card') @endforeach</div></section>@endif
</div>
<div class="modal fade" id="product-image-modal" tabindex="-1" aria-labelledby="product-image-title" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h2 class="modal-title fs-5" id="product-image-title">Hình ảnh sản phẩm</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button></div><div class="modal-body"><img class="pc-lightbox-image" src="{{ $imageUrl }}" alt="Hình sản phẩm phóng to"></div></div></div></div>
@vite('resources/js/User/product/productDetail.js')
@endsection
