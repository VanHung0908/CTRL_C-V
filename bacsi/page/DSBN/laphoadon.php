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
$donthuoc= $conkqk->getThuoc($MaDonThuoc); 

if (isset($_POST['btn_thanhtoan'])) {
    $phuongThucThanhToan = $_POST['payment_method'];

    include_once(BACKEND_URL . 'model/mHoaDon.php');
    $p = new mHoaDon();

    $isUpdated = $p->updateHoadon($MaDonThuoc, $phuongThucThanhToan,$MaBN);

    if ($isUpdated) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Thành công",
                text: "Thanh toán hóa đơn thành công!",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "/QLBV/bacsi/index.php?page=DSBN";
            });
        </script>';
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Thanh toán thất bại. Vui lòng thử lại.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    }
    
    
}

?>
<div class="main-content" id="main-content">
    <h3 class="header-title">Hóa Đơn Thanh Toán</h3>

    <h3>Thông tin bệnh nhân</h3>
    <p><strong>Tên bệnh nhân:</strong> <?php echo htmlspecialchars($benhNhan['HoTen']); ?></p>
    <p><strong>Mã bệnh nhân:</strong> <?php echo htmlspecialchars($benhNhan['MaBN']); ?></p>
    <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($benhNhan['NgaySinh']); ?></p>
    <p><strong>Giới tính:</strong> <?php echo htmlspecialchars($benhNhan['GioiTinh']); ?></p>
    <p><strong>ChuanDoan:</strong> <?php echo htmlspecialchars($KQKB['ChanDoan']); ?></p>
    <p><strong>Ngày tái khám:</strong> <?php echo htmlspecialchars($KQKB['NgayTaiKham']); ?></p>

    <h3>Chi tiết chi phí</h3>
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
            <?php 
            $totalCost = 0;
            foreach ($donthuoc as $thuoc) {
                $thanhTien = $thuoc['SoLuong'] * $thuoc['Gia'];
                $totalCost += $thanhTien;
            ?>
            <tr>
                <td>Thuốc</td>
                <td><?php echo htmlspecialchars($thuoc['TenThuoc']); ?></td>
                <td><?php echo htmlspecialchars($thuoc['SoLuong']); ?> <?php echo htmlspecialchars($thuoc['DonViTinh']); ?></td>
                <td><?php echo number_format($thuoc['Gia'], 0, ',', '.'); ?></td>
                <td><?php echo number_format($thanhTien, 0, ',', '.'); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
$percentBHYT = 0;
switch ($benhNhan['LoaiBHYT']) {
    case 1:
    case 2:
    case 5:
        $percentBHYT = 100;
        break;
    case 3:
        $percentBHYT = 95;
        break;
    case 4:
        $percentBHYT = 80;
        break;
    default:
        $percentBHYT = 0; 
}

$bhytPayment = ($percentBHYT / 100) * $totalCost;
$patientPayment = $totalCost - $bhytPayment;
?>
    
<form method="POST" >
    <!-- Các thông tin hiển thị khác -->
    <p class="total-amount"><strong>Phần trăm BHYT:</strong> <span><?php echo $percentBHYT; ?>%</span></p>
    <p class="total-amount"><strong>Tổng chi phí:</strong> <span><?php echo number_format($totalCost, 0, ',', '.'); ?> VNĐ</span></p>
    <p class="total-amount"><strong>Tổng thanh toán BHYT trả:</strong> <span><?php echo number_format($bhytPayment, 0, ',', '.'); ?> VNĐ</span></p>
    <p class="payable-amount"><strong>Số tiền bệnh nhân cần thanh toán:</strong> <span><?php echo number_format($patientPayment, 0, ',', '.'); ?> VNĐ</span></p>

    <!-- Phương thức thanh toán -->
    <p class="payment-method">
        <strong>Phương thức thanh toán:</strong><br>
        <label>
            <input type="radio" name="payment_method" value="Tiền mặt" checked> Tiền mặt
        </label><br>
        <label>
            <input type="radio" name="payment_method" value="Chuyển khoản"> Chuyển khoản
        </label>
    </p>

    <!-- Nút xác nhận -->
    <button type="submit" class="btn-payment" name= "btn_thanhtoan">Thanh toán</button>
</form>

</div>
