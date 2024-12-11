<?php
include_once(BACKEND_URL . 'model/mBenhNhan.php');
$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
$con = new mBenhNhan();
$dsBenhNhan = $con->getTTBN($MaBN);
$benhNhan = $dsBenhNhan[0];
include_once(BACKEND_URL . 'model/mPKQK.php');
$conkqk = new mPKQK();
$KQKB = $conkqk->getslectKQK($MaBN); 

if (!empty($KQKB) && is_array($KQKB)) {
    $KQKB = $KQKB[0];
    $MaDonThuoc = isset($KQKB['MaDonThuoc']) ? $KQKB['MaDonThuoc'] : null;

    if ($MaDonThuoc) {
        $donthuoc = $conkqk->getTTThuoc($MaDonThuoc);
    } else {
        $donthuoc = []; // Nếu không có mã đơn thuốc, đặt mảng rỗng
    }
} else {
    $KQKB = null; // Đặt null nếu không có kết quả
    $donthuoc = []; // Đặt mảng rỗng nếu không có đơn thuốc
}


?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn thanh toán</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #34495e;
            font-size: 24px;
            margin-bottom: 20px;
        }
        h3 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #3498db;
            color: #fff;
        }
        table td {
            color: #34495e;
        }
        .total, .payable {
            font-size: 18px;
            color: #2c3e50;
            margin: 10px 0;
        }
        .payable span {
            color: #e74c3c;
        }
        .btn-pay {
            display: block;
            padding: 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            text-align: center;
        }
        .btn-pay:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Hóa Đơn Thanh Toán </h2>

        <h3>Thông tin bệnh nhân</h3>
        <p><strong>Tên bệnh nhân:</strong> Châu Duy Khánh</p>
        <p><strong>Mã bệnh nhân:</strong> 01042003</p>

        <h3>Thông tin xuất viện</h3>
        <p><strong>Ngày nhập viện:</strong> 01/10/2024</p>
        <p><strong>Ngày xuất viện:</strong> 25/10/2024</p>
        <p><strong>Tổng số ngày nằm viện:</strong> 24 ngày</p>

        <h3>Chi tiết chi phí</h3>
        <table>
            <thead>
                <tr>
                    <th>Loại chi phí</th>
                    <th>Tên</th>
                    <th>Số lượng</th>
                    <th>Giá (VNĐ)</th>
                    <th>Thành tiền (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2">Thuốc</td>
                    <td>Thuốc giảm đau</td>
                    <td>5 viên</td>
                    <td>150,000</td>
                    <td>750,000</td>
                </tr>
                <tr>
                    <td>Kháng sinh</td>
                    <td>3 lọ</td>
                    <td>250,000</td>
                    <td>750,000</td>
                </tr>
                <tr>
                    <td>Giường</td>
                    <td>Tiền giường</td>
                    <td>24 ngày</td>
                    <td>120,000</td>
                    <td>2,880,000</td>
                </tr>
                <tr>
                    <td>Tạm ứng</td>
                    <td>Tiền tạm ứng</td>
                    <td></td>
                    <td></td>
                    <td>-1,000,000</td>
                </tr>
                <tr>
                    <td>Bảo hiểm y tế</td>
                    <td>Bảo hiểm y tế chi trả (80%)</td>
                    <td></td>
                    <td></td>
                    <td>-3,064,000</td>
                </tr>
            </tbody>
        </table>

        <p class="total"><strong>Tổng chi phí:</strong> <span>766,000 VNĐ</span></p>
        <p class="payable"><strong>Số tiền bệnh nhân cần thanh toán:</strong> <span>766,000 VNĐ</span></p>

        <a href="" class="btn-pay">Thanh toán</a>
    </div>

    <script>
        
        const prices = [
            { quantity: 5, unitPrice: 150000 }, 
            { quantity: 3, unitPrice: 250000 }, 
            { quantity: 24, unitPrice: 120000 }, 
            { quantity: 0, unitPrice: 0 }, 
            { quantity: 0, unitPrice: 0 }  
        ];

        let totalCost = 0;

        const totalDrugCost = (prices[0].quantity * prices[0].unitPrice) + (prices[1].quantity * prices[1].unitPrice);
        const bedCost = prices[2].quantity * prices[2].unitPrice;
        const advancePayment = -1000000;
        const insurancePayment = -3064000;

        totalCost = totalDrugCost + bedCost + advancePayment + insurancePayment;

        document.querySelector('.total span').textContent = totalCost.toLocaleString('vi-VN') + ' VNĐ';
        document.querySelector('.payable span').textContent = totalCost.toLocaleString('vi-VN') + ' VNĐ';
    </script>

</body>
</html>
