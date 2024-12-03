<?php
include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mNguoiDung.php');
$mNguoiDung = new mNguoiDung();

if (isset($_POST['MaKhoa'])) {
    $maKhoa = $_POST['MaKhoa'];

    $bacSiList = $mNguoiDung->getBacSiByKhoa($maKhoa);
    header('Content-Type: application/json');
    echo json_encode($bacSiList);
    exit; 
   
}
?>
