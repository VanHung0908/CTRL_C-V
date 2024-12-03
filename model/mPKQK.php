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
        public function getThuoc($MaDonThuoc) {
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
        

    }
?>