<?php
include_once('ketnoi.php');

class mPhacDo {
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
}
?>