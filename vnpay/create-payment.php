<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/QLBV/vnpay/payment-result.php";
$vnp_TmnCode = "CRE8YO3Q";
$vnp_HashSecret = "RPGU3OSO3YRV41GLQBJDV0O3PVRNP1FF";
session_start(); 

if (isset($_POST['selectedDate']) && isset($_POST['selectedTime']) && isset($_POST['department']) && isset($_POST['doctor'])) {
    // Lưu dữ liệu vào session
    $_SESSION['selectedDate'] = $_POST['selectedDate'];
    $_SESSION['selectedTime'] = $_POST['selectedTime'];
    $_SESSION['department'] = $_POST['department'];
    $_SESSION['doctor'] = $_POST['doctor'];
}

$vnp_Amount = isset($_POST['amount']) ? $_POST['amount'] * 100 : 100000; 
$vnp_OrderInfo = isset($_POST['orderInfo']) ? $_POST['orderInfo'] : 'Thanh toán chi phí khám';  
// Các tham số khác
$vnp_OrderType = $vnp_OrderInfo;  
$vnp_Locale = "vn";  
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];  
$startTime = date("YmdHis");
$vnp_ExpireDate = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

$inputData = array(
    "vnp_Version" => "2.1.0",        
    "vnp_TmnCode" => $vnp_TmnCode,    
    "vnp_Amount" => $vnp_Amount,     
    "vnp_Command" => "pay",           
    "vnp_CreateDate" => date('YmdHis'), 
    "vnp_CurrCode" => "VND",        
    "vnp_IpAddr" => $vnp_IpAddr,      
    "vnp_Locale" => $vnp_Locale,      
    "vnp_OrderInfo" => $vnp_OrderInfo, 
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl, 
    "vnp_TxnRef" => uniqid(),         
    "vnp_ExpireDate" => $vnp_ExpireDate 
);

ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";

foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . rtrim($query, '&');
if (!empty($vnp_HashSecret)) {
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;  
}

$returnData = array('success' => true, 'paymentUrl' => $vnp_Url);
echo json_encode($returnData);  
?>
