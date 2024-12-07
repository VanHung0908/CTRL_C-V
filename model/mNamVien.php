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
    public function updatePhieuNamVien(
        $MaBN, $MaKhoa, $MaPhong, $MaGiuong, $MaNS, $TamUng,
        $hoten, $gioitinh, $sdt, $diachi, $quanhe, $MaNV
    ) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi(); // Mở kết nối
    
        // Kết quả mặc định là false
        $kq = false;
    
        // Câu lệnh SQL cập nhật `phieunamvien`
        $sqlPhieuNamVien = "
            UPDATE phieunamvien
            SET 
                MaBN = ?, 
                MaKhoa = ?, 
                MaPhong = ?, 
                MaGiuong = ?, 
                MaNS = ?, 
                TamUng = ?, 
                TenNguoiLienHe = ?, 
                GioiTinh = ?, 
                SDT = ?, 
                DiaChi = ?, 
                QuanHe = ?
            WHERE 
                MaNV = ?
        ";
    
        if ($stmt = $con->prepare($sqlPhieuNamVien)) {
            $stmt->bind_param(
                "iiiiissssssi",
                $MaBN, $MaKhoa, $MaPhong, $MaGiuong, $MaNS, $TamUng,
                $hoten, $gioitinh, $sdt, $diachi, $quanhe, $MaNV
            );
    
            if ($stmt->execute()) {
                // Kiểm tra nếu `phieunamvien` được cập nhật
                if ($stmt->affected_rows > 0) {
                    // Câu lệnh SQL cập nhật `phieudangkykham`
                    $sqlPhieuDangKyKham = "
                        UPDATE phieudangkykham
                        SET TrangThai = 'Đang điều trị'
                        WHERE MaBN = ? AND DATE(NgayKham) = CURDATE()
                    ";
    
                    if ($stmtUpdate = $con->prepare($sqlPhieuDangKyKham)) {
                        $stmtUpdate->bind_param("i", $MaBN);
    
                        if ($stmtUpdate->execute() && $stmtUpdate->affected_rows > 0) {
                            $kq = true; // Cập nhật thành công cả hai bảng
                        }
    
                        $stmtUpdate->close();
                    }
                }
            }
    
            $stmt->close();
        }
    
        $p->dongKetNoi($con); // Đóng kết nối
    
        return $kq ? "Cập nhật thành công cả hai bảng!" : "Không có thay đổi nào được thực hiện.";
    }

    public function updateNhapVien($MaBN, $TenNguoiLienHe, $QuanHe, $TamUng,$MaPhong,$MaGiuong) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi(); 
        $sql =  "UPDATE phieunamvien 
        SET TenNguoiLienHe = '$TenNguoiLienHe', QuanHe = '$QuanHe', TamUng = '$TamUng',MaPhong = '$MaPhong', MaGiuong = '$MaGiuong'
        WHERE MaBN ='$MaBN' AND TrangThai = 'Nhập viện'";
        $result = mysqli_query($con, $sql);
        $p -> dongKetNoi($con);
        return $result;
    }
    public function xuatvien($ThoiGianXV, $ChuanDoanKQ, $PhuongPhapDieuTri, $GhiChu, $MaBN, $MaNV){
        $p = new clsKetNoi();
        $con = $p->moKetNoi(); 
        $sql =  "UPDATE phieunamvien 
        SET ThoiGianXV = '$ThoiGianXV', ChuanDoanKQ = '$ChuanDoanKQ', PhuongPhapDieuTri = '$PhuongPhapDieuTri',GhiChu = '$GhiChu', TrangThai = 'Xuất viện'
        WHERE MaNV ='$MaNV' ";
        $sql ="Update benhnhan set TrangThai='Xuất viện' where MaBN='$MaBN'";
        $result = mysqli_query($con, $sql);
        $p -> dongKetNoi($con);
        return $result;
    }



} 

?>
