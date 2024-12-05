<?php
// Kết nối đến cơ sở dữ liệu
$benhNhan = null;
$loi = ''; // Biến lưu thông báo lỗi
$loaiBHYT = ''; // Biến lưu loại BHYT (1, 2, 3, 4, 5)
$BHYT = ''; // Biến lưu số thẻ BHYT đã nhập
$chiPhi = 100000; // Chi phí cố định là 100,000 VND

// Kiểm tra xem có dữ liệu tìm kiếm không
if (isset($_POST['SDT']) && !empty($_POST['SDT'])) {
    $SDT = $_POST['SDT'];
    include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mBenhNhan.php'); 
   
    // Tạo đối tượng và tìm kiếm bệnh nhân
    $mBenhNhan = new mBenhNhan(); 
    $benhNhan = $mBenhNhan->getPatientByPhone($SDT); // Hàm getPatientByPhone tìm bệnh nhân theo số điện thoại

    // Nếu không tìm thấy bệnh nhân
    if (!$benhNhan) {
        $loi = 'Không tìm thấy bệnh nhân với số điện thoại này!';
    }
}

// Xử lý loại BHYT dựa trên số thẻ (sẽ dùng JavaScript để xử lý)
if (isset($_POST['BHYT']) && !empty($_POST['BHYT'])) {
    $BHYT = $_POST['BHYT'];

    // Kiểm tra số thẻ BHYT hợp lệ
    if (strlen($BHYT) != 15 && strlen($BHYT) != 10) {
        $loi = 'Số thẻ BHYT không hợp lệ!';
    } else {
        // Kiểm tra nếu thẻ BHYT dài 15 ký tự thì có thể tự động xác định loại
        if (strlen($BHYT) == 15) {
            // Lấy ký tự thứ 3 trong số thẻ để xác định loại BHYT
            $loaiBHYT = substr($BHYT, 2, 1);
        }
    }
}

if (isset($_POST['btn_DangKy'])) {
    // Danh sách các trường cần kiểm tra
    $required_fields = ['HoTen', 'NgaySinh', 'GioiTinh', 'MaKhoa', 'DiaChi', 'CCCD', 'BHYT', 'LoaiBHYT', 'chiPhi', 'phuongThucThanhToan'];
    $error = false; // Biến để theo dõi lỗi

    // Kiểm tra từng trường
    foreach ($required_fields as $field) {
        if (empty($_REQUEST[$field])) {
            $error = true;
            break; 
        }
    }

    if (!$error) { // Nếu không có lỗi
        include('../controller/cBenhNhan.php');
        $p = new cBenhNhan();
        $con = $p->addDKKhamBenh(
            $_REQUEST['HoTen'],
            $_REQUEST['NgaySinh'],
            $_REQUEST['GioiTinh'],
            $_REQUEST['SDT'],
            $_REQUEST['MaKhoa'],
            $_REQUEST['DiaChi'],
            $_REQUEST['CCCD'],
            $_REQUEST['BHYT'],
            $_REQUEST['LoaiBHYT'],
            $_REQUEST['chiPhi'],
            $_REQUEST['phuongThucThanhToan']
        );
        // Xử lý kết quả nếu cần
    } else {
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Thất bại",
            text: "Vui lòng điền đầy đủ thông tin.",
            confirmButtonText: "Thử lại"
        });
      </script>';
    }
}

?>

