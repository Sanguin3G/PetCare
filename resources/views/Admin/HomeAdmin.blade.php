@extends('Admin.Layout')
@section('content')
<div class="pagetitle"><h1>Tổng quan cửa hàng</h1><p class="text-muted">Những việc cần chú ý hôm nay.</p></div>
<div class="row g-3 mb-4">
    @foreach ([['Đơn hôm nay', $todayOrders, 'admin.order'], ['Chờ xác nhận', $pendingOrders, 'admin.order'], ['Sản phẩm hết hàng', $outOfStock, 'admin.product'], ['Sản phẩm trong danh mục', $productCount, 'admin.product']] as [$label, $count, $route])
    <div class="col-6 col-xl-3"><a class="card h-100 text-decoration-none" href="{{ route($route) }}"><div class="card-body pt-4"><p class="text-muted mb-2">{{ $label }}</p><strong class="fs-2">{{ $count }}</strong></div></a></div>
    @endforeach
</div>
<div class="card"><div class="card-body pt-4"><div class="d-flex justify-content-between align-items-center mb-3"><h2 class="fs-5 mb-0">Đơn hàng gần đây</h2><a href="{{ route('admin.order') }}">Xem tất cả →</a></div><div class="table-responsive"><table class="table"><thead><tr><th>Mã đơn</th><th>Ngày đặt</th><th>Trạng thái</th></tr></thead><tbody>
@forelse ($recentOrders as $order)<tr><td>{{ $order->id }}</td><td>{{ $order->created_at->format('d/m/Y H:i') }}</td><td><span class="badge {{ $order->status < 0 ? 'bg-danger' : ($order->status > 0 ? 'bg-success' : 'bg-secondary') }}">{{ $order->status < 0 ? 'Đã hủy' : ($order->status > 0 ? 'Đã giao hàng' : 'Chờ xác nhận') }}</span></td></tr>@empty<tr><td colspan="3" class="py-4 text-muted">Chưa có đơn hàng. Đơn mới sẽ xuất hiện tại đây.</td></tr>@endforelse
</tbody></table></div></div></div>
@endsection
