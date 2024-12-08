<?php
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
$MaNS = $_SESSION['maNS'];
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mNamVien.php'); 
$con = new mBenhNhan(); 

$BenhNhan = $con->getBenhNhan($MaBN);
if (empty($BenhNhan)) {
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
$benhNhan = $BenhNhan[0]; 
include_once(BACKEND_URL . 'model/mThuoc.php');
$conThuoc = new mThuoc();
$dsThuoc = $conThuoc->getAllThuoc(); 

?>
<div class="main-content" id="main-content">
    <h2 class="text-center mb-4">Lập phiếu xuất viện</h2>
    <hr class="divider">
    <form method="POST">
        <!-- Thông tin bệnh nhân -->
        <fieldset class="border p-4 mb-4 rounded bg-white">
            <legend class="w-auto px-3">Thông tin bệnh nhân</legend>
            <div class="mb-3">
                <label for="patientName" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="patientName" value="<?php echo $benhNhan['HoTen']; ?>">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="patientAge" class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" id="patientAge" value="<?php echo $benhNhan['NgaySinh']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="patientGender" class="form-label">Giới tính</label>
                    <input type="text" class="form-control" value="<?php echo $benhNhan['GioiTinh']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="patientReason" class="form-label">Lý do nhập viện</label>
                    <input type="text" class="form-control" id="patientReason" value="<?php echo $benhNhan['LyDo']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="patientDiagnosis" class="form-label">Chẩn đoán ban đầu</label>
                    <input type="text" class="form-control" id="patientDiagnosis" value="<?php echo $benhNhan['ChuanDoanBD']; ?>">
                </div>
            </div>
        </fieldset>

        <!-- Thông tin xuất viện -->
        <fieldset class="border p-4 mb-4 rounded bg-white">
            <legend class="w-auto px-3">Thông tin xuất viện</legend>
            <div class="mb-3">
                <label for="dischargeDate" class="form-label">Ngày xuất viện</label>
                <input type="date" class="form-control" id="dischargeDate" name="ThoiGianXV" value="<?php echo date('Y-m-d'); ?>">
            </div>  
            <div class="mb-3">
                <label for="finalDiagnosis" class="form-label">Chuẩn đoán kết quả</label>
                <input type="text" class="form-control" id="finalDiagnosis" name="ChuanDoanKQ">
            </div>
            <div class="mb-3">
                <label for="treatmentMethod" class="form-label">Phương pháp điều trị</label>
                <textarea class="form-control" id="notes" rows="3" name="PhuongPhapDieuTri"></textarea>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Một số lưu ý sau khi xuất viện</label>
                <textarea class="form-control" id="notes" rows="3" name="GhiChu"></textarea>
            </div>
            
        </fieldset>

        <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg w-50">Xuất viện</button>

        </div>
    </form>
</div>

<?php
    $ThoiGianXV = isset($_POST['ThoiGianXV'])? $_POST['ThoiGianXV'] : null;
    $ChuanDoanKQ = isset($_POST['ChuanDoanKQ']) ? $_POST['ChuanDoanKQ'] : null;
    $PhuongPhapDieuTri = isset($_POST['PhuongPhapDieuTri']) ? $_POST['PhuongPhapDieuTri'] : null;
    $GhiChu = isset($_POST['GhiChu']) ? $_POST['GhiChu'] : null;
    $MaNV = isset($_GET['MaNV']) ? $_GET['MaNV'] : null;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namVienModel = new NamVien();
    if (empty($ChuanDoanKQ) || empty($PhuongPhapDieuTri)  || empty($MaBN) || empty($MaNV)) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin',
                text: 'Vui lòng nhập đầy đủ thông tin trước khi lưu phiếu xuất viện!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
        exit; 
    }

    $result = $namVienModel->xuatvien($ThoiGianXV, $ChuanDoanKQ, $PhuongPhapDieuTri, $GhiChu,$MaBN, $MaNV);
    
    // Hiển thị thông báo và chuyển hướng
    if ($result) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Lưu phiếu xuất viện thành công!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/QLBV/bacsi/index.php?page=DSBNNT';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Thất bại',
                text: 'Lưu phiếu xuất viện thất bại!',
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
   
