<?php

include_once(__DIR__ . '/../model/mBenhNhan.php');
include_once(__DIR__ . '/../model/ketnoi.php');

    class cBenhNhan {
        public function getUserInfo() {
            if (isset($_SESSION['dangnhap']) && $_SESSION['dangnhap'] == 1) {
                // Lấy mã nhân viên từ session
                $maNS = $_SESSION['maNS'];

                // Lấy thông tin từ model
                $model = new mBenhNhan();
                $hoTen = $model->getHoTenByMaNS($maNS);

                // Truyền dữ liệu vào view
                include('view_benhnhan.php');  // Đưa thông tin vào view
            } else {
                
            }
        }
        public function getBenhNhanByCCCD($SDT) {
            $p = new clsKetNoi();
            $conn = $p->moKetNoi();
                $query = "SELECT * FROM benhnhan WHERE SDT = '$SDT'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    return mysqli_fetch_assoc($result);
                } else {
                    return null;
                }
                
        }
        public function addDKKhamBenh($hoTen, $ngaySinh, $gioiTinh, $sdt, $maKhoa, $diaChi, $cccd, $bhyT, $loaiBHYT, $chiPhi, $phuongThucThanhToan) {
            $model = new mBenhNhan();
            // Gọi phương thức thêm đăng ký khám bệnh trong model và nhận kết quả
            $result = $model->insertDKKhamBenh($hoTen, $ngaySinh, $gioiTinh, $sdt, $maKhoa, $diaChi, $cccd, $bhyT, $loaiBHYT, $chiPhi, $phuongThucThanhToan);
            // Kiểm tra kết quả và hiển thị thông báo
            if ($result === true) { 
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Đăng ký khám bệnh thành công!",
                        confirmButtonText: "OK"
                    });
                </script>';
            } elseif ($result === false) { 
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Thất bại",
                        text: "Đăng ký khám bệnh thất bại! Vui lòng kiểm tra lại thông tin.",
                        confirmButtonText: "Thử lại"
                    });
                </script>';
            } else { 
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi hệ thống",
                        text: "' . $result . '",
                        confirmButtonText: "Thử lại"
                    });
                </script>';
            }
        }
     public function updateDKKhamBenh($hoTen, $ngaySinh, $gioiTinh, $sdt, $maKhoa, $diaChi, $cccd, $bhyT, $loaiBHYT,$chiPhi, $phuongThucThanhToan) {
    // Tạo đối tượng model
    $model = new mBenhNhan();
    // Gọi phương thức cập nhật thông tin bệnh nhân trong model và nhận kết quả
    $result = $model->updateDKKhamBenh($hoTen, $ngaySinh, $gioiTinh, $sdt, $maKhoa, $diaChi, $cccd, $bhyT, $loaiBHYT,$chiPhi, $phuongThucThanhToan);

    // Kiểm tra kết quả và hiển thị thông báo
    if ($result === true) { // Nếu kết quả là true, cập nhật thành công
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Đăng ký khám bệnh thành công!",
                confirmButtonText: "OK"
            });
        </script>';
    } elseif ($result === false) { // Nếu kết quả là false, cập nhật thất bại
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Đăng ký khám bệnh thất bại! Vui lòng kiểm tra lại thông tin.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    } else { // Nếu kết quả trả về là thông báo lỗi, hiển thị thông báo đó
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Lỗi hệ thống",
                text: "' . $result . '",
                confirmButtonText: "Thử lại"
            });
        </script>';
    }
}

        
        
    }
    
?>
