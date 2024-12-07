<?php
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mNamVien.php'); 

$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
$con = new mBenhNhan();
$dsBenhNhan = $con->getTTBNNV($MaBN);
$benhNhan = $dsBenhNhan[0];
$MaKhoa=$benhNhan['MaKhoa'];

include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mPhong.php');
$mPhong = new mPhong();
$phongs = $mPhong->getPhongsByKhoa($MaKhoa);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $HoTen = isset($_POST['HoTen']) ? $_POST['HoTen'] : '';
    $GioiTinh = isset($_POST['GioiTinh']) ? $_POST['GioiTinh'] : '';
    $SDT = isset($_POST['SDT']) ? $_POST['SDT'] : '';
    $CCCD = isset($_POST['CCCD']) ? $_POST['CCCD'] : '';
    $BHYT = isset($_POST['BHYT']) ? $_POST['BHYT'] : '';
    $DiaChi = isset($_POST['DiaChi']) ? $_POST['DiaChi'] : '';
    $TenNguoiLienHe = isset($_POST['TenNguoiLienHe']) ? $_POST['TenNguoiLienHe'] : '';
    $QuanHe = isset($_POST['QuanHe']) ? $_POST['QuanHe'] : '';
    $TamUng = isset($_POST['TamUng']) ? $_POST['TamUng'] : 0;
    $QuanHe = isset($_POST['QuanHe']) ? $_POST['QuanHe'] : '';
    $MaPhon = isset($_POST['phong']) ? $_POST['phong'] : '';
    $MaGiuon = isset($_POST['giuong']) ? $_POST['giuong'] : '';
    $MaPhong= htmlspecialchars($MaPhon);
    $MaGiuong= htmlspecialchars($MaGiuon);
    try {
        // Cập nhật thông tin bệnh nhân
        $benhNhanModel = new mBenhNhan();
        $result1 = $benhNhanModel->updateBenhNhan($MaBN, $HoTen, $GioiTinh, $SDT, $CCCD, $BHYT, $DiaChi);
    
        // Cập nhật thông tin nhập viện
        $nhapVienModel = new NamVien();
        $result2 = $nhapVienModel->updateNhapVien($MaBN, $TenNguoiLienHe, $QuanHe, $TamUng,$MaPhong,$MaGiuong);
    
        if ($result1 && $result2) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: 'Cập nhật thông tin thành công!',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/QLBV/bacsi/index.php?page=DSnhapvien';
                    }
                });
            </script>";
        } elseif ($result1) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: 'Cập nhật thông tin thành công!',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/QLBV/bacsi/index.php?page=DSnhapvien';
                    }
                });
            </script>";
        } elseif ($result2) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: 'Cập nhật thông tin nhập viện thành công!',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/QLBV/bacsi/index.php?page=DSnhapvien';
                    }
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại',
                    text: 'Không có thay đổi nào được thực hiện hoặc có lỗi xảy ra.',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    
    } catch (Exception $e) {
        echo 'Lỗi: ' . $e->getMessage();
    }
    
    
}
?>
<div class="main-content" id="main-content">
    <h3>Lập thủ tục nhập viện</h3>
    <hr class="divider">
    <form method="post" > 
        <div class="row">
            <div class="col-md-6">
                <div class="form-section">
                    <h5>Thông tin bệnh nhân</h5>
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="patientName" name="HoTen" 
                               value="<?php echo htmlspecialchars($benhNhan['HoTen']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="patientGender" class="form-label">Giới tính</label>
                        <input type="text" class="form-control" id="patientGender" name="GioiTinh" 
                               value="<?php echo htmlspecialchars($benhNhan['GioiTinh']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="patientPhone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="patientPhone" name="SDT" 
                               value="<?php echo htmlspecialchars($benhNhan['SDT']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="patientCCCD" class="form-label">CCCD</label>
                        <input type="text" class="form-control" id="patientCCCD" name="CCCD" 
                               value="<?php echo htmlspecialchars($benhNhan['CCCD']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="patientBHYT" class="form-label">BHYT</label>
                        <input type="text" class="form-control" id="patientBHYT" name="BHYT" 
                               value="<?php echo htmlspecialchars($benhNhan['BHYT']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="patientAddress" class="form-label">Địa chỉ thường trú</label>
                        <input type="text" class="form-control" id="patientAddress" name="DiaChi" 
                               value="<?php echo htmlspecialchars($benhNhan['DiaChi']); ?>">
                    </div>
                </div>
            </div>

            <!-- Thông tin người nhà -->
            <div class="col-md-6">
                <div class="form-section">
                    <h5>Thông tin người nhà</h5>
                    <div class="mb-3">
                        <label for="relativeName" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="relativeName" name="TenNguoiLienHe" 
                               value="<?php echo htmlspecialchars($benhNhan['TenNguoiLienHe']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="relativeRelation" class="form-label">Quan hệ</label>
                        <input type="text" class="form-control" id="relativeRelation" name="QuanHe" 
                               value="<?php echo htmlspecialchars($benhNhan['QuanHe']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="relativeDeposit" class="form-label">Tạm ứng</label>
                        <input type="number" class="form-control" id="relativeDeposit" name="TamUng" 
                               value="<?php echo htmlspecialchars($benhNhan['TamUng']); ?>">
                    </div>

                    <h5>Thông tin phòng bệnh</h5>
                    <div class="mb-3">
                        <label for="roomName" class="form-label">Phòng hiện tại</label>
                        <input type="hidden" id="roomId" name="MaPhong" value="<?php echo htmlspecialchars($benhNhan['MaPhong']); ?>">
                        <input type="text" class="form-control" id="roomName" name="TenPhong" 
                            value="<?php echo htmlspecialchars($benhNhan['TenPhong']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phong">Phòng muốn thay đổi</label>
                        <select name="phong" class="form-control" id="room">
                            <option value="">Chọn phòng</option>
                            <?php
                                if (!empty($phongs)) {
                                    foreach ($phongs as $phong) {
                                        echo '<option value="' . htmlspecialchars($phong['MaPhong']) . '">' . htmlspecialchars($phong['TenPhong']) . '</option>';
                                    }
                                } else {
                                        echo '<option value="">Không có phòng nào</option>';
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bedName" class="form-label">Phòng muốn thay đổi</label>
                        <input type="hidden" id="bedId" name="MaGiuong" value="<?php echo htmlspecialchars($benhNhan['MaGiuong']); ?>">
                        <input type="text" class="form-control" id="bedName" name="TenGiuong" 
                            value="<?php echo htmlspecialchars($benhNhan['TenGiuong']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="giuong">Chọn giường</label>
                        <select name="giuong" class="form-control" id="giuong">
                            <option value="">Chọn giường</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-submit" style="background-color: #007bff; color: white;">Lưu</button>
        </div>
    </form>
</div>
<script>

    //Giường
    document.getElementById('room').addEventListener('change', function() {
    var MaPhong = this.value; 
    var giuongSelect = document.getElementById('giuong');
    if (!MaPhong) {
            roomSelect.innerHTML = '<option value="">Chọn giường</option>';
            return;
        }

    if (MaPhong) {
        // Gửi yêu cầu AJAX để lấy giường theo MaPhong
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/QLBV/ajax/getGiuongByPhong.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
             if (xhr.responseText.trim() === "") {
                    alert("Dữ liệu trả về từ server rỗng!");
                    return;
                }
            try {
                var giuongs = JSON.parse(xhr.responseText);
                

                // Xóa các option cũ trong select giường
                giuongSelect.innerHTML = '<option value="">Chọn giường</option>';

                // Thêm các giường mới vào select
                giuongs.forEach(function(giuong) {
                    var option = document.createElement('option');
                    option.value = giuong.MaGiuong;
                    option.textContent = giuong.TenGiuong;
                    giuongSelect.appendChild(option);
                });
            } catch (e) {
                console.error("Lỗi khi parse JSON:", e);
            }
        } else {
            alert('Có lỗi khi lấy dữ liệu giường.');
        }
    };

        xhr.send('MaPhong=' + MaPhong);
    } else {
        // Nếu không có MaPhong, xóa các option trong select giường
        document.getElementById('giuong').innerHTML = '<option value="">Chọn giường</option>';
    }
});
</script>