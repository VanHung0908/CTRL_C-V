<?php
include_once('../model/mPhieuDKKham.php');
session_start();

$vnp_HashSecret = "RPGU3OSO3YRV41GLQBJDV0O3PVRNP1FF";

// Nhận giá trị từ URL trả về của VNPAY
$vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? null;
$vnp_SecureHash = $_GET['vnp_SecureHash'] ?? null;

// Kiểm tra mã bảo mật
$inputData = $_GET;
unset($inputData['vnp_SecureHash']); // Loại bỏ SecureHash
ksort($inputData); // Sắp xếp dữ liệu

$query = http_build_query($inputData);
$secureHash = hash_hmac('sha512', $query, $vnp_HashSecret);

// Kiểm tra SecureHash và ResponseCode để chuyển trang
if ($secureHash === $vnp_SecureHash) {
    if ($vnp_ResponseCode == '00') {
        // Kiểm tra nếu có các giá trị trong session
        if (isset($_SESSION['selectedDate'], $_SESSION['selectedTime'], $_SESSION['department'], $_SESSION['doctor'])) {
            $selectedDate = $_SESSION['selectedDate'];
            $selectedTime = $_SESSION['selectedTime'];
            $department = $_SESSION['department'];
            $doctor = $_SESSION['doctor'];
            $maBN = $_SESSION['maBN'];
            $txnRef = $inputData['vnp_TxnRef'] ?? null;  // Mã thanh toán, nếu có
            $amount = $inputData['vnp_Amount'] ?? null;  // Số tiền, nếu có
            echo "Ngày: " . htmlspecialchars($selectedDate) . "<br>";
            echo "Giờ: " . htmlspecialchars($selectedTime) . "<br>";
            echo "Khoa: " . htmlspecialchars($department) . "<br>";
            echo "Bác sĩ: " . htmlspecialchars($doctor) . "<br>";
            echo "Mã thanh toán: " . htmlspecialchars($txnRef) . "<br>";
            echo "Số tiền: " . htmlspecialchars($amount) . "<br>";
            echo $maBN;
            $model = new mPhieuDKKham();
            $result = $model->insertPhieuDKKham($selectedDate, $selectedTime, $department, $doctor, $txnRef, $amount, $maBN);
            if ($result) {
                header('Location: http://localhost/QLBV/?status=success&message=Thanh%20toán%20thành%20công!');
                exit;
            } else {
                // Thất bại: Hiển thị thông báo lỗi
                header('Location: http://localhost/QLBV/?status=error&message=Lỗi%20khi%20chèn%20dữ%20liệu!');
                exit;
            }
        }
    } else {
        // Thất bại: Chuyển đến trang chính với thông báo lỗi
        header('Location: http://localhost/QLBV/?status=error&message=Mã%20lỗi:%20' . $vnp_ResponseCode);
        exit;
    }
} else {
    // Lỗi bảo mật
    header('Location: http://localhost/QLBV/?status=error&message=Lỗi%20bảo%20mật!');
    exit;
}
?>
