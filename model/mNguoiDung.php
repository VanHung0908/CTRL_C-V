<?php
    include_once('ketnoi.php');
    class mNguoiDung{
        public function select01NguoiDung($user, $pw) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
        
            $sql_ns = "SELECT ns.MaNS,ns.MaCV
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

            $sql_check = "SELECT TenTK FROM taikhoan WHERE TenTK = '$soDienThoai'";  
            $result_check = mysqli_query($con, $sql_check);

            if (mysqli_num_rows($result_check) > 0) {
                $p->dongKetNoi($con);
                return false; 
            } else {

                $sql_insert_taikhoan = "INSERT INTO taikhoan (TenTK, MatKhau) VALUES ('$soDienThoai', '$matKhau')";
                if (mysqli_query($con, $sql_insert_taikhoan)) {
                    $maTK = mysqli_insert_id($con);

                    $sql_insert_ns = "INSERT INTO benhnhan ( TenTK, HoTen) VALUES ( '$soDienThoai', '$hoTen')";
                    if (mysqli_query($con, $sql_insert_ns)) {
                        $p->dongKetNoi($con);
                        return true;  
                    } else {
                        $p->dongKetNoi($con);
                        return false;  
                    }
                } else {
                    $p->dongKetNoi($con);
                    return false;  
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
                      AND llv.Thu = ?
                      AND llv.CaLam = ?
                      AND llv.TrangThai = 'Đã duyệt'"; 
        
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
        
        
    }
    
?>