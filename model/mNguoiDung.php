<?php
    include_once('ketnoi.php');
    class mNguoiDung{
        public function select01NguoiDung($user,$pw){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM taikhoan where tenTk='$user' and matKhau = '$pw'";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function insertNguoiDung($hoTen, $soDienThoai, $matKhau)
        {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();

            // Kiểm tra xem số điện thoại đã tồn tại trong bảng taikhoan chưa
            $sql_check = "SELECT TenTK FROM taikhoan WHERE TenTK = '$soDienThoai'";
            $result_check = mysqli_query($con, $sql_check);

            if (mysqli_num_rows($result_check) > 0) {
                $p->dongKetNoi($con);
                return false; // Số điện thoại đã tồn tại trong bảng taikhoan
            } else {
                // Thêm vào bảng taikhoan
                $sql_insert_taikhoan = "INSERT INTO taikhoan (TenTK, MatKhau) VALUES ('$soDienThoai', '$matKhau')";
                if (mysqli_query($con, $sql_insert_taikhoan)) {
                    $maTK = mysqli_insert_id($con);

                    // Kiểm tra xem số điện thoại đã tồn tại trong bảng benhnhan chưa
                    $sql_check_benhnhan = "SELECT * FROM benhnhan WHERE SDT = '$soDienThoai'";
                    $result_check_benhnhan = mysqli_query($con, $sql_check_benhnhan);

                    if (mysqli_num_rows($result_check_benhnhan) > 0) {
                        // Nếu tồn tại, cập nhật cột TenTK của bản ghi có cùng SDT
                        $sql_update_benhnhan = "UPDATE benhnhan SET TenTK = '$soDienThoai' WHERE SDT = '$soDienThoai'";
                        if (mysqli_query($con, $sql_update_benhnhan)) {
                            $p->dongKetNoi($con);
                            return true;  // Cập nhật thành công
                        } else {
                            $p->dongKetNoi($con);
                            return false; // Lỗi khi cập nhật benhnhan
                        }
                    } else {
                        // Nếu chưa tồn tại, thêm mới bản ghi vào bảng benhnhan
                        $sql_insert_benhnhan = "INSERT INTO benhnhan (HoTen, SDT, TenTK) VALUES ('$hoTen', '$soDienThoai', '$soDienThoai')";
                        if (mysqli_query($con, $sql_insert_benhnhan)) {
                            $p->dongKetNoi($con);
                            return true;  // Thêm mới thành công
                        } else {
                            $p->dongKetNoi($con);
                            return false;  // Lỗi khi thêm mới vào benhnhan
                        }
                    }
                } else {
                    $p->dongKetNoi($con);
                    return false;  // Lỗi khi thêm mới vào taikhoan
                }
            }
        }
      
    }
?>