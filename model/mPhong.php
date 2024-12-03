<?php
include_once('ketnoi.php');

class mPhong {
    public function getPhongsByKhoa($MaKhoa) {

        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        
        $sql = "SELECT MaPhong, TenPhong FROM phong WHERE MaKhoa = ?"; 
        $stmt = mysqli_prepare($con, $sql);
        
        mysqli_stmt_bind_param($stmt, 's', $MaKhoa);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $phongs = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $phongs[] = $row;
        }
        
        $p->dongKetNoi($con);
        
        return $phongs;
    }
}
?>
