<?php
    include_once('ketnoi.php');
    class mPKQK{
        public function getslectKQK($MaBN) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
            
                $kqk = array(); 
        
            $today = date('Y-m-d'); 
        
            $sql = "SELECT * FROM phieuketquakham WHERE MaBN = '$MaBN' AND DATE(NgayKham) = '$today'";
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                // Nếu có dữ liệu, thêm từng dòng vào mảng
                while ($row = $result->fetch_assoc()) {
                    $kqk[] = $row; 
                }
            }
            return $kqk;
        }
        public function getTTThuoc($MaDonThuoc) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
            
            $sql = "
                SELECT donthuoc.NgayKeDon, donthuoc.TongTien, 
                       chitietdonthuoc.MaDonThuoc, chitietdonthuoc.MaThuoc, chitietdonthuoc.SoLuong, 
                       chitietdonthuoc.LieuDung, chitietdonthuoc.CachDung,
                       thuoc.TenThuoc, thuoc.Gia, thuoc.DonViTinh, thuoc.SoLuongTon
                FROM donthuoc
                INNER JOIN chitietdonthuoc ON donthuoc.MaDonThuoc = chitietdonthuoc.MaDonThuoc
                INNER JOIN thuoc ON chitietdonthuoc.MaThuoc = thuoc.MaThuoc
                WHERE donthuoc.MaDonThuoc = '$MaDonThuoc'
            ";
            
            $result = $conn->query($sql);
            $kqk = array(); // Khởi tạo mảng kết quả
        
            if ($result->num_rows > 0) {
                // Nếu có dữ liệu, thêm từng dòng vào mảng
                while ($row = $result->fetch_assoc()) {
                    $kqk[] = $row; 
                }
            }
        
            return $kqk;
        }
        public function getThuoc($MaDonThuoc) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
            
            $sql = "
                SELECT donthuoc.NgayKeDon, donthuoc.TongTien, 
                       chitietdonthuoc.MaDonThuoc, chitietdonthuoc.MaThuoc, chitietdonthuoc.SoLuong, 
                       chitietdonthuoc.LieuDung, chitietdonthuoc.CachDung,
                       thuoc.TenThuoc, thuoc.Gia, thuoc.DonViTinh, thuoc.SoLuongTon,pd.NgayLap
                FROM donthuoc
                INNER JOIN chitietdonthuoc ON donthuoc.MaDonThuoc = chitietdonthuoc.MaDonThuoc
                INNER JOIN thuoc ON chitietdonthuoc.MaThuoc = thuoc.MaThuoc
                join phacdo pd on donthuoc.MaDonThuoc= pd.MaDonThuoc
                WHERE donthuoc.MaDonThuoc = '$MaDonThuoc'
            ";
            
            $result = $conn->query($sql);
            $kqk = array(); // Khởi tạo mảng kết quả
        
            if ($result->num_rows > 0) {
                // Nếu có dữ liệu, thêm từng dòng vào mảng
                while ($row = $result->fetch_assoc()) {
                    $kqk[] = $row; 
                }
            }
        
            return $kqk;
        }
        public function getKQKham($MaDonThuoc) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
            
            // Dùng prepared statement để tránh SQL Injection
            $sql = "
                SELECT donthuoc.NgayKeDon, donthuoc.TongTien, 
                       chitietdonthuoc.MaDonThuoc, chitietdonthuoc.MaThuoc, chitietdonthuoc.SoLuong, 
                       chitietdonthuoc.LieuDung, chitietdonthuoc.CachDung,
                       thuoc.TenThuoc, thuoc.Gia, thuoc.DonViTinh, thuoc.SoLuongTon
                FROM donthuoc
                INNER JOIN chitietdonthuoc ON donthuoc.MaDonThuoc = chitietdonthuoc.MaDonThuoc
                INNER JOIN thuoc ON chitietdonthuoc.MaThuoc = thuoc.MaThuoc
                WHERE donthuoc.MaDonThuoc = ?
            ";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $MaDonThuoc); // Sử dụng tham số an toàn
            
                $stmt->execute();
                $result = $stmt->get_result();
                $kqk = array(); // Khởi tạo mảng kết quả
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $kqk[] = $row;
                    }
                } else {
                    $kqk = array("error" => "Không có dữ liệu");
                }
                return $kqk;
                // Trả về kết quả dưới dạng JSON mà không có dữ liệu thừa
            } else {
                echo json_encode(array("error" => "Lỗi kết nối cơ sở dữ liệu"));
            }
            
            $stmt->close();
            $conn->close();
        }
        
        public function getselectPhacDo($MaBN, $ThoiGianNV, $ThoiGianXV) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
            
            $kqk = array(); 
        
            // Viết câu lệnh SQL với điều kiện NgayLap nằm trong khoảng từ ThoiGianNV đến ThoiGianXV
            $sql = "SELECT pd.MaDonThuoc,pd.NgayLap
                    FROM phieunamvien pn
                    JOIN phacdo pd ON pn.MaBN = pd.MaBN
                    WHERE pd.MaBN = '$MaBN' 
                      AND pd.NgayLap BETWEEN '$ThoiGianNV' AND '$ThoiGianXV'";
        
            // Thực thi câu lệnh và trả về kết quả
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $kqk[] = $row; // Lưu kết quả vào mảng
                }
            }
        
            // Đóng kết nối
            $conn->close();
        
            return $kqk;
        }
        

    }
?>