<div class="main-content" id="main-content">  
    <h2 class="mb-4">Đăng ký khám bệnh</h2>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group d-flex w-100">
                <!-- Form chứa input và button -->
                <form method="POST" action="" class="d-flex w-100 gap-2">
                    <!-- Ô nhập liệu -->
                    <input type="text" class="form-control" placeholder="Nhập số điện thoại bệnh nhân" name="SDT" value="<?php echo isset($SDT) ? $SDT : ''; ?>" aria-label="Tìm kiếm">
                    <!-- Nút tìm kiếm với chiều rộng đủ -->
                    <button class="btn btn-primary" type="submit" style="min-width: 100px;">Tìm kiếm</button>
                </form>
            </div>
            
            <!-- Thông báo lỗi nếu không tìm thấy bệnh nhân -->
            <?php if (!empty($loi)): ?>
                <div class="text-danger mt-2"><?php echo $loi; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Form đăng ký khám bệnh -->
    <form method="POST" >
        <!-- Thông tin bệnh nhân -->
        <div class="mb-5">
            <h5 class="mb-3">Thông tin bệnh nhân</h5>
            <div class="row mb-3">
            <div class="col-md-6">
                <label for="HoTen" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" 
                    value="<?php echo isset($benhNhan['HoTen']) ? $benhNhan['HoTen'] : ''; ?>" 
                    placeholder="Nhập họ và tên" 
                    onblur="validateInput(this)">
                <span class="text-danger" id="errorHoTen"></span>
            </div>
            <div class="col-md-6">
                <label for="NgaySinh" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" 
                    value="<?php echo isset($benhNhan['NgaySinh']) ? $benhNhan['NgaySinh'] : ''; ?>" 
                    onblur="validateInput(this)">
                <span class="text-danger" id="errorNgaySinh"></span>
            </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="GioiTinh" class="form-label">Giới tính</label>
                    <select class="form-select" id="GioiTinh" name="GioiTinh">
                        <option value="Nam" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                        <option value="Nữ" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                        <option value="Khác" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="SDT" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="SDT" name="SDT" value="<?php echo isset($benhNhan['SDT']) ? $benhNhan['SDT'] : ''; ?>" placeholder="Nhập số điện thoại"
                    onblur="validateInput(this)">
                    <span class="text-danger" id="errorSDT"></span>
                </div>
            </div>
            <div class="mb-3">
                <label for="DiaChi" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="DiaChi" name="DiaChi" value="<?php echo isset($benhNhan['DiaChi']) ? $benhNhan['DiaChi'] : ''; ?>" placeholder="Nhập địa chỉ">
            </div>
            <div class="mb-3">
                <label for="CCCD" class="form-label">CCCD</label>
                <input type="text" class="form-control" id="CCCD" name="CCCD" value="<?php echo isset($benhNhan['CCCD']) ? $benhNhan['CCCD'] : ''; ?>" placeholder="Nhập số CCCD"
                onblur="validateInput(this)">
                <span class="text-danger" id="errorCCCD"></span>
            </div>
        </div>

        <!-- Thông tin khám bệnh -->
        <div class="mb-4">
            <h5 class="mb-3">Thông tin khám bệnh</h5>
            <div class="mb-3">
                <label for="department" class="form-label">Khoa khám</label>
                <select class="form-select" id="department" name="MaKhoa">
                    <?php
                    include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mKhoa.php');
                    $mKhoa = new mKhoa();
                    $departments = $mKhoa->getDepartments();

                    // Hiển thị danh sách khoa trong select
                    foreach ($departments as $department) {
                        echo '<option value="' . $department['MaKhoa'] . '">' . $department['TenKhoa'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                    <label for="BHYT" class="form-label">Thẻ BHYT</label>
                    <input type="text" class="form-control" id="BHYT" name="BHYT" placeholder="Nhập số thẻ BHYT" value="<?php echo isset($benhNhan['BHYT']) ? $benhNhan['BHYT'] : ''; ?>" onchange="checkBHYTType()"
                    onblur="validateInput(this)">
                <span class="text-danger" id="errorBHYT"></span>
                </div>

            <!-- Loại BHYT sẽ được xử lý bằng JavaScript -->
            <div class="mb-3" id="loaiBHYT-container" style="display: none;">
                    <label for="LoaiBHYT" class="form-label">Chọn loại BHYT</label>
                    <select class="form-select" id="LoaiBHYT" name="LoaiBHYT">
                        <option value="1">Loại 1</option>
                        <option value="2">Loại 2</option>
                        <option value="3">Loại 3</option>
                        <option value="4">Loại 4</option>
                        <option value="5">Loại 5</option>
                    </select>
                </div>

                <!-- Trường hợp thẻ BHYT 15 số sẽ tự động hiển thị loại thẻ -->
                <div class="mb-3" id="loaiBHYT-text" style="display: none;">
                    <label for="LoaiBHYTText" class="form-label">Loại BHYT</label>
                    <input type="text" class="form-control" id="LoaiBHYTText" name="LoaiBHYTText" readonly>
                </div>
            <!-- Trường hợp thẻ BHYT 15 số sẽ tự động hiển thị loại thẻ -->
            <div class="mb-3">
                <label for="chiPhi" class="form-label">Chi phí khám bệnh</label>
                <input type="text" class="form-control" id="chiPhi" name="chiPhi" value="<?php echo $chiPhi; ?>" readonly>
            </div>

            <!-- Chọn phương thức thanh toán -->
            <div class="mb-3">
                <label for="phuongThucThanhToan" class="form-label">Phương thức thanh toán</label>
                <select class="form-select" id="phuongThucThanhToan" name="phuongThucThanhToan">
                    <option value="tienmat">Thanh toán tiền mặt</option>
                    <option value="chuyenkhoan">Thanh toán chuyển khoản</option>
                </select>
            </div>
        </div>
        <div class="text-center ">
            <button type="submit" class="btn btn-success  btn-lg w-30" name="btn_DangKy">Đăng ký khám bệnh</button>
        </div>
        <!-- Nút đăng ký -->
    </form>
</div>

<script>
    // Hàm kiểm tra loại BHYT dựa trên số thẻ
    function checkBHYTType() {
        var BHYT = document.getElementById('BHYT').value;
        var loaiBHYTField = document.getElementById('LoaiBHYT');
        var loaiBHYTTextField = document.getElementById('LoaiBHYTText');
        var loaiBHYTContainer = document.getElementById('loaiBHYT-container');
        var loaiBHYTTextContainer = document.getElementById('loaiBHYT-text');

        // Kiểm tra độ dài của thẻ BHYT
        if (BHYT.length === 15) {
            // Thẻ BHYT cũ (15 số) -> Loại BHYT sẽ tự động xác định từ ký tự thứ 3
            var loai = BHYT.charAt(2); // Ký tự thứ 3 (chỉ số bắt đầu từ 0)
            loaiBHYTTextField.value = 'Loại ' + loai; // Hiển thị loại
            loaiBHYTContainer.style.display = 'none'; // Ẩn danh sách chọn loại BHYT
            loaiBHYTTextContainer.style.display = 'block'; // Hiển thị loại thẻ BHYT
        } else if (BHYT.length === 10) {
            // Thẻ BHYT mới (10 số) -> Hiển thị danh sách chọn loại BHYT
            loaiBHYTContainer.style.display = 'block'; // Hiển thị danh sách chọn loại BHYT
            loaiBHYTTextContainer.style.display = 'none'; // Ẩn phần loại BHYT tự động
        } else {
            // Nếu không đúng định dạng
            loaiBHYTContainer.style.display = 'none';
            loaiBHYTTextContainer.style.display = 'none';
        }
    }
    function validateInput(input) {
    const errorElement = document.getElementById(`error${input.id}`);
    if (!input.value.trim()) {
        errorElement.textContent = "Vui lòng nhập thông tin";
    } else {
        errorElement.textContent = ""; // Xóa thông báo lỗi nếu đã nhập
    }
}

    
</script>