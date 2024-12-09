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
include_once(BACKEND_URL . 'model/mNguoiDung.php');
$con = new mNguoiDung(); 
$MaNS = $_SESSION['maNS'];
$nhansu = $con->getNS($MaNS);
?>

<div class="main-content" id="main-content">
    <div class="row">
    <div class="col-md-4">
        <div class="profile-card h-100">
            <?php 
                $image = $nhansu[0]['IMG'];

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
                <h5>Thông tin </h5>
                <form action="" method="post">
                    <p>
                        <strong>Họ và tên:</strong>
                        <input type="text" class="inputTT" value="<?php echo isset($nhansu[0]['HoTen']) ? $nhansu[0]['HoTen'] : ''; ?>">
                    </p>
                    <p>
                        <strong>Khoa:</strong>
                        <input type="text" class="inputTT" value="<?php echo isset($nhansu[0]['TenKhoa']) ? $nhansu[0]['TenKhoa'] : ''; ?>">
                    </p>
                    <p>
                        <strong>Chức vụ:</strong>
                        <input type="text" class="inputTT" value="<?php echo isset($nhansu[0]['TenCV']) ? $nhansu[0]['TenCV'] : ''; ?>">
                    </p>
                    <p>
                        <strong>Ngày bắt đầu:</strong>
                        <input type="text" class="inputTT" value="<?php echo isset($nhansu[0]['NgayBatDau']) ? $nhansu[0]['NgayBatDau'] : ''; ?>">
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

    <div class="row mt-4">
        <div class="col-12">
            <div class="personal-info">
                <h5>Thông tin cá nhân</h5>
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" placeholder="Ngày sinh" name="NgaySinh" type="date" value="<?php echo isset($nhansu[0]['NgaySinh']) ? $nhansu[0]['NgaySinh'] : ''; ?>"/>
                                <i class="fas fa-calendar-alt form-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="GioiTinh" class="form-label">Giới tính</label>
                                <select class="selectGT" id="GioiTinh" name="GioiTinh">
                                    <option value="Nam" <?php echo (isset($nhansu[0]['GioiTinh']) && $nhansu[0]['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                    <option value="Nữ" <?php echo (isset($nhansu[0]['GioiTinh']) && $nhansu[0]['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                    <option value="Khác" <?php echo (isset($nhansu[0]['GioiTinh']) && $nhansu[0]['GioiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" type="text" name="Email" value="<?php echo isset($nhansu[0]['Email']) ? $nhansu[0]['Email'] : ''; ?>"/>
                                <i class="fas fa-envelope form-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" placeholder="Số điện thoại" type="text" name="SoDienThoai" value="<?php echo isset($nhansu[0]['SoDienThoai']) ? $nhansu[0]['SoDienThoai'] : ''; ?>"/>
                                <i class="fas fa-phone form-icon"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="btnTTCN">LƯU THAY ĐỔI</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_REQUEST["btnTTCN"])) {
    $NgaySinh = $_POST['NgaySinh'];
    $Email = $_POST['Email'];
    $GioiTinh = $_POST['GioiTinh'];
    $SoDienThoai = $_POST['SoDienThoai'];
    $result = $con->updateTTCN($MaNS, $NgaySinh, $Email, $GioiTinh, $SoDienThoai);

    if ($result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Cập nhật thông tin thành công",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/QLBV/bacsi/"; 
                    }
                });
              </script>';
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Thất bại",
                    text: "Đã có lỗi xảy ra vui lòng thử lại!",
                    confirmButtonText: "Thử lại"
                });
              </script>';
    }
}
?>
                <?php
if (isset($_POST["btnChangePassword"])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Kiểm tra các trường dữ liệu có bị trống không
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Thất bại",
                    text: "Dữ liệu không được để trống.",
                    confirmButtonText: "Thử lại"
                });
              </script>';
    }

    // Kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp không
    elseif ($newPassword != $confirmPassword) {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Thất bại",
                    text: "Mật khẩu không khớp. Vui lòng thử lại!",
                    confirmButtonText: "Thử lại"
                });
              </script>';
    } else {
        // Nếu không có lỗi, kiểm tra mật khẩu cũ
        $result = $con->checkCurrentPassword($MaNS, $currentPassword);

        if ($result) {
            // Cập nhật mật khẩu mới
            $updateResult = $con->updatePassword($MaNS, $newPassword);
            if ($updateResult) {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Cập nhật mật khẩu thành công",
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
                            text: "Đã có lỗi xảy ra khi thay đổi mật khẩu.",
                            confirmButtonText: "Thử lại"
                        });
                      </script>';
            }
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
                    $imageName = basename($_FILES['newImage']['name']);  // Lấy tên ảnh
                    $stmt = $con->updateIMG($MaNS, $imageName);
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
