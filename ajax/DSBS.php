<?php
include(__DIR__ . '../../model/ketnoi.php');
include_once(BACKEND_URL . 'model/mNguoiDung.php');

// Lấy dữ liệu từ yêu cầu POST
$tenKhoa = $_POST['tenKhoa'];
$date = $_POST['date'];
$month = $_POST['month'];
$year = $_POST['year'];
$time = $_POST['time'];

// Chuyển đổi ngày, tháng, năm sang thứ
$timestamp = strtotime("$year-$month-$date");
$thuMapping = [
    0 => 6, // Chủ nhật
    1 => 0, // Thứ hai
    2 => 1, // Thứ ba
    3 => 2, // Thứ tư
    4 => 3, // Thứ năm
    5 => 4, // Thứ sáu
    6 => 5  // Thứ bảy
];
$dayOfWeek = date('w', $timestamp);
$thu = $thuMapping[$dayOfWeek];

// Chuyển đổi thời gian sang giá trị CaLam
$caLam = null;
$time = str_pad($time, 5, '0', STR_PAD_LEFT); 
if ($time >= "08:00" && $time <= "11:00") {
    $caLam = 1;
} elseif ($time >= "13:00" && $time <= "16:30") {
    $caLam = 2;
}
// Sử dụng model để lấy danh sách bác sĩ
$model = new mNguoiDung();
$doctors = $model->getDoctorsByDepartment($tenKhoa, $thu ,  $caLam);


// Chuẩn bị dữ liệu trả về
$response = [
    'doctors' => $doctors,
];

// Trả dữ liệu về client
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
