@extends('Admin.Layout')
@section('content')
<style>
    body {
        margin: 20px;
        font-family: 'DejaVu Sans', sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .Invoices {
        padding: 25px;
        border: 1px solid black;
    }
</style>
<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
            <li class="breadcrumb-item"><a href="{{ route('admin.order') }}">Danh sách đơn hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết</li>
            <li class="breadcrumb-item active" aria-current="page">Xuất hóa đơn</li>
        </ol>
    </nav>
</div>
<div class="d-flex flex-column Invoices">
    <div class="header" style="margin-bottom:150px">
        <img style="max-width:100px" src="{{ asset('assets/img/PetCARE.png') }}" alt="Logo">
        <h2>Công ty TNHH cổ phần PetCare</h2>
        <p>Địa chỉ: Ninh Kiều, Cần Thơ</p>
    </div>
    @foreach ($Order as $order)
    <div>
        <h3 class="text-center" style="font-size:3vh;font-size:3vw">Hóa đơn bán hàng</h3>
        <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Khách hàng: <span class="text-danger">{{
                $order->getCus($order->idCus)
                }}</span></p>
        <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Địa chỉ : <span class="text-danger">{{
                $order->address }}</span></p>
        <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Ngày: <span class="text-danger"> {{
                \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s') }}</span></p>
        <table class="table-bordered table-hover text-center">
            <thead>
                <tr class="bg-primary text-white">
                    <th>Số thứ tự</th>
                    <th>Sản phẩm/Dịch vụ</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Giảm giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $stt = 0 ?>
                @foreach ($OrderDetail as $row)
                <?php $stt++ ?>
                <tr>
                    <td>{{ $stt }}</td>
                    <td>{{ $row->getProductName($row->idPro) }}</td>
                    <td>{{ $row->number }}</td>
                    <td>{{ number_format($row->price) }}đ</td>
                    @if ($row->getProductDiscount($row->idPro))
                    <td>
                        {{ $row->getProductDiscount($row->idPro) }}%
                    </td>
                    @else
                    <td></td>
                    @endif
                    @if ($row->getProductDiscount($row->idPro) > 0)
                    <td>
                        {{ number_format($row->number * ($row->price - $row->price *
                        ($row->getProductDiscount($row->idPro) / 100))) }}đ
                    </td>
                    @else
                    <td>
                        {{ number_format($row->number * $row->price) }}đ
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if ($discountVoucher > 0 && $discountVoucher !== null)
                <tr>
                    <td colspan="4" style="text-align: right;">Giảm giá Voucher</td>
                    <td>{{ $discountVoucher }}%</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">Tổng cộng:</td>
                    <td>{{ number_format($totalPrice - $totalPrice * ($discountVoucher / 100)) }}đ</td>
                </tr>
                @else
                <td colspan="5" style="text-align: right;">Tổng cộng:</td>
                <td>{{ number_format($totalPrice) }}đ</td>
                @endif
            </tfoot>
        </table>
    </div>
    @endforeach
    <div class="mt-3 me-4">
        <?php use Carbon\Carbon;
              $now = Carbon::now(); ?>
        <div class="text-end">
            <i>Ngày <span>{{ $now->day }}</span> Tháng <span>{{ $now->month }}</span> Năm <span>{{ $now->year
                    }}</span></i>
        </div>
    </div>
</div>
<div>
    <form method="POST" action="{{ route('admin.exportInvoices') }}">
        @csrf
        <input hidden value="{{ $id }}" name="IdOrder" hidden>
        <button style="float:right" type="submit" class="btn btn-warning mt-2 mb-2">
            Xuất hóa đơn
        </button>
    </form>

</div>
@endsection