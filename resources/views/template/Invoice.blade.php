<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn Bán Hàng</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #007bff;
        }

        .order-info,
        .customer-info,
        .product-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Công ty TNHH cổ phần PetCare</h2>
            <h3>HÓA ĐƠN BÁN HÀNG</h3>
            <p>Ngày: {{ date('d/m/Y') }}</p>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="customer-info">
            <h3>Thông Tin Khách Hàng</h3>
            <p><strong>Tên: <i>{{ $Customer->name }}</i></strong> </p>
            <p><strong>Email: <i>{{ $Customer->email }}</i></strong> </p>
            {{-- <p><strong>Số điện thoại:</strong> </p>
            <p><strong>Địa chỉ:</strong> </p> --}}
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="order-info">
            <h3>Chi Tiết Đơn Hàng</h3>
            <p>Mã đơn hàng: {{ $id }} </p>
            <p>Ngày đặt hàng: {{ $Order->created_at }}</p>
        </div>

        <!-- Bảng sản phẩm -->
        <table class="product-table" style="border-collapse: collapse">
            <thead>
                <tr>
                    <th>Sản phẩm/Dịch vụ</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Giảm giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($OrderDetail as $row)
                <tr>
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
        </table>

        <!-- Tổng tiền -->
        @if ($discountVoucher > 0 && $discountVoucher !== null)
        <p>Giảm giá Voucher : {{ $discountVoucher }}%</p>
        <p>Tổng cộng: {{ number_format($totalPrice - $totalPrice * ($discountVoucher / 100)) }}đ</p>
        </tr>
        @else
        <h2>Tổng cộng: {{ number_format($totalPrice) }}đ</h2>
        @endif
        <p style="margin-top:20px">Cảm ơn quý khách đã mua hàng! </p>
    </div>
</body>

</html>