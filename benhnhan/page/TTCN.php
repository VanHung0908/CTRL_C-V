<style>
    .form-control {
        padding-left: 50px;
    }

    .inputTT {
        border: none;
        outline: none; /* Loại bỏ đường viền khi input được focus */
        background: transparent; /* Nếu bạn muốn bỏ cả nền */
        width: 300px;
    }

    .selectGT {
        padding: 5px 20px;
        box-sizing: border-box;
        font-size: 15px;
        border-radius: 5px;
    }
</style>

<?php
include_once '../layout/header.php';
$MaBN=$_SESSION['maBN'];
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mPhieuDKKham.php');
include_once(BACKEND_URL . 'model/mNguoiDung.php');
$con = new mBenhNhan(); 
$mNguoiDung = new mNguoiDung();  // Lấy tên ảnh
$result = $con->getAllBenhNhan($MaBN);
if ($result && mysqli_num_rows($result) > 0) {
    $benhNhan = mysqli_fetch_assoc($result); 
} else {
    $benhNhan = []; 
    echo "Không tìm thấy bệnh nhân.";
}

?>
<style>

.form-control {
        padding-left: 50px;
    }

    .inputTT {
        border: none;
        outline: none; 
        background: transparent; 
        width: 300px;
    }

    .selectGT {
        padding: 5px 20px;
        box-sizing: border-box;
        font-size: 15px;
        border-radius: 5px;
    }
</style>

<div class="section-2-1-1">
    <div class="row">
    <div class="col-md-4">
        <div class="profile-card h-100">
            <?php 
                $image = $benhNhan['IMG'];

                if (isset($image) ) {
                    echo '<img src="/QLBV/assets/images/' . $image . '" alt="Avatar">';
                }else{
                    echo '<img src="/QLBV/assets/images/avatar.jpg" alt="Avatar">';

                }
                
              
            ?>
            <br><br>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="newImage" accept="image/*" class="form-control">
                <button class="btn btn-primary mt-3" name="btnCapNhatIMG">CẬP NHẬT</button>
            </form>
        </div>
    </div>

        <div class="col-md-8 ">
            <div class="account-info  h-100">
                <h5>Thông tin cá nhân </h5>
                <form action="" method="post">
                    <p>
                        <strong>Họ và tên:</strong>
                        <input type="text" class="inputTT" name="HoTen" value="<?php echo isset($benhNhan['HoTen']) ? $benhNhan['HoTen'] : ''; ?>">
                    </p>
                    <p>
                        <strong>Ngày sinh:</strong>
                        <input type="text" class="inputTT" name="NgaySinh" value="<?php echo isset($benhNhan['NgaySinh']) ? $benhNhan['NgaySinh'] : ''; ?>">
                    </p>
                    <p>
                        <strong>Số điện thoại:</strong>
                        <input type="text" class="inputTT" name="SDT" value="<?php echo isset($benhNhan['SDT']) ? $benhNhan['SDT'] : ''; ?>">
                    </p>
                    <p>
                    <label for="GioiTinh" class="form-label" name="GioiTinh">Giới tính</label>
                                <select class="form-control" id="GioiTinh" name="GioiTinh">
                                    <option value="Nam" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                    <option value="Nữ" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                    <option value="Khác" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                </select>
                    </p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input class="form-control" placeholder="Mật khẩu hiện tại" type="password" name="currentPassword" />
                                <i class="fas fa-eye form-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input class="form-control" placeholder="Mật khẩu mới" type="password" name="newPassword" />
                                <i class="fas fa-eye form-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input class="form-control" placeholder="Nhập lại mật khẩu" type="password" name="confirmPassword" />
                                <i class="fas fa-eye form-icon"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-save" type="submit" name="btnChangePassword">LƯU THAY ĐỔI</button>
                </form>




            </div>
        </div>
    </div>
    <?php
