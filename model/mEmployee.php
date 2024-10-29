<?php
    include_once("ketnoi.php");
    class mEmployee{
        

        public function mlogin($name,$pw){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from account where TenDangNhap ='$name' and MatKhau ='$pw' ";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function mSelectEmbyID($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from employee where id ='$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function insertWork_schedule($id,$ngay,$ca){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "INSERT INTO `lichlamviec`(`MaNS`, `Thu`, `Ca`) VALUES ('$id','$ngay','$ca')";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function selectLicTrucNV($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from lichlamviec where MaNS = '$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function ngaynghiphep(){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "SELECT * FROM lichnghiphep ";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function selectDateStartEnd($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from nhansu where MaNS = '$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function dsYCNP(){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from lichnghiphep h join nhansu j on h.MaNS=j.MaNS where h.TrangThai = 0";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function dknp($id,$date,$ca,$lydo){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "INSERT INTO `lichnghiphep`( `MaNS`, `NgayNghiPhep`, `ca`, `LyDo`, `TrangThai`) VALUES ('$id','$date','$ca','$lydo','0')";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        ///Duyet YCNP 
        public function duyetYCNP($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "UPDATE `lichnghiphep` SET  `TrangThai`='1' WHERE `maLNP`='$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function tuchoiYCNP($id,$lydo){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "UPDATE `lichnghiphep` SET `LyDo_TuChoi`='$lydo', `TrangThai`='2' WHERE `maLNP`='$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        
    }


?>