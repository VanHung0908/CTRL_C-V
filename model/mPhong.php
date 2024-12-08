<?php
    include_once("ketnoi.php");
    class phong{
        //Phong
        public function AllPhongbyKhoa($idKhoa){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from khoa h join phongkham j on h.MaKhoa=j.MaKhoa where j.MaKhoa ='$idKhoa'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function PhongByID($idPhong){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from  phongkham  where MaPhong ='$idPhong'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function InsertPhong($ten,$toa,$mt,$idKhoa){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "INSERT INTO `phongkham`( `TenPhong`, `Toa`, `MoTa`, `MaKhoa`)
             VALUES ('$ten','$toa','$mt','$idKhoa')";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        //Ca
        public function AllCabyPhong($idPhong){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from chitietphongkham h join phongkham j on h.MaPhong=j.MaPhong where j.MaPhong ='$idPhong'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function CabyID($idPhong){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from chitietphongkham where MaCTPhongKham ='$idPhong'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function InsertCaByPhong($idPhong,$ten,$dadk,$maxdk){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "INSERT INTO `chitietphongkham`( `MaPhong`, `TenCa`, `DaDangKy`, `DangKyToiDa`) 
            VALUES ('$idPhong','$ten','$dadk','$maxdk')";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        
        //ChiTiet Ca
        public function AllCTCabyCa($idCa){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "select * from chitietphongkham h join lichlamviec j on h.MaCTPhongKham=j.MaCTPhongKham where j.MaCTPhongKham ='$idCa'";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        public function CTCabyCa($idCa,$day,$ca){
            $con = new clsKetNoi;
            $p = $con -> moKetNoi();
            $sql = "INSERT INTO `lichlamviec`(`MaCTPhongKham`, `NgayTrongTuan`, `CaTrongNgay`,  `MaNS`) 
            VALUES ('$idCa','$day','$ca','0')";
            $kq = mysqli_query($p,$sql);
            return $kq;
        }
        
    }

?>