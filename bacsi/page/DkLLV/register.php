<?php
session_start();
include_once('../../../model/mEmployee.php');
$con = new mEmployee();

if (isset($_POST['caID'])) {
    $caID = $_POST['caID'];
    $userID = $_SESSION['maNS']; // Lấy ID người dùng từ session

    // Kiểm tra số lượng hiện tại
    $checkSS = $con -> chitietphongbyMACT($caID);
    foreach($checkSS as $i){
        $ss = $i['DaDangKy'];
        $ssMax = $i['DangKyToiDa'];
    }
    if ($ss >= $ssMax) {
        echo "Ca này đã đạt số lượng đăng ký tối đa.";
        exit;
    } 
    
    $result = $con->DangKyLLVNS($userID, $caID);
    $result = $con -> CapNhatSSkhiDK($caID);  
    
    

    // Thêm đăng ký mới
    
}
?>
