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
        public function dsKhoaByID($id){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM khoa where TrangThai= 1 and MaKhoa='$id'";
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
        public function themkhoa($ten,$kv,$mt){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "INSERT INTO `khoa`(`TenKhoa`, `KhuVuc`, `MoTa`, `TrangThai`) VALUES
            ('$ten','$kv','$mt','1')";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function updateKhoa($ten,$kv,$mt,$id){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "UPDATE `khoa` SET `TenKhoa`='$ten',`KhuVuc`='$kv',`MoTa`='$mt' WHERE MaKhoa='$id' ";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function NSbyIDKhoa($id){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM nhansu where MaKhoa ='$id' ";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }

        public function getAllDepartments() {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
    
            // Truy vấn lấy danh sách khoa từ bảng khoa
            $sql = "SELECT TenKhoa FROM khoa WHERE TrangThai = 1 AND MaKhoa NOT IN (5, 10)"; 
            $result = mysqli_query($con, $sql);
    
            // Lưu kết quả vào một mảng
            $departments = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $departments[] = $row['TenKhoa'];
            }
    
            // Đóng kết nối
            $p->dongKetNoi($con);
    
            return $departments;
        }
        public function getDepartments() {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
        
            // Truy vấn lấy danh sách khoa từ bảng khoa
            $sql = "SELECT MaKhoa, TenKhoa FROM khoa WHERE TrangThai = 1 AND MaKhoa NOT IN (5, 10)"; 
            $result = mysqli_query($con, $sql);
        
            // Lưu kết quả vào một mảng
            $departments = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $departments[] = $row;
            }
        
            // Đóng kết nối
            $p->dongKetNoi($con);
        
            return $departments;
        }
        public function getalDepartments($MaBN) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
            
            $sql = "
            SELECT k.MaKhoa, k.TenKhoa, pn.MaNV 
            FROM khoa k
            JOIN phieunamvien pn ON k.MaKhoa = pn.MaKhoa
            WHERE pn.MaBN = ? AND pn.TrangThai = 'Nhập viện'";
            
            if ($stmt = mysqli_prepare($con, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $MaBN); 
                
                mysqli_stmt_execute($stmt);
                
                $result = mysqli_stmt_get_result($stmt);
                
                $departments = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $departments[] = $row;
                }
                
                mysqli_stmt_close($stmt);
            }
            
            $p->dongKetNoi($con);
            
            return $departments;
        }
        public function lay($id){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "Update khoa set TrangThai=0 where maKhoa='$id'";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }

      
    }
?>