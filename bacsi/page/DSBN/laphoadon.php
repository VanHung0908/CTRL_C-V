<?php
include_once(BACKEND_URL . 'model/mBenhNhan.php');
$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
$con = new mBenhNhan();
$dsBenhNhan = $con->getTTBN($MaBN);
$benhNhan = $dsBenhNhan[0];
include_once(BACKEND_URL . 'model/mPKQK.php');
$conkqk = new mPKQK();
$KQKB = $conkqk->getslectKQK($MaBN); 
$KQKB = $conkqk->getslectKQK($MaBN);

// Kiểm tra xem $KQKB có hợp lệ không
if (!empty($KQKB) && is_array($KQKB)) {
    $KQKB = $KQKB[0];
    $MaDonThuoc = isset($KQKB['MaDonThuoc']) ? $KQKB['MaDonThuoc'] : null;

    if ($MaDonThuoc) {
        $donthuoc = $conkqk->getThuoc($MaDonThuoc);
    } else {
        $donthuoc = []; // Nếu không có mã đơn thuốc, đặt mảng rỗng
    }
} else {
    $KQKB = null; // Đặt null nếu không có kết quả
    $donthuoc = []; // Đặt mảng rỗng nếu không có đơn thuốc
}


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
    <h3>Hóa Đơn Thanh Toán</h3>
    <hr class="divider">
    <h4>Thông tin bệnh nhân</h4>
    <p><strong>Tên bệnh nhân:</strong> <?php echo !empty($benhNhan['HoTen']) ? htmlspecialchars($benhNhan['HoTen']) : "Chưa có dữ liệu"; ?></p>
    <p><strong>Mã bệnh nhân:</strong> <?php echo !empty($benhNhan['MaBN']) ? htmlspecialchars($benhNhan['MaBN']) : "Chưa có dữ liệu"; ?></p>
    <p><strong>Ngày sinh:</strong> <?php echo !empty($benhNhan['NgaySinh']) ? htmlspecialchars($benhNhan['NgaySinh']) : "Chưa có dữ liệu"; ?></p>
    <p><strong>Giới tính:</strong> <?php echo !empty($benhNhan['GioiTinh']) ? htmlspecialchars($benhNhan['GioiTinh']) : "Chưa có dữ liệu"; ?></p>
    <p><strong>Chẩn đoán:</strong> <?php echo !empty($KQKB['ChanDoan']) ? htmlspecialchars($KQKB['ChanDoan']) : "Chưa có dữ liệu"; ?></p>
    <p><strong>Ngày tái khám:</strong> <?php echo !empty($KQKB['NgayTaiKham']) ? htmlspecialchars($KQKB['NgayTaiKham']) : "Chưa có dữ liệu"; ?></p>

    <h4>Chi tiết chi phí</h4>
    <?php if (!empty($donthuoc)): ?>
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
<?php else: ?>
    <p>Chưa có dữ liệu đơn thuốc.</p>
<?php endif; ?>

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
$totalCost = $totalCost ?? 0;
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
