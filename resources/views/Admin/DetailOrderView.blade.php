<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="">
            <li class="breadcrumb-item"><a href="{{ route('admin.order') }}">Danh sách đơn hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết</li>
        </ol>
    </nav>
</div>
{{-- <div>
    <form method="POST" action="{{ route('admin.invoiceView') }}">
        @csrf
        <input hidden value="{{ $order->id }}" name="IdOrder" hidden>
        <button class="btn btn-primary mb-2" type="submit">
            Xuất hóa đơn
        </button>
    </form>

</div> --}}
<div class="container-fluid border border-primary rounded" style="">
    <div class="p-4">
        <div class="name d-inline-block">
            <span>
                <p>Họ và tên: <b>{{ $order->name ?? $order->UserInfo?->name }} </b></p>
            </span>
        </div>
        <div class="local ">
            <span>
                <p>Địa chỉ: <b>{{ $order->address }}</b></p>
            </span>
        </div>
        <div class="phone mt-4">
            <span>
                <p>Số điện thoại: <b> {{ $order->phone ?? $order->UserInfo?->phone }}</b></p>
            </span>
        </div>
        <div class="date mt-4">
            <span>
                <p>Ngày đặt: <b>{{ $order->created_at }}</b></p>
            </span>
        </div>
        <div class="local mt-4">
            <span>
                <p>Trạng thái </p>
                @if ($order->status < 0)
                <span class="badge bg-danger">Đã hủy</span>
                @elseif ($order->status > 0)
                <span class="badge bg-success">Đã giao hàng</span>
                @else
                <span class="badge bg-secondary">Chờ xác nhận</span>
                @endif

            </span>
        </div>
        <div class="order-detail table-responsive mt-4">
            <table class="table table-bordered table-hover text-center">
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Giảm giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                @foreach ($order->OrderDetail as $row)
                <tr>
                    <td>
                        <img class="img-fluid"
                            src="{{ asset('assets/img-add-pro/' . ($row->ProductDetail?->getImgProduct($row->idPro) ?? '11744768508.webp')) }}"
                            style="max-width:80px" alt="{{ $row->ProductDetail?->namePro ?? 'Sản phẩm' }}">
                    </td>
                    <td>
                        {{ $row->ProductDetail?->namePro ?? 'Sản phẩm không còn trong danh mục' }}
                    </td>
                    <td>
                        {{ number_format($row->price, 0, ',', '.') }}đ
                    </td>
                    @if (($row->discount_snapshot ?? $row->ProductDetail?->discount) > 0)
                    <td>
                        {{ $row->discount_snapshot ?? $row->ProductDetail?->discount }}%
                    </td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $row->number }} </td>
                    <td>{{ $row->TotalCostOfProduct }} đ</td>
                </tr>
                @endforeach
            </table>
        </div>
        <h5 class="text-end text-danger"><b>Tổng tiền: {{ $order->totalCost }} đ</b></h5>
        {{-- @if ($discountVoucher > 0 && $discountVoucher !== null)
        <h5 class="text-end text-danger"> <b>Giảm giá Voucher : {{ $discountVoucher }}%</b></h5>
        <h4 class="text-end text-danger"><b>Thành tiền :
                {{ number_format($totalPrice - $totalPrice * ($discountVoucher / 100)) }}đ</b>
        </h4>
        @endif --}}
    </div>
</div>