if (isset($_POST["btnChangePassword"])) {
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $HoTen = $_POST['HoTen'];
    $NgaySinh = $_POST['NgaySinh'];
    $SDT = $_POST['SDT'];
    $GioiTinh = $_POST['GioiTinh'];

    $updateResult = false; // Biến lưu trạng thái cập nhật

    if (!empty($newPassword) && !empty($confirmPassword)) {
        // Kiểm tra mật khẩu mới có khớp với xác nhận không
        if ($newPassword != $confirmPassword) {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Thất bại",
                        text: "Mật khẩu không khớp. Vui lòng thử lại!",
                        confirmButtonText: "Thử lại"
                    });
                  </script>';
        } else {
            // Nếu mật khẩu mới khớp, kiểm tra mật khẩu cũ
            $result = $mNguoiDung->checkCurrentPasswordBN($MaBN, $currentPassword);

            if ($result) {
                // Cập nhật mật khẩu và các thông tin khác
                $updateResult = $mNguoiDung->updatePasswordBN($MaBN, $newPassword, $HoTen, $NgaySinh, $GioiTinh, $SDT);
            } else {
                echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Thất bại",
                            text: "Mật khẩu cũ không đúng. Vui lòng thử lại!",
                            confirmButtonText: "Thử lại"
                        });
                      </script>';
            }
        }
    } else {
        // Chỉ cập nhật thông tin khác nếu không có thay đổi mật khẩu
        $updateResult = $mNguoiDung->updateProfileBN($MaBN, $HoTen, $NgaySinh, $GioiTinh, $SDT);
    }

    if ($updateResult) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Cập nhật thành công",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/QLBV/bacsi";
                    }
                });
              </script>';
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Thất bại",
                    text: "Đã có lỗi xảy ra khi cập nhật thông tin.",
                    confirmButtonText: "Thử lại"
                });
              </script>';
    }
}
?>

<?php
// Kiểm tra nếu có sự kiện cập nhật ảnh
if (isset($_POST['btnCapNhatIMG'])) {
    // Kiểm tra nếu người dùng có chọn ảnh để tải lên
    if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] == 0) {
        // Đường dẫn thư mục lưu ảnh
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/QLBV/assets/images/';
        $targetFile = $targetDir . basename($_FILES['newImage']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Kiểm tra xem tệp có phải là ảnh không
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Kiểm tra kích thước ảnh (ví dụ: không vượt quá 5MB)
            if ($_FILES['newImage']['size'] <= 5000000) { // 5MB = 5000000 bytes
                // Di chuyển ảnh vào thư mục
                if (move_uploaded_file($_FILES['newImage']['tmp_name'], $targetFile)) {
                    // Cập nhật cột IMG trong cơ sở dữ liệu
                    $imageName = basename($_FILES['newImage']['name']); 
                  
                    $stmt = $mNguoiDung->updateIMGBN($MaBN, $imageName);
                    if ($stmt) {
                        // Hiển thị thông báo thành công
                        echo '<script>
                             Swal.fire({
                                icon: "success",
                                title: "Cập nhật ảnh thành công",
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "/QLBV/bacsi";
                                }
                        });
                      </script>';
                    } else {
                        echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Thất bại",
                                text: "Đã có lỗi xảy ra khi cập nhật ảnh.",
                                confirmButtonText: "Thử lại"
                            });
                          </script>';
                    }

                } else {
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Thất bại",
                            text: "Không thể di chuyển tệp ảnh.",
                            confirmButtonText: "Thử lại"
                        });
                      </script>';
                }
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Thất bại",
                        text: "Ảnh vượt quá kích thước cho phép (5MB).",
                        confirmButtonText: "Thử lại"
                    });
                  </script>';
            }
        } else {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Thất bại",
                    text: "Chỉ hỗ trợ ảnh JPG, JPEG, PNG, và GIF.",
                    confirmButtonText: "Thử lại"
                });
              </script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Vui lòng chọn ảnh để tải lên.",
                confirmButtonText: "Thử lại"
            });
          </script>';
    }
}
?>
<?php include_once '../layout/footer.php'; ?>