<?php
    include_once('ketnoi.php');
    class mNguoiDung{
        public function select01NguoiDung($user, $pw) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
        
            $sql_ns = "SELECT ns.MaNS,ns.MaCV,ns.MaKhoa
                       FROM taikhoan tk
                       INNER JOIN nhansu ns ON tk.TenTK = ns.TenTK
                       WHERE tk.TenTK = '$user' AND tk.MatKhau = '$pw'";
            $result_ns = mysqli_query($con, $sql_ns);
        
            if (mysqli_num_rows($result_ns) == 0) {
                $sql_bn = "SELECT bn.MaBN 
                           FROM taikhoan tk
                           INNER JOIN benhnhan bn ON tk.TenTK = bn.TenTK
                           WHERE tk.TenTK = '$user' AND tk.MatKhau = '$pw'";
                $result_bn = mysqli_query($con, $sql_bn);
        
                if (mysqli_num_rows($result_bn) > 0) {
                    $p->dongKetNoi($con);
                    return $result_bn;
                }
            } else {
                $p->dongKetNoi($con);
                return $result_ns; 
            }
        
            $p->dongKetNoi($con);
            return null;
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

        public function getHoTenByMaNS($maNS) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
    
            $sql = "SELECT HoTen FROM nhansu WHERE MaNS = '$maNS'";
            $result = mysqli_query($con, $sql);
            
            if ($row = mysqli_fetch_assoc($result)) {
                $hoTen = $row['HoTen'];
            } else {
                $hoTen = 'Không tìm thấy thông tin';
            }
    
            $p->dongKetNoi($con);
            
            return $hoTen;
        }
        public function getDoctorsByDepartment($tenKhoa, $thu, $caLam) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
        
            // Câu lệnh SQL với join và điều kiện bổ sung
            $sql = "SELECT bs.HoTen 
                    FROM nhansu bs
                    INNER JOIN khoa k ON bs.MaKhoa = k.MaKhoa
                    INNER JOIN lichlamviec llv ON bs.MaNS = llv.MaNS
                    WHERE k.TenKhoa = ? 
                      AND k.TrangThai = 1 
                      AND bs.MaCV = 4
                      AND llv.NgayTrongTuan = ?
                      AND llv.CaTrongNgay = ?"; 
        
            // Chuẩn bị và thực thi truy vấn
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sss", $tenKhoa, $thu, $caLam);
            $stmt->execute();
            $result = $stmt->get_result();
            $doctors = [];
        
            // Lấy kết quả
            while ($row = $result->fetch_assoc()) {
                $doctors[] = $row['HoTen'];
            }
        
            // Đóng kết nối
            $stmt->close();
            $p->dongKetNoi($con);
        
            return $doctors;
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

            public function getNS($MaNS) {
            $p = new clsKetNoi();
            
            $conn = $p->moKetNoi();
            $sql= "SELECT * FROM nhansu ns join khoa k on k.MaKhoa=ns.MaKhoa join chucvu cv on cv.MaCV=ns.MaCV where MaNS= '$MaNS'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dsBenhNhan[] = $row; 
                }
            }
            return $dsBenhNhan;
        }
        
        public function updateTTCN($MaNS,$NgaySinh,$Email,$GioiTinh,$SoDienThoai){
            $p = new clsKetNoi();
            $con = $p->moKetNoi(); 
            $sql = "UPDATE nhansu SET NgaySinh = '$NgaySinh',Email='$Email', GioiTinh = '$GioiTinh', SoDienThoai = '$SoDienThoai' WHERE MaNS = '$MaNS'";
            $result = mysqli_query($con, $sql);
            $p -> dongKetNoi($con);
            return $result;
        }
        public function checkCurrentPassword($MaNS, $currentPassword) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi(); 
            
            // Truy vấn lấy TenTk từ bảng nhansu theo MaNS
            $sql = "SELECT k.MatKhau FROM nhansu ns JOIN taikhoan k ON k.TenTK = ns.TenTk WHERE ns.MaNS = '$MaNS'";
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
        public function updatePasswordBN($MaBN, $newPassword,$HoTen, $NgaySinh, $GioiTinh,$SDT) {
            $newPasswordHash = md5($newPassword);
    
            $p = new clsKetNoi();
            $con = $p->moKetNoi(); 
            
            // Truy vấn để cập nhật mật khẩu mới cho người dùng
            $sql = "UPDATE taikhoan k 
                    JOIN benhnhan ns ON ns.TenTk = k.TenTK 
                    SET k.MatKhau = '$newPasswordHash', ns.HoTen='$HoTen', ns.NgaySinh='$NgaySinh',ns.GioiTinh='$GioiTinh',ns.SDT='$SDT'
                    WHERE ns.MaBN = '$MaBN'";
    
            if (mysqli_query($con, $sql)) {
                $p->dongKetNoi($con);
                return true; 
            } else {
                $p->dongKetNoi($con);
                return false; // Thất bại
            }
    }
    public function updateProfileBN($MaBN,$HoTen, $NgaySinh, $GioiTinh,$SDT) {

        $p = new clsKetNoi();
        $con = $p->moKetNoi(); 
        
        // Truy vấn để cập nhật mật khẩu mới cho người dùng
        $sql = "UPDATE benhnhan
                SET  HoTen='$HoTen', NgaySinh='$NgaySinh',GioiTinh='$GioiTinh',SDT='$SDT'
                WHERE MaBN = '$MaBN'";

        if (mysqli_query($con, $sql)) {
            $p->dongKetNoi($con);
            return true; 
        } else {
            $p->dongKetNoi($con);
            return false; // Thất bại
        }
}
        public function updatePassword($MaNS,  $newPassword) {
                $newPasswordHash = md5($newPassword);
        
                $p = new clsKetNoi();
                $con = $p->moKetNoi(); 
                
                // Truy vấn để cập nhật mật khẩu mới cho người dùng
                $sql = "UPDATE taikhoan k 
                        JOIN nhansu ns ON ns.TenTk = k.TenTK 
                        SET k.MatKhau = '$newPasswordHash' 
                        WHERE ns.MaNS = '$MaNS'";
        
                if (mysqli_query($con, $sql)) {
                    $p->dongKetNoi($con);
                    return true; 
                } else {
                    $p->dongKetNoi($con);
                    return false; // Thất bại
                }
        }
        public function updateIMG($MaNS,  $imageName) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi(); 
            
            // Truy vấn để cập nhật mật khẩu mới cho người dùng
            $sql = "UPDATE nhansu SET IMG = '$imageName' WHERE MaNS = '$MaNS'";
    
            if (mysqli_query($con, $sql)) {
                $p->dongKetNoi($con);
                return true; 
            } else {
                $p->dongKetNoi($con);
                return false; // Thất bại
            }
        }
        public function updateIMGBN($MaBN,  $imageName) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi(); 
            
            // Truy vấn để cập nhật mật khẩu mới cho người dùng
            $sql = "UPDATE benhnhan SET IMG = '$imageName' WHERE MaBN = '$MaBN'";
    
            if (mysqli_query($con, $sql)) {
                $p->dongKetNoi($con);
                return true; 
            } else {
                $p->dongKetNoi($con);
                return false; // Thất bại
            }
        }
        
    }
    
?>