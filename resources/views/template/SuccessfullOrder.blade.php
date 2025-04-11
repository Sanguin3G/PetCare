<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hàng Thành Công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .content {
            padding: 20px;
            text-align: left;
        }

        .order-details,
        .order-items {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background: #4CAF50;
            color: white;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>🎉 Đặt Hàng Thành Công!</h2>
        </div>
        <div class="content">
            <p>Xin chào <strong></strong>,</p>
            <p>Cảm ơn bạn đã đặt hàng tại <strong>PetCare</strong>. Dưới đây là thông tin đơn hàng của bạn:</p>

            <div class="order-details">
                <p><strong>Mã đơn hàng:{{ $id }}</strong> </p>
                <p><strong>Thời gian đặt hàng: {{ $Order['created_at'] }}</strong> </p>
                <p><strong>Phương thức: {{ $Order->thanhtoan }}</strong> </p>
            </div>

            <div class="order-items">
                <h3 style="margin-bottom:10px">🛒 Chi Tiết Đơn Hàng</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Khuyến mại</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($OrderDetail as $row )
                        <tr>
                            <td>{{ $row->namePro }}</td>
                            <td>{{ $row->number }}</td>
                            <td> {{ number_format($row->price) }}đ</td>
                            @if ($row->discount > 0)
                            <td>
                                {{ $row->discount }}%
                            </td>
                            @else
                            <td></td>
                            @endif
                            @if ($row->discount > 0)
                            <td>
                                {{ number_format($row->number * ($row->price - $row->price *
                                ($row->discount / 100))) }}đ
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
            </div>

            <p style="margin-bottom:10px"><strong>Tổng tiền:</strong> {{ number_format($totalPrice) }} đ</p>
            @if ($discountVoucher > 0 && $discountVoucher !== null)
            <p style="margin-bottom:10px"><strong>Giảm trừ Voucher</strong> {{ $discountVoucher }}%</p>
            <p style="margin-bottom:10px"><strong>Thành tiền:</strong> {{ number_format($totalPrice - $totalPrice *
                ($discountVoucher / 100)) }} đ</p>
            @endif
        </div>
        <div class="footer">
            <p>Nếu bạn có bất kỳ câu hỏi nào, hãy liên hệ với chúng tôi qua email
                <strong>namn3102003@gmail.com</strong>.
            </p>
        </div>
    </div>

</body>

</html>