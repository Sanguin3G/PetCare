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
    <div class="Invoices" style="display:flex;flex-direction: column">
        <div class="header" style="margin-bottom:30px">
            <h2>Công ty TNHH cổ phần PetCare</h2>
            <p>Địa chỉ: Ninh Kiều, Cần Thơ</p>
        </div>
        @foreach ($book as $row)
        <div>
            <h3 style="font-size:3vh;font-size:3vw;text-align:center">Hóa đơn bán hàng</h3>
            <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Khách hàng: <span style="color:red">{{
                    $book1->getCus($row->idCus)
                    }}</span></p>
            <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Số điện thoại : <span style="color:red">{{
                    $book1->getPhone($row->idCus) }}</span></p>
            <p style="font-size:1.2vh;font-size:1.2vw;font-weight:700">Ngày hẹn: <span style="color:red"> {{
                    \Carbon\Carbon::parse((int)$row->date)->format('d-m-Y H:i:s') }}</span></p>
            <table class="table-bordered table-hover" style="text-align:center">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Số thứ tự</th>
                        <th>Tên pet</th>
                        <th>Cân nặng</th>
                        <th>Tên dịch vụ</th>
                        <th>Gói</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $stt = 0 ?>
                    @foreach ($book as $row)
                    <?php $stt++ ?>
                    <tr>
                        <td>{{ $stt }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->weight }}</td>
                        <td>{{ $row->name_service }}</td>
                        <td>{{ $row->type }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">Thành tiền</td>
                        <td>{{ number_format($row->cost) }} VNĐ</td>
                    </tr>
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