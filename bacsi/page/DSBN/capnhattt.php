<?php
$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
include_once(BACKEND_URL . 'model/mBenhNhan.php');

$con = new mBenhNhan(); 

$result = $con->getAllBenhNhan($MaBN);
if ($result && mysqli_num_rows($result) > 0) {
    $benhNhan = mysqli_fetch_assoc($result); 
} else {
    $benhNhan = []; 
    echo "Không tìm thấy bệnh nhân.";
}

?>
<div class="main-content" id="main-content">
        <h2 class="text-center mb-4">Cập nhật thông tin bệnh nhân</h2>
        <hr class="divider">
     <form method="post">
            <!-- Thông tin bệnh nhân -->
            <fieldset class="border p-4 mb-4 rounded bg-white">
                <legend class="w-auto px-3">Thông tin bệnh nhân</legend>
                <div class="mb-3">
                    <label for="patientName" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="patientName" name="HoTen" value="<?php echo isset($benhNhan['HoTen']) ? $benhNhan['HoTen'] : ''; ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="patientAge" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name ="NgaySinh" value="<?php echo isset($benhNhan['NgaySinh']) ? $benhNhan['NgaySinh'] : ''; ?>" />

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="GioiTinh" class="form-label">Giới tính</label>
                        <select class="form-select" id="GioiTinh" name="GioiTinh">
                            <option value="Nam" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="patientName" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" placeholder="Nhập địa chỉ"  name="DiaChi" value="<?php echo isset($benhNhan['DiaChi'])?$benhNhan['DiaChi']:''; ?>">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="patientAge" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" placeholder="Nhập số SDT" name="SDT" value="<?php echo isset($benhNhan['SDT'])?$benhNhan['SDT']:''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="patientGender" class="form-label"  >CCCD</label>
                        <input type="text" class="form-control" placeholder="Nhập số CCCD" name="CCCD" value="<?php echo isset($benhNhan['CCCD'])?$benhNhan['CCCD']:''; ?>">
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="BHYT" class="form-label">Thẻ BHYT</label>
                        <input type="text" class="form-control" id="BHYT" name="BHYT" placeholder="Nhập số thẻ BHYT" value="<?php echo isset($benhNhan['BHYT']) ? $benhNhan['BHYT'] : ''; ?>" onchange="checkBHYTType()"
                            onblur="validateInput(this)">
                        <span class="text-danger" id="errorBHYT"></span>
                    </div>
                    <div class="col-md-6 mb-3" id="loaiBHYT-container" style="display: none;">
                        <label for="LoaiBHYT" class="form-label">Chọn loại BHYT</label>
                        <select class="form-select" id="LoaiBHYT" name="LoaiBHYT">
                            <option value="1">Loại 1</option>
                            <option value="2">Loại 2</option>
                            <option value="3">Loại 3</option>
                            <option value="4">Loại 4</option>
                            <option value="5">Loại 5</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="loaiBHYT-text"  style="display: none;">
                        <label for="LoaiBHYTText" class="form-label">Loại BHYT</label>
                        <input type="text" class="form-control" id="LoaiBHYTText" name="LoaiBHYTText" readonly>
                    </div>

                </div>
            
        </fieldset>
        <!-- Nút hành động -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg w-50" id="savePrescriptionButton">Lưu thông tin</button>
        </div>
    </form>
    </div>


    <script>
    function checkBHYTType() {
        var BHYT = document.getElementById('BHYT').value;
        var loaiBHYTField = document.getElementById('LoaiBHYT');
        var loaiBHYTTextField = document.getElementById('LoaiBHYTText');
        var loaiBHYTContainer = document.getElementById('loaiBHYT-container');
        var loaiBHYTTextContainer = document.getElementById('loaiBHYT-text');

        if (BHYT.length === 15) {
            var loai = BHYT.charAt(2); // Ký tự thứ 3 (chỉ số bắt đầu từ 0)
            loaiBHYTTextField.value = 'Loại ' + loai; // Hiển thị loại
            loaiBHYTContainer.style.display = 'none'; // Ẩn danh sách chọn loại BHYT
            loaiBHYTTextContainer.style.display = 'block'; // Hiển thị loại thẻ BHYT
        } else if (BHYT.length === 10) {
            loaiBHYTContainer.style.display = 'block'; // Hiển thị danh sách chọn loại BHYT
            loaiBHYTTextContainer.style.display = 'none'; // Ẩn phần loại BHYT tự động
        } else {
            loaiBHYTContainer.style.display = 'none';
            loaiBHYTTextContainer.style.display = 'none';
        }
    }
    function validateInput(input) {
    const errorElement = document.getElementById(`error${input.id}`);
    if (!input.value.trim()) {
        errorElement.textContent = "Vui lòng nhập thông tin";
    } else {
        errorElement.textContent = ""; 
    }
}
</script>

<?php
    $HoTen = isset($_POST['HoTen'])? $_POST['HoTen'] : null;
    $NgaySinh = isset($_POST['NgaySinh']) ? $_POST['NgaySinh'] : null;
    $GioiTinh = isset($_POST['GioiTinh']) ? $_POST['GioiTinh'] : null;
    $DiaChi = isset($_POST['DiaChi']) ? $_POST['DiaChi'] : null;
    $SDT = isset($_POST['SDT']) ? $_POST['SDT'] : null;
    $CCCD = isset($_POST['CCCD']) ? $_POST['CCCD'] : null;
    $BHYT = isset($_POST['BHYT']) ? $_POST['BHYT'] : null;
    $LoaiBHYT = isset($_POST['LoaiBHYT']) ? $_POST['LoaiBHYT'] : null;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $benhnhan = new mBenhNhan();
    if (empty($NgaySinh) || empty($GioiTinh)  || empty($MaBN) || empty($DiaChi)|| empty($SDT)|| empty($CCCD)|| empty($BHYT)) {
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

    $result = $benhnhan->updateTTCN($HoTen, $NgaySinh, $GioiTinh, $DiaChi,$SDT, $CCCD,$BHYT,$LoaiBHYT,$MaBN);
    
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
   
