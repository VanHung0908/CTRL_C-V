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
        public function getBacSiByKhoa($maKhoa) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
            $sql = "SELECT MaNS, HoTen FROM nhansu WHERE MaKhoa = ? AND MaCV = '5'";
            $stmt = mysqli_prepare($con, $sql);
        
            mysqli_stmt_bind_param($stmt, 's', $maKhoa); 
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $bacSiList = [];
            while ($row = $result->fetch_assoc()) {
                $bacSiList[] = $row;
            }

            return $bacSiList;
        }
        public function checkCurrentPasswordBN($MaBN, $currentPassword) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi(); 
            
            // Truy vấn lấy TenTk từ bảng nhansu theo MaBN
            $sql = "SELECT k.MatKhau FROM benhnhan ns JOIN taikhoan k ON k.TenTK = ns.TenTk WHERE ns.MaBN = '$MaBN'";
            $result = mysqli_query($con, $sql);
        
            if (mysqli_num_rows($result) > 0) {
                // Lấy mật khẩu đã mã hóa (MD5) từ bảng taikhoan
                $row = mysqli_fetch_assoc($result);
                $storedPassword = $row['MatKhau'];
        
                // So sánh mật khẩu nhập vào (sau khi mã hóa MD5) với mật khẩu đã lưu trong DB
                if (md5($currentPassword) === $storedPassword) {
                    $p->dongKetNoi($con);
                    return true; // Mật khẩu đúng
                } else {
                    $p->dongKetNoi($con);
                    return false; // Mật khẩu sai
                }
            } else {
                $p->dongKetNoi($con);
                return false; // Không tìm thấy người dùng
            }
        }
      
    }
?>