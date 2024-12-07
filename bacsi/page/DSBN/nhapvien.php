<?php
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mKhoa.php');
include_once(BACKEND_URL . 'model/mNamVien.php'); 

$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
$MaKhoa = isset($_POST['MaKhoa']) ? $_POST['MaKhoa'] : null;
$ChuanDoanBD = isset($_POST['ChuanDoanBD']) ? $_POST['ChuanDoanBD'] : null;
$TienSuBenh = isset($_POST['TienSuBenh']) ? $_POST['TienSuBenh'] : null;
$ThuocDangSD = isset($_POST['ThuocDangSD']) ? $_POST['ThuocDangSD'] : null;
$LyDo = isset($_POST['LyDo']) ? $_POST['LyDo'] : null;

$con = new mBenhNhan();
$dsBenhNhan = $con->getTTBN($MaBN);
$benhNhan = $dsBenhNhan[0];

$con = new mKhoa();
$dsKhoa = $con->dsKhoa();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namVienModel = new NamVien();
    $thoiGianNV = date('Y-m-d');

    // Kiểm tra dữ liệu đầu vào
    if (empty($LyDo) || empty($ChuanDoanBD) || empty($TienSuBenh) || empty($ThuocDangSD) || empty($MaBN) || empty($MaKhoa)) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin',
                text: 'Vui lòng nhập đầy đủ thông tin trước khi thêm phiếu nhập viện!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
        exit; // Dừng xử lý nếu dữ liệu bị thiếu
    }

    // Gọi phương thức để thêm phiếu nhập viện
    $result = $namVienModel->insertPhieuNamVien($LyDo, $ChuanDoanBD, $thoiGianNV, $TienSuBenh, $ThuocDangSD, $MaBN, $MaKhoa);
    
    // Hiển thị thông báo và chuyển hướng
    if ($result) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Thêm phiếu nhập viện thành công!',
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
                text: 'Thêm phiếu nhập viện thất bại!',
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

<div class="main-content" id="main-content">
    <h3>Lập thủ tục nhập viện</h3>
    <hr class="divider">
    <form method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-section">
                    <h5>Thông tin bệnh nhân</h5>
                    <!-- Các trường thông tin bệnh nhân -->
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="patientName" value="<?php echo $benhNhan['HoTen']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="patientDOB" class="form-label">Ngày sinh</label>
                        <input type="text" class="form-control" id="patientDOB" value="<?php echo $benhNhan['NgaySinh']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="patientGender" class="form-label">Giới tính</label>
                        <input type="text" class="form-control" id="patientGender" value="<?php echo $benhNhan['GioiTinh']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="patientPhone" class="form-label">SDT</label>
                        <input type="text" class="form-control" id="patientPhone" value="<?php echo $benhNhan['SDT']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="patientCCCD" class="form-label">CCCD</label>
                        <input type="text" class="form-control" id="patientCCCD" value="<?php echo $benhNhan['CCCD']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="patientBHYT" class="form-label">BHYT</label>
                        <input type="text" class="form-control" id="patientBHYT" value="<?php echo $benhNhan['BHYT']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="patientAddress" class="form-label">Địa chỉ thường trú</label>
                        <input type="text" class="form-control" id="patientAddress" value="<?php echo $benhNhan['DiaChi']; ?>" >
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-section">
                    <h5>Thông tin nhập viện</h5>
                    <div class="mb-3">
                        <label for="department" class="form-label">Khoa</label>
                        <select class="form-select" id="department" name="MaKhoa">
                            <option selected disabled>Chọn khoa</option>
                            <?php foreach ($dsKhoa as $khoa) { ?>
                                <option value="<?php echo $khoa['MaKhoa']; ?>"><?php echo $khoa['TenKhoa']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Bệnh chuẩn đoán</label>
                        <input type="text" class="form-control" id="diagnosis" name="ChuanDoanBD">
                    </div>
                    <div class="mb-3">
                        <label for="medicalHistory" class="form-label">Tiền sử bệnh</label>
                        <textarea class="form-control" id="medicalHistory" name="TienSuBenh" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="medications" class="form-label">Các loại thuốc đang sử dụng</label>
                        <textarea class="form-control" id="medications" name="ThuocDangSD" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="admissionReason" class="form-label">Lý do nhập viện</label>
                        <textarea class="form-control" id="admissionReason" name="LyDo" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-submit" style="background-color: #007bff; color: white;">Nhập viện</button>
        </div>
    </form>
</div>
