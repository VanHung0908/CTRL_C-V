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
        $stmt->execute();

        $stmt->close();
        $p->dongKetNoi($con);
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
        
        return 0; // Nếu không có kết quả thì trả về 0
        
        // Đóng kết nối
        $stmt->close();
        $p->dongKetNoi($con);
    }
    
    
}
?>
