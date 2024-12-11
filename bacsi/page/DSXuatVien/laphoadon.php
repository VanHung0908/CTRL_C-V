<?php
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mHoaDon.php');
$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
if (!$MaBN) {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Không có dữ liệu bệnh nhân.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    exit; // Dừng tiếp tục xử lý khi không có MaBN
}
$con = new mBenhNhan();
$dsBenhNhan = $con->getBenhNhanXV($MaBN);
if (empty($dsBenhNhan)) {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Không có dữ liệu bệnh nhân.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    exit;
}
$benhNhan = $dsBenhNhan[0];
$ThoiGianNV=$benhNhan['ThoiGianNV'];
$ThoiGianXV=$benhNhan['ThoiGianXV'];

include_once(BACKEND_URL . 'model/mPKQK.php');
$conkqk = new mPKQK();
$KQKB = $conkqk->getselectPhacDo($MaBN, $ThoiGianNV, $ThoiGianXV); 

if (!empty($KQKB) && is_array($KQKB)) {
    $donthuoc = []; // Mảng để lưu tất cả đơn thuốc

    // Lặp qua tất cả các kết quả trả về
    foreach ($KQKB as $kq) {
        $MaDonThuoc = isset($kq['MaDonThuoc']) ? $kq['MaDonThuoc'] : null;

        if ($MaDonThuoc) {
            // Lấy đơn thuốc cho mỗi mã đơn thuốc
            $donthuoc[] = $conkqk->getThuoc($MaDonThuoc);
        }
    }

    // Nếu không có mã đơn thuốc, mảng $donthuoc sẽ vẫn rỗng
} else {
    $KQKB = null; // Đặt null nếu không có kết quả
    $donthuoc = []; // Đặt mảng rỗng nếu không có đơn thuốc
}
$thoiGianNV = strtotime($benhNhan['ThoiGianNV']);
$thoiGianXV = strtotime($benhNhan['ThoiGianXV']);
$soNgay = ($thoiGianXV - $thoiGianNV) / (60 * 60 * 24);
$giaPhong = $benhNhan['Gia'];
$tongChiPhi = $giaPhong * $soNgay;
?>
<div class="main-content" id="main-content">
<h2 class="text-center mb-4">Lập hóa đơn</h2>
<hr class="divider">
<form method="POST" >
    <fieldset class="border p-4 mb-4 rounded bg-white">
        <legend class="w-auto px-3">Thông tin bệnh nhân</legend>
        <div class="mb-3">
            <label for="patientName" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="patientName"  value="<?php echo $benhNhan['HoTen']; ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="patientAge" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control"  value="<?php echo $benhNhan['NgaySinh']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="patientGender" class="form-label"  >Giới tính</label>
                <input type="text" class="form-control"  value="<?php echo $benhNhan['GioiTinh']; ?>">
            </div>
        </div>
      
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="patientGender" class="form-label"  >Chẩn đoán ban đầu</label>
                <input type="text" class="form-control"  value="<?php echo $benhNhan['ChuanDoanBD']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="patientAge" class="form-label">Chẩn đoán kết quả</label>
                <input type="text" class="form-control"  value="<?php echo $benhNhan['ChuanDoanKQ']; ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="patientName" class="form-label">Phương pháp điều trị</label>
            <input type="text" class="form-control" id="patientName"  value="<?php echo $benhNhan['PhuongPhapDieuTri']; ?>">
        </div>
    </fieldset>
    <fieldset class="border p-4 mb-4 rounded bg-white">
    <legend class="w-auto px-3">Chi phí phòng</legend>
        <table class="table-cost table-light" id="chiphigiuong" >
            <thead>
                    <tr>
                        <th>Phòng</th>
                        <th>Giá phòng</th>
                        <th>Ngày nhập viện</th>
                        <th>Ngày xuất viện</th>
                        <th>Tổng ngày</th>
                        <th>Thành tiền</th>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($benhNhan['TenPhong']); ?></td>
                        <td><?php echo number_format($giaPhong, 0, ',', '.'); ?> </td>
                        <td><?php echo htmlspecialchars($benhNhan['ThoiGianNV']); ?></td>
                        <td><?php echo htmlspecialchars($benhNhan['ThoiGianXV']); ?></td>
                        <td><?php echo $soNgay; ?> ngày</td>
                        <td><?php echo number_format($tongChiPhi, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
            </thead>
        </table>
    </fieldset>

    <fieldset class="border p-4 mb-4 rounded bg-white">
    <legend class="w-auto px-3">Chi phí thuốc</legend>

    <!-- <h4>Chi tiết chi phí</h4> -->
    <?php if (!empty($donthuoc)): ?>
    <table class="table-cost table-light" id="chiphithuoc">
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
        // Lặp qua tất cả các mảng con trong $donthuoc
        foreach ($donthuoc as $thuocList) {
            // Kiểm tra xem đây có phải là nhóm thuốc đầu tiên hay không
            $isFirstRow = true; 

            // Lặp qua các thuốc trong mỗi mảng con
            foreach ($thuocList as $thuoc) {
                $thanhTien = $thuoc['SoLuong'] * $thuoc['Gia'];
                $totalCost += $thanhTien;
        ?>
        <tr>
            <!-- Chỉ hiển thị "Thuốc" một lần cho mỗi nhóm -->
            <td><?php echo $isFirstRow ? 'Thuốc (' . htmlspecialchars($thuoc['NgayLap']) . ')' : ''; ?></td>
            <td><?php echo htmlspecialchars($thuoc['TenThuoc']); ?></td>
            <td><?php echo htmlspecialchars($thuoc['SoLuong']); ?> <?php echo htmlspecialchars($thuoc['DonViTinh']); ?></td>
            <td><?php echo number_format($thuoc['Gia'], 0, ',', '.'); ?></td>
            <td><?php echo number_format($thanhTien, 0, ',', '.'); ?></td>
        </tr>
        <?php 
                // Đặt $isFirstRow thành false sau khi dòng đầu tiên đã được hiển thị
                $isFirstRow = false;
            }
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Tổng cộng</td>
                <td><?php echo number_format($totalCost, 0, ',', '.'); ?> VNĐ</td>
            </tr>
        </tfoot>
    </table>

    <?php else: ?>
        <p>Chưa có dữ liệu đơn thuốc.</p>
    <?php endif; ?>

</fieldset>
<fieldset class="border p-4 mb-4 rounded bg-white">
    <legend class="w-auto px-3">Tổng chi phi</legend>

<?php
$totalAllCost = $tongChiPhi + ($totalCost ?? 0);
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
$bhytPayment = ($percentBHYT / 100) * $totalAllCost;
$patientPayment = $totalAllCost - $bhytPayment;
$amountDue = $patientPayment - $benhNhan['TamUng']; 
    if ($amountDue < 0) {
        $amountDue = 0; // Đảm bảo số tiền cần thanh toán không âm
        $refundAmount = abs($patientPayment - $benhNhan['TamUng']); // Số tiền bệnh viện cần hoàn trả cho bệnh nhân
    } else {
        $refundAmount = 0; // Không có số tiền dư nếu số tiền bệnh nhân cần trả
    }
?>
    
<form method="POST" >
    <!-- Các thông tin hiển thị khác -->
    <p class="total-amount"><strong>Phần trăm BHYT:</strong> <span><?php echo $percentBHYT; ?>%</span></p>
    <p class="total-amount"><strong>Tổng chi phí:</strong> <span><?php echo number_format($totalAllCost, 0, ',', '.'); ?> VNĐ</span></p>
    <p class="total-amount"><strong>Tổng thanh toán BHYT trả:</strong> <span><?php echo number_format($bhytPayment, 0, ',', '.'); ?> VNĐ</span></p>
    <p class="total-amount"><strong>Tạm ứng:</strong> <span><?php  echo number_format($benhNhan['TamUng'], 0, ',', '.'); ?> VNĐ</span></p>
    <!-- Hiển thị tạm ứng và số tiền còn phải thanh toán -->
        <p class="payable-amount"><strong>Số tiền bệnh nhân cần thanh toán:</strong> <span><?php echo number_format($amountDue, 0, ',', '.'); ?> VNĐ</span></p>
        <?php if ($refundAmount > 0): ?>
            <!-- Hiển thị số tiền bệnh viện cần hoàn trả -->
            <p class="payable-amount"><strong>Số tiền bệnh viện cần hoàn trả:</strong> <span><?php echo number_format($refundAmount, 0, ',', '.'); ?> VNĐ</span></p>
        <?php endif; ?>
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
    </fieldset>

    <!-- Nút xác nhận -->
    <button type="submit" class="btn-payment" name= "btn_thanhtoan">Thanh toán</button>
</form>

</div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$TongTienPhong=$tongChiPhi;
$TongTienThuoc=$totalCost;
$TongNgay=$soNgay;
$TongChiPhi=$totalAllCost;
$TamUng=$benhNhan['TamUng'];
$MaNS=$benhNhan['MaNS'];
$SoTienBNTT=$amountDue;
$SoTienBVTT=$refundAmount;
$percentBHYT;
$MaBN;
$MaNV=$benhNhan['MaNV'];
$PhuongThucThanhToan = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;
$con = new mHoaDon();
$insertHD = $con->insertHD($TongTienPhong,$TongTienThuoc,$TongNgay,$TongChiPhi,$TamUng,$SoTienBNTT,$SoTienBVTT,$percentBHYT,$MaBN,$MaNV,$MaNS,$PhuongThucThanhToan);

if ($insertHD) {
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Lập hóa đơn xuất viện thành công!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/QLBV/bacsi/index.php?page=DSxuatvien';
                }
            });
        </script>";
} else {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Thất bại',
        text: 'Lập hóa đơn xuất viện thất bại!',
        confirmButtonText: 'Thử lại'
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.back();
        }
    });
</script>";
}
}
?>