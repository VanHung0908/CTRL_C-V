<?php
include(__DIR__ . '../../model/ketnoi.php');
include_once(BACKEND_URL . 'model/mNguoiDung.php');

// Lấy tên khoa từ yêu cầu
$tenKhoa = $_POST['tenKhoa'];

// Sử dụng model để lấy danh sách bác sĩ
$model = new mNguoiDung();
$doctors = $model->getDoctorsByDepartment($tenKhoa);

// Đảm bảo không có ký tự HTML thừa
echo json_encode($doctors);
exit;
?>
