<?php
include_once(BACKEND_URL . 'model/mBenhNhan.php');
$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
$con = new mBenhNhan();
$dsBenhNhan = $con->getTTBN($MaBN);
$benhNhan = $dsBenhNhan[0];
include_once(BACKEND_URL . 'model/mPKQK.php');
$conkqk = new mPKQK();
$KQKB = $conkqk->getslectKQK($MaBN); 
$KQKB = $KQKB[0];

$MaDonThuoc= $KQKB['MaDonThuoc'];

?>

<div class="main-content" id="main-content">
    <h2 class="header-title">Hóa Đơn Thanh Toán</h2>

    <h3 class="section-title">Thông tin bệnh nhân</h3>
    <p class="text"><strong>Tên bệnh nhân:</strong> <?php echo htmlspecialchars($benhNhan['HoTen']); ?></p>
    <p class="text"><strong>Mã bệnh nhân:</strong> <?php echo htmlspecialchars($benhNhan['MaBN']); ?></p>
    <p class="text"><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($benhNhan['NgaySinh']); ?></p>
    <p class="text"><strong>Giới tính:</strong> <?php echo htmlspecialchars($benhNhan['GioiTinh']); ?></p>
    <p class="text"><strong>ChuanDoan:</strong> <?php echo htmlspecialchars($KQKB['ChanDoan']); ?></p>
    <p class="text"><strong>Ngày tái khám:</strong> <?php echo htmlspecialchars($KQKB['NgayTaiKham']); ?></p>

    <h3 class="section-title">Chi tiết chi phí</h3>
    <table class="table-cost">
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
        </tbody>
    </table>

    <p class="total-amount"><strong>Tổng chi phí:</strong> <span>1,500,000 VNĐ</span></p>
    <p class="payable-amount"><strong>Số tiền bệnh nhân cần thanh toán:</strong> <span>1,500,000 VNĐ</span></p>

    <a href="#" class="btn-payment">Thanh toán</a>
</div>

<script>
    const prices = [
        { quantity: 5, unitPrice: 150000 }, 
        { quantity: 3, unitPrice: 250000 }
    ];

    let totalCost = 0;
    const totalDrugCost = (prices[0].quantity * prices[0].unitPrice) + (prices[1].quantity * prices[1].unitPrice);

    totalCost = totalDrugCost;

    document.querySelector('.total-amount span').textContent = totalCost.toLocaleString('vi-VN') + ' VNĐ';
    document.querySelector('.payable-amount span').textContent = totalCost.toLocaleString('vi-VN') + ' VNĐ';
</script>
