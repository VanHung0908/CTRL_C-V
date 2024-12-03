<?php
    include_once('ketnoi.php');
    class mHoaDon{
        public function updateHoadon($MaDonThuoc, $phuongThucThanhToan, $MaBN) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
            $sqlHoaDon = "UPDATE hoadon 
                          SET PhuongThucThanhToan = ?, TrangThaiThanhToan = 'Đã thanh toán' 
                          WHERE MaDonThuoc = ?";
            $stmtHoaDon = $conn->prepare($sqlHoaDon);
            $stmtHoaDon->bind_param("si", $phuongThucThanhToan, $MaDonThuoc);
            
            if ($stmtHoaDon->execute()) {
                $sqlPDK = "UPDATE phieudangkykham 
                           SET TrangThai = 'Đã thanh toán' 
                           WHERE MaBN = ? AND DATE(NgayKham) = CURDATE()"; 
                $stmtPDK = $conn->prepare($sqlPDK);
                $stmtPDK->bind_param("i", $MaBN);
        
                if ($stmtPDK->execute()) {
                    return true; 
                    echo "Lỗi cập nhật bảng phieudangkykham: " . $stmtPDK->error;
                    return false; 
                }
            } else {
                echo "Lỗi cập nhật bảng hoadon: " . $stmtHoaDon->error;
                return false; 
            }
        }
        

    }
?>