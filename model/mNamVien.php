<?php
include_once('ketnoi.php');
class NamVien {
    public function insertPhieuNamVien($LyDo, $ChuanDoanBD, $ThoiGianNV, $TienSuBenh, $ThuocDangSD, $MaBN, $MaKhoa) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        $kq = false; // Mặc định kết quả là false

        // Câu lệnh INSERT
        $sqlInsert = "INSERT INTO phieunamvien (LyDo, ChuanDoanBD, ThoiGianNV, TienSuBenh, ThuocDangSD, MaBN, MaKhoa, TrangThai)
                      VALUES (?, ?, ?, ?, ?, ?, ?, 'Nhập viện')";
        
        if ($stmtInsert = $con->prepare($sqlInsert)) {
            $stmtInsert->bind_param("sssssss", $LyDo, $ChuanDoanBD, $ThoiGianNV, $TienSuBenh, $ThuocDangSD, $MaBN, $MaKhoa);
            
            // Thực hiện INSERT
            if ($stmtInsert->execute()) {
                // Nếu INSERT thành công, thực hiện UPDATE trạng thái trong bảng benhnhan
                $sqlUpdateBenhNhan = "UPDATE benhnhan SET TrangThai = 'Nhập viện' WHERE MaBN = ?";
                if ($stmtUpdateBenhNhan = $con->prepare($sqlUpdateBenhNhan)) {
                    $stmtUpdateBenhNhan->bind_param("s", $MaBN);
                    if ($stmtUpdateBenhNhan->execute()) {
                        // Nếu UPDATE bảng benhnhan thành công, tiếp tục UPDATE bảng phieudangkykham
                        $sqlUpdatePhieuDK = "UPDATE phieudangkykham SET TrangThai = 'Nhập viện' WHERE MaBN = ?";
                        if ($stmtUpdatePhieuDK = $con->prepare($sqlUpdatePhieuDK)) {
                            $stmtUpdatePhieuDK->bind_param("s", $MaBN);
                            $kq = $stmtUpdatePhieuDK->execute(); // Kết quả là true nếu tất cả thành công
                            $stmtUpdatePhieuDK->close();
                        }
                    }
                    $stmtUpdateBenhNhan->close();
                }
            }
            $stmtInsert->close();
        }

        // Đóng kết nối
        $p->dongKetNoi($con);
        
        return $kq;
    }
}
?>
