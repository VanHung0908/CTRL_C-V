<?php
include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mPhong.php');  

if (isset($_POST['MaKhoa'])) {
    $MaKhoa = $_POST['MaKhoa'];

    $mPhong = new mPhong();
    $phongs = $mPhong->getPhongsByKhoa($MaKhoa);  

    // Trả về dữ liệu phòng dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($phongs);
    exit; // Dừng script sau khi trả về JSON
}
?>
