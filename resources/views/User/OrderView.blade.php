<div class="container pc-commerce py-4 py-md-5" data-order-page>
    <div class="pc-commerce-heading"><div><p class="pc-eyebrow">Theo dõi cùng PetCare</p><h1>Đơn hàng của bạn</h1></div><span class="text-muted">{{ $Order->count() }} đơn hàng</span></div>
    <div data-order-feedback class="alert alert-danger" hidden role="alert"></div>
    @forelse ($Order as $order)
        @php
            $statuses = [-1 => 'Đã hủy', 0 => 'Chờ xác nhận', 1 => 'Đã giao hàng'];
        @endphp
        <article class="pc-commerce-panel pc-order-card mb-4" data-order-id="{{ $order->id }}">
            <header class="pc-order-header"><div><h2>Đơn #{{ $order->id }}</h2><time datetime="{{ $order->created_at->toIso8601String() }}">{{ $order->created_at->format('d/m/Y · H:i') }}</time></div><span class="pc-order-status" data-order-status>{{ $statuses[$order->status] ?? 'Đang xử lý' }}</span></header>
            @foreach ($order->OrderDetail as $item)
                @php $product = $item->ProductDetail; @endphp
                <div class="pc-order-item"><img src="{{ asset('assets/img-add-pro/' . ($product?->getImgProduct($item->idPro) ?? '11744768508.webp')) }}" alt="{{ $product?->namePro ?? 'Sản phẩm' }}" loading="lazy"><div><h3>{{ $product?->namePro ?? 'Sản phẩm không còn trong danh mục' }}</h3><span class="text-muted">Số lượng: {{ $item->number }}</span></div><strong>{{ $item->TotalCostOfProduct }} ₫</strong></div>
            @endforeach
            <footer class="pc-order-footer"><div><p><strong>Giao đến:</strong> {{ $order->address }}</p><p><strong>Thanh toán:</strong> {{ $order->thanhtoan }}</p>@if($order->note)<details><summary>Thông tin nhận hàng và ghi chú</summary><p>{{ $order->note }}</p></details>@endif</div><div class="pc-order-total"><span>Tổng tiền</span><strong>{{ $order->totalCost }} ₫</strong>@if ((int) $order->status === 0)<button type="button" class="btn btn-outline-danger mt-2" data-cancel-order="{{ $order->id }}">Hủy đơn hàng</button>@endif</div></footer>
        </article>
    @empty
        <div class="pc-commerce-empty"><i class="fa-solid fa-box-open" aria-hidden="true"></i><h2>Bạn chưa có đơn hàng nào</h2><p>Những món đồ chăm sóc đầu tiên đang chờ người bạn nhỏ của bạn.</p><a href="{{ route('user.product', ['id' => 0]) }}" class="btn btn-primary">Khám phá sản phẩm</a></div>
    @endforelse
</div>
