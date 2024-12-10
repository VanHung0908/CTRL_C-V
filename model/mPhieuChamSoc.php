<?php
include_once('ketnoi.php');

class mPhieuChamSoc {
    public function insertPhieuChamSoc($MaBN,$MaNS, $TinhTrang, $HuyetAp, $NhipTim, $NhietDoCoThe, $NhipTho, $GhiChu, $NgayThucHien)
    {
        $p=new clsketnoi();
        $con=$p->MoKetNoi();
        $sql = "INSERT INTO phieuchamsoc (MaBN,MaNS, TinhTrang, HuyetAp, NhipTim, NhietDoCoThe, NhipTho, GhiChu, NgayThucHien) 
        VALUES (' $MaBN',$MaNS, '$TinhTrang', '$HuyetAp',' $NhipTim', '$NhietDoCoThe', '$NhipTho',' $GhiChu',' $NgayThucHien')";
        
        $tbl = mysqli_query($con,$sql);
        $p->dongKetNoi($con);
        return $tbl;
    }
    public function getPhieuChamSoc($MaBN) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        $sql = " select pcs.TinhTrang, pcs.NhipTim, pcs.NhipTho,pcs.HuyetAp,pcs.NhietDoCoThe,pcs.GhiChu,pcs.NgayThuchien, ns.HoTen as TenNhanSu, bn.HoTen as TenBenhNhan
         from phieuchamsoc pcs 
        join nhansu ns on pcs.MaNS=ns.MaNS
        join benhnhan bn on pcs.MaBN=bn.MaBN
         where pcs.MaBN='$MaBN'";
        $result = mysqli_query($con, $sql);
        $resultKQK = []; // Khởi tạo mảng rỗng để lưu kết quả
    
        // Kiểm tra và thêm dữ liệu vào mảng
        while ($row = mysqli_fetch_assoc($result)) {
            $resultKQK[] = $row;
        }
    
        // Đóng kết nối
        $p->dongKetNoi($con);
    
        return $resultKQK;
    }
    
}
?>