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
include_once(BACKEND_URL . 'model/mPhieuChamSoc.php');

$con = new mBenhNhan(); 
$mPhieuChamSoc = new mPhieuChamSoc(); 

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
?>
<div class="main-content" id="main-content">
        <h2 class="text-center mb-4">Phiếu Chăm Sóc Điều Dưỡng</h2>
        
        <!-- Thông tin bệnh nhân -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Thông Tin Bệnh Nhân
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="patientName" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="patientName"value="<?php echo $benhNhan['HoTen']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="patientAge" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="patientAge" value="<?php echo $benhNhan['NgaySinh']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="patientRoom" class="form-label">Phòng</label>
                        <input type="text" class="form-control" id="patientRoom" value="<?php echo $benhNhan['TenPhong']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="admissionDate" class="form-label">Ngày nhập viện</label>
                        <input type="date" class="form-control"value="<?php echo $benhNhan['ThoiGianNV']; ?>">
                    </div>
                </div>
            </div>
        </div>

<form action="" method="post">
<!-- Nhập chỉ số sức khỏe -->
<div class="card mb-4">
    <div class="card-header bg-warning text-white">
        Nhập Chỉ Số Sức Khỏe
    </div>
        <div class="card-body">
            <div class="row g-3">
            <div class="col-md-12">
                    <label for="bloodPressure" class="form-label">Nhập tình trạng</label>
                    <textarea class="form-control" rows="3" placeholder="Nhập tình trạng bệnh nhân hiện tại" name="TinhTrang" required ></textarea>
                </div>
                <div class="col-md-6">
                    <label for="bloodPressure" class="form-label">Huyết áp (mmHg)</label>
                    <input type="number" class="form-control" id="bloodPressure" placeholder="Nhập chỉ số huyết áp" name="HuyetAp">
                </div>
                <div class="col-md-6">
                    <label for="heartRate" class="form-label">Nhịp tim (lần/phút)</label>
                    <input type="number" class="form-control" id="heartRate" name="NhipTim" placeholder="Nhập chỉ số nhịp tim">
                </div>
                <div class="col-md-6">
                    <label for="temperature" class="form-label">Nhiệt độ cơ thể (°C)</label>
                    <input type="number" class="form-control" id="temperature" name="NhietDoCoThe" placeholder="Nhập nhiệt độ cơ thể">
                </div>
                <div class="col-md-6">
                    <label for="respirationRate" class="form-label">Nhịp thở (lần/phút)</label>
                    <input type="number" class="form-control" id="respirationRate" name="NhipTho" placeholder="Nhập nhịp thở">
                </div>
            </div>
        </div>
    </div>

        <!-- Ghi chú -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                Ghi Chú
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" name="GhiChu"  placeholder="Nhập ghi chú thêm"></textarea>
            </div>
        </div>

        <!-- Nút lưu -->
        <div class="text-center">
            <button class="btn btn-success px-5" name="btn_LuuPhieu">Lưu Phiếu</button>
        </div>
    </div>
</form>
<?php
if(isset($_REQUEST["btn_LuuPhieu"])) {
    $NgayThucHien = date('Y-m-d');
    $TinhTrang = $_POST['TinhTrang'];
    $HuyetAp = $_POST['HuyetAp'];
    $NhipTim = $_POST['NhipTim'];
    $NhietDoCoThe = $_POST['NhietDoCoThe'];
    $NhipTho = $_POST['NhipTho'];
    $GhiChu = $_POST['GhiChu'];
    
    $result = $mPhieuChamSoc->insertPhieuChamSoc($MaBN,$MaNS, $TinhTrang, $HuyetAp, $NhipTim,$NhietDoCoThe, $NhipTho,$GhiChu,$NgayThucHien);
    
    // Hiển thị thông báo và chuyển hướng
    if ($result) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Lưu phiếu chăm sóc thành công!',
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
                text: 'Lưu phiếu chăm sóc thất bại!',
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