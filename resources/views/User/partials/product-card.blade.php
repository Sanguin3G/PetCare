@php
    $image = $product->ImageProduct->first();
    $url = route('user.productDetail', ['id' => $product->idPro, 'name' => \Illuminate\Support\Str::slug($product->namePro) ?: 'product']);
    $price = round($product->cost * (1 - ($product->discount ?? 0) / 100));
@endphp
<article class="pc-shop-card">
    <a class="pc-card-image" href="{{ $url }}" tabindex="-1" aria-hidden="true">
        <img src="{{ $image ? asset('assets/img-add-pro/'.$image->image) : asset('assets/img/PetCARE.png') }}" alt="" loading="lazy" width="300" height="300">
        @if ($product->discount > 0)<span class="pc-sale-badge">−{{ $product->discount }}%</span>@endif
    </a>
    <div class="pc-card-body">
        <h3><a href="{{ $url }}">{{ $product->namePro }}</a></h3>
        <p class="pc-price">{{ number_format($price) }}đ @if ($product->discount > 0)<del>{{ number_format($product->cost) }}đ</del>@endif</p>
        <small class="pc-stock">{{ $product->count > 0 ? 'Còn hàng' : 'Tạm hết hàng' }}</small>
        <a class="btn pc-card-action" href="{{ $url }}">Xem sản phẩm <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    </div>
</article>
