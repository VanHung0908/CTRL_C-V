<?php
include_once('ketnoi.php');

class mDonThuoc {
    // Hàm thêm đơn thuốc
    public function insertDonThuoc($maBN, $ngayKeDon, $tongTien) {
        $p = new clsKetNoi(); // Tạo đối tượng kết nối
        $con = $p->moKetNoi(); // Mở kết nối đến database

        // Câu lệnh SQL để thêm đơn thuốc
        $sql = "INSERT INTO donthuoc (NgayKeDon, TongTien) VALUES ( ?, ?)";
        $stmt = $con->prepare($sql); // Chuẩn bị câu lệnh
        $stmt->bind_param("sd",  $ngayKeDon, $tongTien); // Gán tham số
        $stmt->execute(); // Thực thi câu lệnh

        $lastInsertId = $stmt->insert_id; // Lấy ID đơn thuốc vừa thêm
        $stmt->close(); // Đóng câu lệnh
        $p->dongKetNoi($con); // Đóng kết nối

        return $lastInsertId; // Trả về ID đơn thuốc
    }

    // Hàm thêm chi tiết đơn thuốc
    public function insertChiTietDonThuoc($maDonThuoc, $maThuoc, $soLuong, $lieuDung, $cachDung) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
    
        // Câu lệnh SQL để thêm chi tiết đơn thuốc
        $sql = "INSERT INTO chitietdonthuoc (MaDonThuoc, MaThuoc, SoLuong, LieuDung, CachDung) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iiiss", $maDonThuoc, $maThuoc, $soLuong, $lieuDung, $cachDung);
    
        if ($stmt->execute()) {
            $stmt->close();
            $p->dongKetNoi($con);
            return true;
        }
    
        // Đảm bảo đóng kết nối nếu có lỗi
        $stmt->close();
        $p->dongKetNoi($con);
        return false;
    }
    
    public function getGiaThuoc($maThuoc) {
        // Khởi tạo đối tượng kết nối
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
    
        // Truy vấn lấy giá thuốc
        $sql = "SELECT Gia FROM thuoc WHERE MaThuoc = ?";
        $stmt = $con->prepare($sql);
        
        // Liên kết tham số (sử dụng 's' nếu MaThuoc là chuỗi, 'i' nếu là số nguyên)
        $stmt->bind_param('i', $maThuoc); // 'i' là kiểu dữ liệu integer cho $maThuoc
        
        // Thực thi câu lệnh
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        
        // Kiểm tra kết quả và trả về giá trị
        if ($result && $row = $result->fetch_assoc()) {
            return $row['Gia'];
        }
        
        return 0; 
        
        // Đóng kết nối
        $stmt->close();
        $p->dongKetNoi($con);
    }
    public function insertHoaDon($khauTruBHYT, $tongTien, $ngayLapHD, $trangThaiThanhToan, $maDonThuoc, $maBN, $maNS, $maDDK) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        $phuongThucThanhToan = 'Chưa thanh toán';
        // Tạo câu lệnh SQL
        $sql = "INSERT INTO hoadon (KhauTruBHYT, TongTien, NgayLapHD, TrangThaiThanhToan, PhuongThucThanhToan, MaDonThuoc, MaBN, MaNS, MaDDK) 
                VALUES ('$khauTruBHYT', '$tongTien', '$ngayLapHD', '$trangThaiThanhToan', '$phuongThucThanhToan', '$maDonThuoc', '$maBN', '$maNS', '$maDDK')";
    
        // Thực thi câu lệnh và kiểm tra kết quả
        if (mysqli_query($con, $sql)) {
            $p->dongKetNoi($con);
            return true; // Thành công
        } else {
            $p->dongKetNoi($con);
            return false; // Thất bại
        }
    }
    public function insertPhieuKQKham($chuanDoan, $ngayTaiKham, $ngayKham, $maNS, $maDonThuoc, $maBN)
    {
        try {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
    
            $query = "INSERT INTO phieuketquakham (ChanDoan, NgayTaiKham, NgayKham, MaNS, MaDonThuoc, MaBN) 
            VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssssii", $chuanDoan, $ngayTaiKham, $ngayKham, $maNS, $maDonThuoc, $maBN);

            $stmt->execute();

    
            $result = $stmt->execute();
    
            $p->dongKetNoi($conn);
    
            return $result;
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm phiếu kết quả khám: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateTrangThaiPhieuDKKham($MaDKK, $TrangThai)
{
    try {
        $p = new clsKetNoi();
        $conn = $p->moKetNoi();

        $query = "UPDATE phieudangkykham 
        SET TrangThai = ? 
        WHERE MaDKK = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("si", $TrangThai, $MaDKK);
        $result = $stmt->execute();
        $p->dongKetNoi($conn);

        return $result;
    } catch (PDOException $e) {
        return false;
    }
}
public function updateTrangThaiBenhNhan($MaBN, $TrangThai)
{
    try {
        $p = new clsKetNoi();
        $conn = $p->moKetNoi();

        $query = "UPDATE benhnhan 
        SET TrangThai = ? 
        WHERE MaBN = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("si", $TrangThai, $MaBN);
        $result = $stmt->execute();
        $p->dongKetNoi($conn);

        return $result;
    } catch (PDOException $e) {
        return false;
    }
}
public function insertPhacDo($ngayKeDon, $ChuanDoan, $KeHoach, $CheDoDD, $maDonThuoc, $maBN, $MaNS) {
    try {
        $p = new clsKetNoi();
        $conn = $p->moKetNoi();

        $query = "INSERT INTO phacdo (ChanDoan, NgayLap, KeHoach, CheDoDD, MaDonThuoc, MaBN, MaNS) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            throw new mysqli_sql_exception("Lỗi khi chuẩn bị câu lệnh SQL");
        }

        $stmt->bind_param("ssssiii", $ChuanDoan, $ngayKeDon, $KeHoach, $CheDoDD, $maDonThuoc, $maBN, $MaNS);

        if ($stmt->execute()) {
            $stmt->close();
            $p->dongKetNoi($conn);
            return true;
        }

        // Đảm bảo đóng kết nối nếu có lỗi
        $stmt->close();
        $p->dongKetNoi($conn);
        return false;

    } catch (mysqli_sql_exception $e) {
        error_log("Lỗi khi thêm phác đồ: " . $e->getMessage());
        return false;
    }
}


    
    
    
    
    
}
?>
