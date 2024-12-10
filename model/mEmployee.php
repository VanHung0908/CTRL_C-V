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
            $sql = "INSERT INTO `lichlamviec`(`MaNS`, `Thu`, `CaLam`) VALUES ('$id','$ngay','$ca')";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function LichByCa($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "SELECT * from `lichlamviec` where MaCTPhongKham='$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }

        public function selectLicTrucNV($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select NgayTrongTuan,CaTrongNgay,TenPhong from lichlamviec h 
            join chitietphongkham j on h.MaCTPhongKham=j.MaCTPhongKham join phongkham k 
            on k.maphong=j.maphong  where h.MaNS = '$id' ";
            //echo $sql;
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function ngaynghiphep($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "SELECT * FROM lichnghiphep where MaNS='$id' ";
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
            $sql = "select * from lichnghiphep h join nhansu j on h.MaNS=j.MaNS  where h.TrangThai = 0";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function NPCaNhan($id){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from lichnghiphep where MaNS='$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function dknp($id,$date,$ca,$lydo,$phong){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $currentDateTime = (new DateTime())->format('Y-m-d H:i:s');
            $sql = "INSERT INTO `lichnghiphep`( `MaNS`, `NgayNghiPhep`, `CaLam`, `LyDo`, `TrangThai`, `ThoiGianDK`,`Phong`) VALUES ('$id','$date','$ca','$lydo','0','$currentDateTime','$phong')";
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
            $sql = "UPDATE `lichnghiphep` SET `LyDo_TuChoi`='$lydo', `TrangThai`='2' WHERE `MaLNP`='$id'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }

        //lay phongkham 
        public function phongkham($makhoa){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from phongkham h join chitietphongkham j on h.MaPhong=j.MaPhong where makhoa='$makhoa' AND j.DaDangKy='0'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        // kết bảng lichlamviec và phongkham với điều kiện maKhoa của phongkham = makhoa của user
        public function chitietphongbyID($maphong){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from chitietphongkham where MaPhong ='$maphong'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function lichlamviecbyCa($ma){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from lichlamviec where MaCTPhongKham ='$ma'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function DangKyLLVNS($user,$ma){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "UPDATE `lichlamviec` SET `MaNS`='$user' WHERE MaCTPhongKham ='$ma'";
            //echo $sql;
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        
        public function CapNhatSSkhiDK($ma){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "UPDATE `chitietphongkham` SET `DaDangKy`= `DaDangKy` + 1 WHERE MaCTPhongKham ='$ma'";
            //echo $sql;
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function xemLLV($ma){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from lichlamviec where MaNS1 ='$ma' or MaNS2='$ma'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function chitietphongbyMACT($maCT){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from chitietphongkham where MaCTPhongKham ='$maCT'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        //Kiểm tra đã đăng ký lịch 
        public function ktraDaDKL($ma){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from lichlamviec where MaNS ='$ma'";
            //echo $sql;
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        
        
    }


?>