<?php
    session_start();
    include_once('../../model/mBenhNhan.php');
    
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
    }
?>
