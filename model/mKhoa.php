<?php
    include_once('ketnoi.php');
    class mKhoa{
        public function dsKhoa(){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM khoa where TrangThai= 1";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function xoaKhoa($id){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "Update khoa set TrangThai=0 where maKhoa='$id'";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }

      
    }
?>