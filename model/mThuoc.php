<?php
    include_once('ketnoi.php');
    class mThuoc{
        public function getAllThuoc() {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
            
            $sql = "SELECT MaThuoc, TenThuoc FROM thuoc ";
            $result = mysqli_query($con, $sql);
            
            $thuocs = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $thuocs[] = $row;
            }
            
            $p->dongKetNoi($con);
            
            return $thuocs;
        }
        
        
    }
?>