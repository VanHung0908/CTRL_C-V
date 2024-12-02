<?php
include(__DIR__ . '../../model/ketnoi.php');
include_once(BACKEND_URL . 'model/mDonThuoc.php');

$data = json_decode(file_get_contents('php://input'), true);

// Lấy thông tin từ dữ liệu
$maBN = $data['MaBN'];
$ngayKeDon = $data['NgayKeDon'];
$chiTietDonThuoc = $data['ChiTietDonThuoc'];
$chuanDoan = urldecode($data['ChuanDoan']);
$tinhTrang = urldecode($data['TinhTrang']);
$ngayTaiKham = $data['NgayTaiKham'];
$MaDKK = $data['MaDKK'];
$maNS = $data['MaNS'];
$loaiBHYT = $data['LoaiBHYT'];

$mDonThuoc = new mDonThuoc();

// Tạo mảng kết quả ban đầu
$response = array(
    "ChuẩnDoan" => $chuanDoan,
    "TinhTrang" => $tinhTrang,
    "NgayTaiKham" => $ngayTaiKham,
    "MaNS" => $maNS,
    "LoaiBHYT" => $loaiBHYT,
    "MaDKK" => $MaDKK,
    "success" => false,
    "message" => ""
);

// Khởi tạo biến tổng tiền
$tongTien = 0;

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
        foreach ($chiTietDonThuoc as $thuoc) {
            $mDonThuoc->insertChiTietDonThuoc($maDonThuoc, $thuoc['MaThuoc'], $thuoc['SoLuong'], $thuoc['LieuDung'], $thuoc['CachDung']);
        }

        // Tính giá trị KhauTruBHYT
        switch ($loaiBHYT) {
            case 1:
            case 2:
            case 5:
                $khauTruBHYT = 100;
                break;
            case 3:
                $khauTruBHYT = 95;
                break;
            case 4:
                $khauTruBHYT = 80;
                break;
            default:
                $khauTruBHYT = 0;
                break;
        }

        // Tính tổng tiền dựa trên KhauTruBHYT
        if ($khauTruBHYT == 100) {
            $tongTien = 0;
        } elseif ($khauTruBHYT == 95) {
            $tongTien *= 0.05; // 5% của tổng tiền
        } elseif ($khauTruBHYT == 80) {
            $tongTien *= 0.20; // 20% của tổng tiền
        }

        $phuongThucThanhToan = 'Chưa thanh toán';

        // Thêm hóa đơn vào bảng hoadon
        $insertHoadon = $mDonThuoc->insertHoaDon(
            $khauTruBHYT,
            $tongTien,
            $ngayKeDon, // NgayLapHD
            $phuongThucThanhToan,
            $maDonThuoc, // MaDonThuoc
            $maBN, // MaBN
            $maNS, // MaNS
            $MaDKK // MaDDK
        );

        if ($insertHoadon) {
            // Thêm dữ liệu vào bảng phieuketquakham
            $insertPhieuKQKham = $mDonThuoc->insertPhieuKQKham(
                $chuanDoan,   // ChanDoan
                $ngayTaiKham, // NgayTaiKham
                $ngayKeDon,   // NgayKham
                $maNS,        // MaNS
                $maDonThuoc,  // MaDonThuoc
                $maBN         // MaBN
            );

            if ($insertPhieuKQKham) {
                // Cập nhật trạng thái phiếu đăng ký khám
                $updateTrangThai = $mDonThuoc->updateTrangThaiPhieuDKKham($MaDKK, "Đã khám");
                $updateTrangThai = $mDonThuoc->updateTrangThaiBenhNhan($maBN, "Đã khám");
            
                if ($updateTrangThai) {
                    $response['success'] = true;
                    $response['message'] = 'Đơn thuốc, hóa đơn và phiếu kết quả khám đã được lưu. Trạng thái phiếu đăng ký khám đã được cập nhật.';
                } else {
                    $response['message'] = 'Không thể cập nhật trạng thái phiếu đăng ký khám.';
                }
            } else {
                $response['message'] = 'Không thể lưu phiếu kết quả khám.';
            }
        } else {
            $response['message'] = 'Không thể lưu hóa đơn.';
        }
    } else {
        $response['message'] = 'Không thể lưu đơn thuốc.';
    }
} else {
    $response['message'] = 'Tổng tiền không hợp lệ.';
}

// Trả về kết quả cuối cùng
echo json_encode($response);
exit;
?>
