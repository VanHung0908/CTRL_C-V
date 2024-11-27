<?php
    include_once('ketnoi.php');
    class mNguoiDung{
        public function select01NguoiDung($user, $pw) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
        
            // Truy vấn kiểm tra thông tin từ bảng nhansu
            $sql_ns = "SELECT ns.MaNS 
                       FROM taikhoan tk
                       INNER JOIN nhansu ns ON tk.TenTK = ns.TenTK
                       WHERE tk.TenTK = '$user' AND tk.MatKhau = '$pw'";
            $result_ns = mysqli_query($con, $sql_ns);
        
            // Nếu không tìm thấy trong bảng nhansu, kiểm tra trong bảng benhnhan
            if (mysqli_num_rows($result_ns) == 0) {
                $sql_bn = "SELECT bn.MaBN 
                           FROM taikhoan tk
                           INNER JOIN benhnhan bn ON tk.TenTK = bn.TenTK
                           WHERE tk.TenTK = '$user' AND tk.MatKhau = '$pw'";
                $result_bn = mysqli_query($con, $sql_bn);
        
                // Nếu tìm thấy trong bảng benhnhan
                if (mysqli_num_rows($result_bn) > 0) {
                    $p->dongKetNoi($con);
                    return $result_bn; // Trả về kết quả từ bảng benhnhan
                }
            } else {
                // Nếu tìm thấy trong bảng nhansu
                $p->dongKetNoi($con);
                return $result_ns; // Trả về kết quả từ bảng nhansu
            }
        
            // Nếu không tìm thấy trong cả 2 bảng
            $p->dongKetNoi($con);
            return null;
        }
        public function getHoTenByMaNS($maNS) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
    
            // Truy vấn lấy thông tin HoTen từ bảng benhnhan
            $sql = "SELECT HoTen FROM nhansu WHERE MaNS = '$maNS'";
            $result = mysqli_query($con, $sql);
            
            // Nếu tìm thấy thông tin, trả về HoTen
            if ($row = mysqli_fetch_assoc($result)) {
                $hoTen = $row['HoTen'];
            } else {
                $hoTen = 'Không tìm thấy thông tin';
            }
    
            // Đóng kết nối
            $p->dongKetNoi($con);
            
            return $hoTen;
        }
        public function getDoctorsByDepartment($tenKhoa) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
        
            // Truy vấn lấy danh sách bác sĩ từ bảng bác sĩ dựa trên tên khoa
            $sql = "SELECT HoTen FROM nhansu bs
                    INNER JOIN khoa k ON bs.MaKhoa = k.MaKhoa
                    WHERE k.TenKhoa = ? AND k.TrangThai = 1";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $tenKhoa);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Lưu kết quả vào một mảng
            $doctors = [];
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