<?php
include(__DIR__ . '../../model/ketnoi.php');
include_once(BACKEND_URL . 'model/mDonThuoc.php');

$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra nếu dữ liệu cần thiết có tồn tại
$maBN = isset($data['MaBN']) ? $data['MaBN'] : null;
$ngayKeDon = isset($data['NgayKeDon']) ? $data['NgayKeDon'] : null;
$chiTietDonThuoc = isset($data['ChiTietDonThuoc']) ? $data['ChiTietDonThuoc'] : [];
$ChuanDoan = isset($data['ChuanDoan']) ? urldecode($data['ChuanDoan']) : '';
$KeHoach = isset($data['KeHoach']) ? urldecode($data['KeHoach']) : '';
$CheDoDD = isset($data['CheDoDD']) ? urldecode($data['CheDoDD']) : '';
$MaNS = isset($data['MaNS']) ? $data['MaNS'] : null;

$mDonThuoc = new mDonThuoc();

// Khởi tạo biến tổng tiền
$tongTien = 0;

// Tạo mảng kết quả ban đầu

foreach ($chiTietDonThuoc as $thuoc) {
    // Lấy giá thuốc từ bảng thuoc
    $giaThuoc = $mDonThuoc->getGiaThuoc($thuoc['MaThuoc']);

    if ($giaThuoc === 0 || $giaThuoc === false) {
        $response['message'] = 'Không tìm thấy giá của thuốc mã ' . $thuoc['MaThuoc'];
        echo json_encode($response);
        exit;
    }

    $tongTien += $giaThuoc * $thuoc['SoLuong'];
}

if ($tongTien > 0) {
    $maDonThuoc = $mDonThuoc->insertDonThuoc($maBN, $ngayKeDon, $tongTien);

    if ($maDonThuoc) {
        // Xử lý chi tiết đơn thuốc
        foreach ($chiTietDonThuoc as $thuoc) {
            $result = $mDonThuoc->insertChiTietDonThuoc($maDonThuoc, $thuoc['MaThuoc'], $thuoc['SoLuong'], $thuoc['LieuDung'], $thuoc['CachDung']);
            if (!$result) {
                $response['message'] = 'Lỗi khi lưu chi tiết thuốc mã ' . $thuoc['MaThuoc'];
                echo json_encode($response);
                exit;
            }
        }
        
        // Lưu phác đồ
        $insertPhacDo = $mDonThuoc->insertPhacDo(
            $ngayKeDon, 
            $ChuanDoan,  
            $KeHoach,   
            $CheDoDD,        
            $maDonThuoc,  
            $maBN,
            $MaNS
        );
        
        // Kiểm tra kết quả lưu phác đồ
        if ($insertPhacDo) {
            $response['success'] = true;
            $response['message'] = 'Phác đồ đã được lưu thành công.';
            echo json_encode($response);
            exit;
        }
        
        
    } else {
        $response['message'] = 'Không thể lưu đơn thuốc.';
        echo json_encode($response);
    }
    
    
} else {
    $response['message'] = 'Tổng tiền không hợp lệ.';
}

// Trả về kết quả cuối cùng
echo json_encode($response);
exit;
?>
