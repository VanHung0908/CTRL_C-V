<?php
include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mGiuong.php');  

if (isset($_POST['MaPhong'])) {  
    $MaPhong = $_POST['MaPhong']; 

    $mGiuong = new mGiuong();
    $giuongs = $mGiuong->getGiuong($MaPhong);  

    header('Content-Type: application/json');
    echo json_encode($giuongs);  
    exit;  
}
?>
