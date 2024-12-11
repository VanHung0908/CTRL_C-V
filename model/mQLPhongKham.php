<?php 
class phong{
    //Phong
    public function AllPhongbyKhoa($idKhoa){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "select * from khoa h join phongkham  j on h.MaKhoa=j.MaKhoa where j.MaKhoa ='$idKhoa'";
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
    public function UpdatePhong($ten,$toa,$mt,$idKhoa){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "UPDATE `phongkham` SET `TenPhong`='$ten',`Toa`='$toa',`MoTa`='$mt' WHERE MaPhong='$idKhoa'";
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
    public function UpdateCa($id,$ten,$ddk,$max){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "UPDATE `chitietphongkham` SET `TenCa`='$ten'
        ,`DaDangKy`='$ddk',`DangKyToiDa`='$max' WHERE MaCTPhongKHam='$id'";
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
    public function CTCaByID($id){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "select * from lichlamviec where MaCTPhongKham='$id'";
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
    public function UpdateCTCa($id,$day,$ca){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "UPDATE `lichlamviec` SET `NgayTrongTuan`='$day',`CaTrongNgay`='$ca' WHERE MaLLV ='$id'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
    public function ALLCTCaByPhong($idCa){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "SELECT * FROM lichlamviec h join chitietphongkham j on h.MaCTPhongKham=j.MaCTPhongKham 
        JOIN phongkham k on j.MaPhong=k.MaPhong WHERE k.MaPhong = '$idCa'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
    public function checkExistingSchedule($idCa,$day,$ca){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "SELECT * FROM lichlamviec h join chitietphongkham j on h.MaCTPhongKham=j.MaCTPhongKham 
        JOIN phongkham k on j.MaPhong=k.MaPhong WHERE k.MaPhong = '$idCa' AND CaTrongNgay='$ca' AND NgayTrongTuan='$day'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
    public function xoaChiTiet($id){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "DELETE FROM `lichlamviec` WHERE MaLLV='$id'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
    public function xoaCa($id){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "DELETE FROM `chitietphongkham` WHERE MaCTPhongKham='$id'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
    public function ktraCaDDK($id){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "SELECT * FROM `chitietphongkham` WHERE DaDangKy > 0 AND MaCTPhongKham='$id'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
    public function ktraPhongCoCa($id){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "SELECT * FROM `chitietphongkham` WHERE DaDangKy > 0 AND MaPhong = '$id'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
    public function xoaPhong($id){
        $con = new clsKetNoi;
        $p = $con -> moKetNoi();
        $sql = "DELETE FROM `PhongKham` WHERE MaPhong='$id'";
        $kq = mysqli_query($p,$sql);
        return $kq;
    }
}
// include_once('ketnoi.php');

// class mPhong {
//     public function getPhongsByKhoa($MaKhoa) {

//         $p = new clsKetNoi();
//         $con = $p->moKetNoi();
        
//         $sql = "SELECT MaPhong, TenPhong FROM phong WHERE MaKhoa = ?"; 
//         $stmt = mysqli_prepare($con, $sql);
        
//         mysqli_stmt_bind_param($stmt, 's', $MaKhoa);
//         mysqli_stmt_execute($stmt);
//         $result = mysqli_stmt_get_result($stmt);
        
//         $phongs = [];
//         while ($row = mysqli_fetch_assoc($result)) {
//             $phongs[] = $row;
//         }
        
//         $p->dongKetNoi($con);
        
//         return $phongs;
//     }
// }

?>
