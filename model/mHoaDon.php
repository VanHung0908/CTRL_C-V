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
        public function insertHD($TongTienPhong, $TongTienThuoc, $TongNgay, $TongChiPhi, $TamUng, $SoTienBNTT, $SoTienBVTT, $percentBHYT,$MaBN, $MaNV,$MaNS,$PhuongThucThanhToan) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
        
            // Bắt đầu transaction
            $conn->begin_transaction();
        
            try {
                // INSERT vào bảng hoadonxuatvien
                $sqlHoaDonXV = "INSERT INTO hoadonxuatvien (TongTienPhong, TongTienThuoc, TongNgay, TongChiPhi, TamUng, SoTienBNTT, SoTienBVTT, MaBN, MaNV) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sqlHoaDonXV);
                $stmt->bind_param("dddddddss", $TongTienPhong, $TongTienThuoc, $TongNgay, $TongChiPhi, $TamUng, $SoTienBNTT, $SoTienBVTT, $MaBN, $MaNV);
                $stmt->execute();

                // Lấy MaHDXV vừa được tạo
                $MaHDXV = $conn->insert_id;

                // INSERT vào bảng hoadon
                $sqlHoaDon = "INSERT INTO hoadon (MaHDXV, KhauTruBHYT, TongTien, NgayLapHD, TrangThaiThanhToan, PhuongThucThanhToan, MaBN, MaNS) 
                      VALUES (?, ?, ?, NOW(), 'Đã thanh toán', ?, ?, ?)";
                $stmtHD = $conn->prepare($sqlHoaDon);
                $stmtHD->bind_param("iddsss", $MaHDXV, $percentBHYT, $TongChiPhi, $PhuongThucThanhToan, $MaBN, $MaNS);
                $stmtHD->execute();

                
                $sqlUpdate1 = "UPDATE phieudangkykham SET TrangThai = 'Xuất viện' WHERE MaBN = ?";
                $stmt1 = $conn->prepare($sqlUpdate1);
                $stmt1->bind_param("s", $MaBN);
                $stmt1->execute();

                $sqlUpdate2 = "UPDATE benhnhan SET TrangThai = '' WHERE MaBN = ?";
                $stmt2 = $conn->prepare($sqlUpdate2);
                $stmt2->bind_param("s", $MaBN);
                $stmt2->execute();
                $conn->commit();
        
                return true; // Thành công
            } catch (Exception $e) {
                $conn->rollback(); // Rollback nếu lỗi
                return false; // Thất bại
            } finally {
                $p->dongKetNoi($conn); // Đóng kết nối
            }
        }
        
        

    }
?>