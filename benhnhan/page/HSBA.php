<?php 
include_once '../layout/header.php';
$MaBN=$_SESSION['maBN'];
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mPhieuDKKham.php');

$con = new mBenhNhan(); 

$result = $con->getAllBenhNhan($MaBN);
if ($result && mysqli_num_rows($result) > 0) {
    $benhNhan = mysqli_fetch_assoc($result); 
} else {
    $benhNhan = []; 
    echo "Không tìm thấy bệnh nhân.";
}

$con = new mPhieuDKKham(); 
$resultPDKK = $con->getPDKK($MaBN);

$con = new mPhieuDKKham(); 
$resultKQK = $con->getKQK($MaBN);

?>

<!-- Header -->
<div class="section-2-1-1">
    <div class="inner-wrap wow fadeInRight">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10">
                    <!-- Thông tin cá nhân bệnh nhân -->
                    <div class="ttcnbn-info-section">
                        <div class="ttcnbn-card">
                         <form action="" method="post">    
                            <div class="ttcnbn-card-header">
                                <h4 class="mb-0">Thông Tin Cá Nhân</h4>
                                <button type="submit" class="btn btn-light btn-sm text-primary" >Cập Nhật</button>
                            </div>
                            <div class="ttcnbn-card-body">
                            <div class="row">
                                    <div class="col-md-6">
                                    <p><strong>Họ tên:</strong>
                                        <input type="text" class="form-control" id="patientName" name="HoTen" value="<?php echo isset($benhNhan['HoTen']) ? $benhNhan['HoTen'] : ''; ?>">
                                    <p><strong>Ngày sinh:</strong>
                                        <input type="date" class="form-control" name ="NgaySinh" value="<?php echo isset($benhNhan['NgaySinh']) ? $benhNhan['NgaySinh'] : ''; ?>" />
                                    <p><strong>Giới tính:</strong> 
                                        <select class="form-control" id="GioiTinh" name="GioiTinh">
                                            <option value="Nam" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                            <option value="Nữ" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                            <option value="Khác" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Địa chỉ:</strong> 
                                            <input type="text" class="form-control" placeholder="Nhập địa chỉ"  name="DiaChi" value="<?php echo isset($benhNhan['DiaChi'])?$benhNhan['DiaChi']:''; ?>">
                                       
                                        <p><strong>Số điện thoại:</strong> 
                                            <input type="text" class="form-control" placeholder="Nhập số SDT" name="SDT" value="<?php echo isset($benhNhan['SDT'])?$benhNhan['SDT']:''; ?>">
                                        
                                        <p><strong>CCCD:</strong> 
                                            <input type="text" class="form-control" placeholder="Nhập số CCCD" name="CCCD" value="<?php echo isset($benhNhan['CCCD'])?$benhNhan['CCCD']:''; ?>">
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                    <!-- Bảng lịch khám -->
                    <div class="ttcnbn-card">
                        <div class="ttcnbn-card-header bg-primary">
                            <h4 class="mb-0">Lịch Đăng Ký Khám Bệnh</h4>
                        </div>
                        <div class="ttcnbn-card-body">
                            <table class="ttcnbn-table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Ngày Giờ</th>
                                        <th>Bác Sĩ</th>
                                        <th>Khoa Khám</th>
                                        <th>Số Tiền Thanh Toán</th>
                                        <th>Trạng Thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     if (!empty($resultPDKK)) {
                                        foreach ($resultPDKK as $row) {
                                            echo '<tr>';
                                            echo '<td>' . (isset($row['NgayKham']) ? $row['NgayKham'] : '') . '</td>';
                                            echo '<td>' . (isset($row['HoTen']) ? $row['HoTen'] : '') . '</td>';
                                            echo '<td>' . (isset($row['TenKhoa']) ? $row['TenKhoa'] : '') . '</td>';
                                            echo '<td>' . (isset($row['ChiPhiKham']) ? $row['ChiPhiKham'] : '') . '</td>';
                                            echo '<td>' . (isset($row['TrangThai']) ? $row['TrangThai'] : '') . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        // Nếu không có dữ liệu, hiển thị một dòng trống hoặc thông báo
                                        echo '<tr><td colspan="5">Không có dữ liệu để hiển thị.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bảng kết quả khám bệnh -->
                    <div class="mt-4">
                        <div class="ttcnbn-card">
                            <div class="ttcnbn-card-header bg-success">
                                <h4 class="mb-0">Kết Quả Khám Bệnh</h4>
                            </div>
                            <div class="ttcnbn-card-body">
                                <table class="ttcnbn-table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ngày khám</th>
                                            <th>Ngày tái khám</th>
                                            <th>Bác sĩ</th>
                                            <th>Chẩn đoán</th>
                                            <th>Đơn thuốc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                     if (!empty($resultKQK)) {
                                        foreach ($resultKQK as $row) {
                                            echo '<tr>';
                                            echo '<td>' . (isset($row['NgayKham']) ? $row['NgayKham'] : '') . '</td>';
                                            echo '<td>' . (isset($row['NgayTaiKham']) ? $row['NgayTaiKham'] : '') . '</td>';
                                            echo '<td>' . (isset($row['HoTen']) ? $row['HoTen'] : '') . '</td>';
                                            echo '<td>' . (isset($row['ChanDoan']) ? $row['ChanDoan'] : '') . '</td>';
                                            ?>
                                            <td>
                                                    <?php if (isset($row['MaDonThuoc'])): ?>
                                                        <a href="#" data-toggle="modal" data-target="#modalChiTietDonThuoc" onclick="loadChiTietDonThuoc('<?php echo $row['MaDonThuoc']; ?>')">
                                                            Chi tiết đơn thuốc
                                                        </a>
                                                    <?php else: ?>
                                                        Không có đơn thuốc
                                                    <?php endif; ?>
                                                </td>

                                            <?php
                                            echo '</tr>';
                                        }
                                    } else {
                                        // Nếu không có dữ liệu, hiển thị một dòng trống hoặc thông báo
                                        echo '<tr><td colspan="5">Không có dữ liệu để hiển thị.</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="mt-3">
                        <p><strong>Lưu ý:</strong> Vui lòng mang theo CMND hoặc CCCD khi đến khám. Nếu cần hỗ trợ, liên hệ hotline <a href="tel:+840123456789">0123 456 789</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../layout/footer.php'; ?>

<?php
    $HoTen = isset($_POST['HoTen'])? $_POST['HoTen'] : null;
    $NgaySinh = isset($_POST['NgaySinh']) ? $_POST['NgaySinh'] : null;
    $GioiTinh = isset($_POST['GioiTinh']) ? $_POST['GioiTinh'] : null;
    $DiaChi = isset($_POST['DiaChi']) ? $_POST['DiaChi'] : null;
    $SDT = isset($_POST['SDT']) ? $_POST['SDT'] : null;
    $CCCD = isset($_POST['CCCD']) ? $_POST['CCCD'] : null;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $benhnhan = new mBenhNhan();
    if (empty($NgaySinh) || empty($GioiTinh)  || empty($MaBN) || empty($DiaChi)|| empty($SDT)|| empty($CCCD)) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin',
                text: 'Vui lòng nhập đầy đủ thông tin trước khi lưu!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
        exit; 
    }

    $result = $benhnhan->updateTT($HoTen, $NgaySinh, $GioiTinh, $DiaChi,$SDT, $CCCD,$MaBN);
    
    // Hiển thị thông báo và chuyển hướng
    if ($result) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Cập nhật thông tin thành công!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/QLBV/bacsi/index.php?page=DSBN';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Thất bại',
                text: 'Cập nhật thông tin thất bại!',
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
   <div class="modal fade" id="modalChiTietDonThuoc" tabindex="-1" aria-labelledby="modalChiTietDonThuocLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalChiTietDonThuocLabel">Chi tiết đơn thuốc</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Nội dung sẽ được tải động -->
                <table class="table table-striped table-bordered table-hover table-costt">
                    <thead>
                        <tr>
                            <th>Loại chi phí</th>
                            <th>Tên</th>
                            <th>Số lượng</th>
                            <th>Liệu dùng</th>
                            <th>Cách dùng</th>
                            <th>Giá (VNĐ)</th>
                            <th>Thành tiền (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody id="chiTietDonThuocBody">
                        <!-- Dữ liệu sẽ được thêm ở đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function loadChiTietDonThuoc(maDonThuoc) {
    
    fetch(`getChiTietDonThuoc.php?maDonThuoc=${maDonThuoc}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Server trả về lỗi: ' + response.status);
        }
        return response.text(); // Lấy dữ liệu dưới dạng text thay vì json
    })
    .then(data => {
        console.log('Dữ liệu từ server:', data); // In ra phản hồi thô từ server
        try {
            const jsonData = JSON.parse(data); // Chuyển đổi dữ liệu sang JSON
            console.log(jsonData); // Kiểm tra dữ liệu JSON
            const tbody = document.getElementById('chiTietDonThuocBody');
            tbody.innerHTML = ''; // Xóa nội dung cũ

            let totalCost = 0;
            jsonData.forEach(thuoc => {
                const soLuong = parseFloat(thuoc.SoLuong);
                const gia = parseFloat(thuoc.Gia);
                const thanhTien = soLuong * gia; // Tính thành tiền
                totalCost += thanhTien;

                const row = `
                    <tr>
                        <td>Thuốc</td>
                        <td>${thuoc.TenThuoc}</td>
                        <td>${soLuong} ${thuoc.DonViTinh}</td>
                        <td>${thuoc.LieuDung} </td>
                        <td>${thuoc.CachDung} </td>
                        <td>${new Intl.NumberFormat('vi-VN').format(gia)}</td>
                        <td>${new Intl.NumberFormat('vi-VN').format(thanhTien)}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            // Thêm tổng tiền
            const totalRow = `
                <tr>
                    <td colspan="6" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                    <td><strong>${new Intl.NumberFormat('vi-VN').format(totalCost)}</strong></td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', totalRow);
        } catch (error) {
            console.error('Lỗi khi chuyển đổi dữ liệu sang JSON:', error);
        }
    })
    .catch(error => {
        console.error('Lỗi khi tải chi tiết đơn thuốc:', error);
    });

}


</script>