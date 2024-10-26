<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Hóa Đơn Thanh Toán</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
            color: #34495e;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        table th {
            background-color: #3498db;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
        }
        table td {
            color: #34495e;
        }
        a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn-pay {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 700;
        }
        .btn-pay:hover {
            background-color: #2980b9;
        }
        @media (max-width: 600px) {
            h2 {
                font-size: 24px;
            }
            table th, table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Danh Sách Hóa Đơn Thanh Toán</h2>

        <table>
            <thead>
                <tr>
                    <th>Mã Hóa Đơn</th>
                    <th>Tên Bệnh Nhân</th>
                    <th>Mã Bệnh Nhân</th>
                    <th>Số Tiền Cần Thanh Toán (VNĐ)</th>
                    <th>Trạng Thái Thanh Toán</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>HD001</td>
                    <td>Châu Duy Khánh</td>
                    <td>01042003</td>
                    <td>316,000</td>
                    <td>Chưa Thanh Toán</td>
                    <td><a href="hoadon.php" class="btn-pay">Thanh Toán</a></td>
                </tr>
                <tr>
                    <td>HD002</td>
                    <td>Nguyễn Văn A</td>
                    <td>01042004</td>
                    <td>1,200,000</td>
                    <td>Đã Thanh Toán</td>
                    <td><a href="hoadon.php" class="btn-pay">Xem Hóa Đơn</a></td>
                </tr>
                <tr>
                    <td>HD003</td>
                    <td>Trần Thị B</td>
                    <td>01042005</td>
                    <td>980,000</td>
                    <td>Chưa Thanh Toán</td>
                    <td><a href="hoadon.php" class="btn-pay">Thanh Toán</a></td>
                </tr>
                <tr>
                    <td>HD004</td>
                    <td>Lê Văn C</td>
                    <td>01042006</td>
                    <td>1,500,000</td>
                    <td>Chưa Thanh Toán</td>
                    <td><a href="hoadon.php" class="btn-pay">Thanh Toán</a></td>
                </tr>
                <tr>
                    <td>HD005</td>
                    <td>Phạm Thị D</td>
                    <td>01042007</td>
                    <td>600,000</td>
                    <td>Đã Thanh Toán</td>
                    <td><a href="hoadon.php" class="btn-pay">Xem Hóa Đơn</a></td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
