<?php
include(__DIR__ . '../../model/ketnoi.php');
include_once(BACKEND_URL . 'model/mDonThuoc.php');

$data = json_decode(file_get_contents('php://input'), true);

$maBN = $data['MaBN'];
$ngayKeDon = $data['NgayKeDon'];
$chiTietDonThuoc = $data['ChiTietDonThuoc'];

$mDonThuoc = new mDonThuoc();

// Tính tổng tiền
$tongTien = 0;

foreach ($chiTietDonThuoc as $thuoc) {
    // Lấy giá thuốc từ bảng thuoc
    $giaThuoc = $mDonThuoc->getGiaThuoc($thuoc['MaThuoc']);

    if ($giaThuoc === 0 || $giaThuoc === false) {
        // Nếu không có giá thuốc hợp lệ, trả về thông báo lỗi
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy giá của thuốc mã ' . $thuoc['MaThuoc']]);
        exit; // Dừng quá trình nếu có lỗi
    }

    // Tính tiền cho thuốc hiện tại và cộng vào tổng tiền
    $tongTien += $giaThuoc * $thuoc['SoLuong'];
}

if ($tongTien > 0) {
    // Thêm đơn thuốc vào bảng donthuoc
    $maDonThuoc = $mDonThuoc->insertDonThuoc($maBN, $ngayKeDon, $tongTien);

    if ($maDonThuoc) {
        foreach ($chiTietDonThuoc as $thuoc) {
            // Thêm chi tiết đơn thuốc vào bảng chi_tiet_don_thuoc
            $mDonThuoc->insertChiTietDonThuoc($maDonThuoc, $thuoc['MaThuoc'], $thuoc['SoLuong'], $thuoc['LieuDung'], $thuoc['CachDung']);
        }

        echo json_encode(['success' => true, 'message' => 'Đơn thuốc đã được lưu.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể lưu đơn thuốc.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Tổng tiền không hợp lệ.']);
}
?>
    