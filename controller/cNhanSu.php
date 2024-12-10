<?php
include_once('../model/mNhanSu.php');
class cNhanSu
    {
        public function getAllNhanSu()
        {
            $p = new mNhanSu();
            $tbl = $p -> selectAllNhanSu();
            if(mysqli_num_rows($tbl) > 0)
            {
                return $tbl;
            }else{
                return 0;
            }
        }
        public function getAllChucVu()
        {
            $p = new mNhanSu();
            $tbl = $p -> selectAllChucVu();
            if(mysqli_num_rows($tbl) > 0)
            {
                return $tbl;
            }else{
                return 0;
            }
        }
        public function getAllKhoa()
        {
            $p = new mNhanSu();
            $tbl = $p -> selectAllKhoa();
            if(mysqli_num_rows($tbl) > 0)
            {
                return $tbl;
            }else{
                return 0;
            }
        }
        public function get01NhanSu($ma)
        {
            $p = new mNhanSu();
            $tbl = $p -> select01NhanSu($ma);
            if(mysqli_num_rows($tbl) > 0)
            {
                return $tbl;
            }else{
                return 0;
            }
        }
        public function cInsert01NS($ten,$ns,$email,$gt,$cccd,$NgayBatDau,$nkt,$anh,$diaChi,$macv,$tk,$khoa){
            $pp = new clsUpload;
            $name_arr=explode(".",$anh["name"]); //name
            $ext=".".$name_arr[count($name_arr)-1];  // .jpeg 
            $setnamehinhanh = $pp -> changeName($ten).$ext;
            $conn = $pp -> UploadInsert($anh, $ten);
            $p = new mNhanSu();
            $con = $p -> mInsert01NS($ten,$ns,$email,$gt,$cccd,$NgayBatDau,$nkt,$anh,$diaChi,$macv,$tk,$khoa);
            if($con){
                echo '<script>alert("Thêm nhân sự thành công !")</script>';
                header("refresh:0,url=index.php?type=NhanSu");
            }else{
                echo '<script>alert("Thêm nhân sự thất bại !")</script>';
                header("refresh:0,url=index.php?type=NhanSu");
            
            }
        }
            public function uploadNhanSu($ma, $ten, $ns, $email, $gt, $cccd, $SoDienThoai, $NgayBatDau, $diaChi, $macv, $khoa)
            {
                $p = new mNhanSu();
                $kq = $p->updateNS($ma, $ten, $ns, $email, $gt, $cccd, $SoDienThoai, $NgayBatDau, $diaChi, $macv, $khoa);
            
                if ($kq === true) {
                    echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Chỉnh sửa nhân sự thành công",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/QLBV/bacsi/index.php?page=QuanLyNhanSu";
                            }
                        });
                    </script>';
                } elseif (is_string($kq)) {
                    // Trường hợp có lỗi cụ thể trả về dưới dạng chuỗi
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Thất bại",
                            text: "Lỗi: ' . htmlspecialchars($kq) . '",
                            confirmButtonText: "Thử lại"
                        });
                    </script>';
                } else {
                    // Lỗi không xác định
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Thất bại",
                            text: "Chỉnh sửa thất bại! Vui lòng thử lại.",
                            confirmButtonText: "Thử lại"
                        });
                    </script>';
                }
            }
        
        public function cXoa01NhanSu($ma){
            $p = new mNhanSu();
            $kq = $p -> mXoa01NhanSu($ma);
            if($kq){
                echo '<script>alert("Xóa Nhân sự có ID '.$ma.' thành công ! ")</script>';
            }else{
                echo '<script>alert("Xóa Nhân sự có ID '.$ma.' thất bại ! ")</script>';
            }
        }
    }

?>