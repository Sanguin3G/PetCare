<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
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
</head>

<body>
    <div class="d-flex flex-column Invoices">
        <div class="header" style="margin-bottom:30px">
            <h2>Công ty TNHH cổ phần PetCare</h2>
            <p>Địa chỉ: Ninh Kiều, Cần Thơ</p>
        </div>
        @foreach ($Order as $order)
        <div>
            <h3 style="font-size:3vh;font-size:3vw;text-align:center">Hóa đơn bán hàng</h3>
            <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Khách hàng: <span style="color:red">{{
                    $order->getCus($order->idCus)
                    }}</span></p>
            <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Địa chỉ : <span style="color:red">{{
                    $order->address }}</span></p>
            <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Ngày: <span style="color:red"> {{
                    \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s') }}</span></p>
            <table class="table-bordered table-hover text-center" style="text-align:center">
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
        <div style="margin-top:20px">
            <?php use Carbon\Carbon;
              $now = Carbon::now(); ?>
            <div style="float:right">   
                <i>Ngày <span>{{ $now->day }}</span> Tháng <span>{{ $now->month }}</span> Năm <span>{{ $now->year
                        }}</span></i>
            </div>
        </div>
    </div>
</body>

</html>