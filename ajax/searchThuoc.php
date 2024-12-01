<?php
// Kiểm tra và lấy từ khóa tìm kiếm từ query string
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Kết nối cơ sở dữ liệu
include(__DIR__ . '../../model/ketnoi.php');
$p = new clsKetNoi();
$con = $p->moKetNoi();

// Truy vấn tìm kiếm thuốc nếu có từ khóa tìm kiếm
if ($searchTerm) {
    $sql = "SELECT MaThuoc, TenThuoc, Gia FROM thuoc WHERE TenThuoc LIKE ?";
    $stmt = mysqli_prepare($con, $sql);
    $searchTerm = "%$searchTerm%"; // Chuẩn bị từ khóa cho câu lệnh LIKE
    mysqli_stmt_bind_param($stmt, 's', $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    // Nếu không có từ khóa tìm kiếm, lấy tất cả danh sách thuốc
    $sql = "SELECT MaThuoc, TenThuoc, Gia FROM thuoc";
    $result = mysqli_query($con, $sql);
}

$thuocs = [];
while ($row = mysqli_fetch_assoc($result)) {
    
    $thuocs[] = $row;
}

// Đóng kết nối
$p->dongKetNoi($con);

// Trả về kết quả dưới dạng JSON
echo json_encode($thuocs);
?>
