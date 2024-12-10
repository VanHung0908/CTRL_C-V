<?php
    include_once('ketnoi.php');
    class mNhanSu{
        public function selectAllNhanSu(){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * 
                FROM khoa k 
                JOIN nhansu ns ON k.MaKhoa = ns.MaKhoa 
                JOIN chucvu cv ON ns.MaCV = cv.MaCV 
                WHERE ns.NgayKetThuc IS NULL 
                ORDER BY ns.NgayBatDau ASC ;";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function selectAllKhoa(){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM khoa";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function selectAllChucVu(){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM chucvu";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function select01NhanSu($ma)
        {
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $sql = "SELECT * FROM khoa k join nhansu ns on k.MaKhoa= ns.MaKhoa join chucvu cv on ns.MaCV=cv.MaCV where MaNS='$ma'";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        public function selectAllNhanSuByType($ma)
        {
            $p=new clsketnoi();
            $con=$p->MoKetNoi();
            $truyvan= "SELECT * FROM khoa k join nhansu ns on k.MaKhoa= ns.MaKhoa join chucvu cv on ns.MaCV=cv.MaCV WHERE MaNS=$ma";
            $tbl = mysqli_query($con,$truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function selectAllNhanSuByName($ten)
        {
            $p=new clsketnoi();
            $con=$p->MoKetNoi();
            $truyvan= "SELECT * FROM khoa k join nhansu ns on k.MaKhoa= ns.MaKhoa join chucvu cv on ns.MaCV=cv.MaCV WHERE HoTen like N'%$ten%'";
            $tbl = mysqli_query($con,$truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        
        public function insertNS($HoTen,$NgaySinh,$GioiTinh,$Email,$DiaChi,$CCCD,$MaCV,$MaKhoa)
        {
            $p=new clsketnoi();
            $con=$p->MoKetNoi();
            $NgayBatDau = date('Y-m-d');
            $truyvan = "INSERT INTO nhansu(HoTen, NgaySinh, Email, GioiTinh, CCCD, NgayBatDau, DiaChi, MaCV, MaKhoa) 
            VALUES ('$HoTen', '$NgaySinh', '$Email', '$GioiTinh', '$CCCD', '$NgayBatDau', '$DiaChi', '$MaCV', '$MaKhoa');";
            $truyvan .= "UPDATE nhansu 
                        SET TaiKhoan = CONCAT(
                            LPAD(MaKhoa, 2, '0'), 
                            LPAD(LAST_INSERT_ID(), 3, '0')
                        ) 
                        WHERE MaNS = LAST_INSERT_ID();";

            $tbl = mysqli_query($con,$truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function updateNS($ma, $ten, $ns, $email, $gt, $cccd, $SoDienThoai, $NgayBatDau, $diaChi, $macv, $khoa)
        {
            $p = new clsKetNoi();
            $con = $p->MoKetNoi();
        
            try {
                // Câu truy vấn cập nhật
                $query = "UPDATE nhansu SET 
                            HoTen = '$ten', 
                            NgaySinh = '$ns', 
                            Email = '$email', 
                            SoDienThoai = '$SoDienThoai', 
                            GioiTinh = '$gt', 
                            CCCD = '$cccd', 
                            NgayBatDau = '$NgayBatDau', 
                            DiaChi = N'$diaChi', 
                            MaCV = '$macv', 
                            MaKhoa = '$khoa' 
                          WHERE MaNS = '$ma'";
        
                // Thực thi truy vấn
                mysqli_query($con, $query);
        
                $p->dongKetNoi($con);
                return true; // Thành công
        
            } catch (mysqli_sql_exception $e) {
                // Xử lý lỗi cụ thể
                if ($e->getCode() == 1062) {
                    // Trích xuất lỗi UNIQUE
                    if (strpos($e->getMessage(), 'SoDienThoai') !== false) {
                        return "Số điện thoại đã tồn tại, vui lòng nhập số khác.";
                    }
                }
        
                // Trả về lỗi chung
                return "Lỗi khi cập nhật: " . $e->getMessage();
            }
        }
        
        
        public function xoaNS($id){
            $p = new clsKetNoi();
            $con = $p -> moKetNoi();
            $NgayKetThuc = date('Y-m-d');
            $sql = "Update nhansu set NgayKetThuc='$NgayKetThuc' where MaNS='$id'";
            $kq = mysqli_query($con,$sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
    }
?>