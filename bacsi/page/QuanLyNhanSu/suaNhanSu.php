<?php
    $ma=$_REQUEST["sua"];
    include_once(BACKEND_URL . 'controller/cNhanSu.php');

    $p=new cNhanSu();
    $nhansu=$p->get01NhanSu($ma);
    if($nhansu)
    {
        while($r=mysqli_fetch_assoc($nhansu))
        {
            $ten=$r["HoTen"];
            $ns=$r["NgaySinh"];
            $email=$r["Email"];
            $gt=$r["GioiTinh"];
            $cccd=$r["CCCD"];
            $sdt=$r["SoDienThoai"];
            $ngayBD=$r["NgayBatDau"];
            $dc=$r["DiaChi"];
            $cv=$r["MaCV"];
            $tk=$r["TenTK"];
            $khoa=$r["MaKhoa"];
        }
    }
    else
    {
        
        echo '<script>alert("Dữ liệu không hợp lệ")</script>';
        header("refresh:0;url=index.php?type=nhansu");
    }
?>

<div class="main-content" id="main-content">
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
        <div class="card shadow">
            <div class="card-header text-center bg-success text-white">
                <h4>Chỉnh sửa Thông tin Nhân sự</h4>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <div class="mb-3">
                        <label for="txtHoTen" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" name="txtHoTen" id="txtHoTen" value="<?php echo $ten ?>">
                    </div>

                    <div class="mb-3">
                        <label for="txtNgaySinh" class="form-label">Ngày sinh</label>
                        <input type="text" class="form-control" name="txtNgaySinh" id="txtNgaySinh" value="<?php echo $ns ?>">
                    </div>

                    <div class="mb-3">
                        <label for="txtEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="txtEmail" id="txtEmail" value="<?php echo $email ?>">
                    </div>

                    <div class="mb-3">
                        <label for="txtGT" class="form-label">Giới tính</label>
                        <select class="form-select" name="txtGT">
                            <option value="Nam" <?php echo $gt === 'Nam' ? 'selected' : '' ?>>Nam</option>
                            <option value="Nữ" <?php echo $gt === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="txtCCCD" class="form-label">Số điện thoại
                        <input type="text" class="form-control" name="SoDienThoai" id="txtSDT" value="<?php echo $sdt ?>">
                    </div>
                    <div class="mb-3">
                        <label for="txtCCCD" class="form-label">CCCD</label>
                        <input type="text" class="form-control" name="txtCCCD" id="txtCCCD" value="<?php echo $cccd ?>">
                    </div>

                    <div class="mb-3">
                        <label for="txtNgayBD" class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" name="txtNgayBD" id="txtNgayBD" value="<?php echo $ngayBD ?>">
                    </div>

                    <div class="mb-3">
                        <label for="txtDiaChi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="txtDiaChi" id="txtDiaChi" value="<?php echo $dc ?>">
                    </div>

                    <div class="mb-3">
                        <label for="ChucVu" class="form-label">Chức vụ</label>
                        <select class="form-select" name="ChucVu">
                            <?php
                                $kq = $p->getAllChucVu();
                                if ($kq) {
                                    while ($r = mysqli_fetch_assoc($kq)) {
                                        $selected = $r["MaCV"] == $cv ? 'selected' : '';
                                        echo "<option value='{$r['MaCV']}' $selected>{$r['TenCV']}</option>";
                                    }
                                } else {
                                    echo '<option>Không có dữ liệu</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Khoa" class="form-label">Khoa</label>
                        <select class="form-select" name="Khoa">
                            <?php
                                $kq = $p->getAllKhoa();
                                if ($kq) {
                                    while ($r = mysqli_fetch_assoc($kq)) {
                                        $selected = $r["MaKhoa"] == $khoa ? 'selected' : '';
                                        echo "<option value='{$r['MaKhoa']}' $selected>{$r['TenKhoa']}</option>";
                                    }
                                } else {
                                    echo '<option>Không có dữ liệu</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="btnCapNhap">Cập nhật Nhân sự</button>
                        <button type="reset" class="btn btn-secondary">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    if(isset($_REQUEST["btnCapNhap"])){
        $p ->  uploadNhanSu($ma,$_POST['txtHoTen'],$_POST['txtNgaySinh'],$_POST['txtEmail'],$_POST['txtGT'],$_POST['txtCCCD'],$_POST['SoDienThoai'],$_POST['txtNgayBD'],$_POST['txtDiaChi'],$_POST['ChucVu'],$_POST['Khoa']);
    }
?>