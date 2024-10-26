<?php
    include_once('ketnoi.php');
    class mNguoiDung{
        public function select01NguoiDung($user,$pw){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM taikhoan where tenTk='$user' and matKhau = '$pw'";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
      
    }
?>