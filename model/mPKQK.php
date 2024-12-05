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

    }
?>