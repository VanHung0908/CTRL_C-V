<?php
    include_once('ketnoi.php');

    class mBenhNhan {
        public function getHoTenByMaBN($maBN) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
    
            // Truy vấn lấy thông tin HoTen từ bảng benhnhan
            $sql = "SELECT HoTen FROM benhnhan WHERE MaBN = '$maBN'";
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
    }
?>
