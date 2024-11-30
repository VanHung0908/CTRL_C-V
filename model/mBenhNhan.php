<?php
    include_once('ketnoi.php');
    class mBenhNhan{
        public function getHoTenByMaBN($maBN) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();
    
            // Truy vấn lấy thông tin HoTen từ bảng benhnhan
            $sql = "SELECT HoTen FROM benhnhan WHERE MaBN = '$maBN'";
            $result = mysqli_query($con, $sql);
            
            // Nếu tìm thấy thông tin, trả về HoTen
            if ($row = mysqli_fetch_assoc($result)) {
                $hoTen = $row['HoTen'];
            } else {
                $hoTen = 'Không tìm thấy thông tin';
            }
    
            // Đóng kết nối
            $p->dongKetNoi($con);
            
            return $hoTen;
        }
        public function dangKyKhamBenh($hoTen, $ngaySinh, $gioiTinh, $sdt, $diaChi, $cccd, $khoaKham, $bhyt, $loaiBHYT) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi();

            // Trạng thái mặc định là 'Khám bệnh'
            $trangThai = 'Khám bệnh';

            $sql = "INSERT INTO benhnhan (HoTen, NgaySinh, GioiTinh, SDT, DiaChi, CCCD, KhoaKham, BHYT, LoaiBHYT, TrangThai) 
                    VALUES ('$hoTen', '$ngaySinh', '$gioiTinh', '$sdt', '$diaChi', '$cccd', '$khoaKham', '$bhyt', '$loaiBHYT', '$trangThai')";
            
            $result = mysqli_query($con, $sql);
            $p->dongKetNoi($con);

            return $result;
        }
        public function getPatientByPhone($SDT) {
            $p = new clsKetNoi();
            $con = $p->moKetNoi(); // Kết nối cơ sở dữ liệu
            $query = "SELECT * FROM benhnhan WHERE SDT = ?"; // Truy vấn tìm bệnh nhân theo số điện thoại
            $stmt = $con->prepare($query); // Sử dụng $con thay vì $this->conn
            $stmt->bind_param("s", $SDT); // Gắn tham số số điện thoại vào truy vấn
            $stmt->execute(); // Thực thi truy vấn
            $result = $stmt->get_result(); // Lấy kết quả
            return $result->fetch_assoc(); // Trả về thông tin bệnh nhân nếu tìm thấy
        }
        public function insertDKKhamBenh($hoTen, $ngaySinh, $gioiTinh, $sdt, $maKhoa, $diaChi, $cccd, $bhyT, $loaiBHYT, $chiPhi, $phuongThucThanhToan) {
            // Kết nối đến cơ sở dữ liệu
            $p = new clsKetNoi();
            $conn = $p->moKetNoi(); // Kết nối cơ sở dữ liệu
        
            // Kiểm tra xem bệnh nhân đã có trong cơ sở dữ liệu hay chưa
            $checkPatientQuery = "SELECT MaBN FROM benhnhan WHERE SDT = ?";
            if ($stmt = $conn->prepare($checkPatientQuery)) {
                $stmt->bind_param("s", $sdt);
                $stmt->execute();
                $stmt->store_result();
                
                if ($stmt->num_rows > 0) {
                    // Nếu bệnh nhân đã có, lấy MaBN
                    $stmt->bind_result($maBN);
                    $stmt->fetch();
                } else {
                    // Nếu bệnh nhân chưa có, thêm vào bảng benhnhan
                    $insertPatientQuery = "INSERT INTO benhnhan (HoTen, NgaySinh, GioiTinh, SDT, DiaChi, CCCD, BHYT, LoaiBHYT, TrangThai) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $trangThai = 'Khám bệnh';
                    if ($insertStmt = $conn->prepare($insertPatientQuery)) {
                        $insertStmt->bind_param("sssssssss", $hoTen, $ngaySinh, $gioiTinh, $sdt, $diaChi, $cccd, $bhyT, $loaiBHYT, $trangThai);
                        if ($insertStmt->execute()) {
                            // Lấy MaBN vừa thêm
                            $maBN = $insertStmt->insert_id;
                        } else {
                            // Nếu không thể thêm bệnh nhân mới, trả về false
                            return false;
                        }
                    }
                }
            }
        
            // Tính toán "Thu" (Ngày trong tuần)
            $currentDate = date('Y-m-d');
            $timestamp = strtotime($currentDate);
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
        
            // Xác định "CaLam" (Ca làm)
            $currentTime = date('H:i');
            $caLam = null;
            if ($currentTime >= "07:00" && $currentTime <= "11:00") {
                $caLam = 1;
            } elseif ($currentTime >= "13:00" && $currentTime <= "18:00") {
                $caLam = 2;
            }
        
            // Truy vấn MaNS từ bảng lichlamviec với điều kiện Thu và CaLam
            $selectMaNSQuery = "
            SELECT MaNS 
            FROM lichlamviec 
            WHERE Thu = ? AND CaLam = ? AND TrangThai = 'Đã duyệt'
            ";
            $stmt = $conn->prepare($selectMaNSQuery);
            if (!$stmt) {
                // Nếu không thể chuẩn bị câu truy vấn, báo lỗi
                return "Lỗi trong việc chuẩn bị câu truy vấn: " . $conn->error;
            }
        
            $stmt->bind_param("ii", $thu, $caLam); // Bind với thu và caLam
            if (!$stmt->execute()) {
                // Nếu không thể thực thi câu truy vấn, báo lỗi
                return "Lỗi khi thực thi câu truy vấn: " . $stmt->error;
            }
        
            $result = $stmt->get_result();
        
            $maNSList = [];
            while ($row = $result->fetch_assoc()) {
                $maNSList[] = $row['MaNS'];
            }
        
            $stmt->close();
        
            if (empty($maNSList)) {
                return "Không có nhân sự khả dụng.";
            }
        
            // Lọc nhân sự có MaCV = 4
            $validMaNSList = [];
            if (!empty($maNSList)) {
                $maNSListStr = implode(',', $maNSList);
                $selectValidMaNSQuery = "
                    SELECT MaNS 
                    FROM nhansu 
                    WHERE MaNS IN ($maNSListStr) AND MaCV = 4
                ";
                $stmt = $conn->prepare($selectValidMaNSQuery);
                $stmt->execute();
                $result = $stmt->get_result();
        
                // Lưu danh sách MaNS hợp lệ
                while ($row = $result->fetch_assoc()) {
                    $validMaNSList[] = $row['MaNS'];
                }
                $stmt->close();
            }
        
            if (empty($validMaNSList)) {
                return "Không có nhân sự hợp lệ (MaCV = 4) trong ca làm này.";
            }
        
            // Chọn ngẫu nhiên một MaNS từ danh sách hợp lệ
            $selectedMaNS = null;
            if (!empty($validMaNSList)) {
                $randomIndex = array_rand($validMaNSList);
                $selectedMaNS = $validMaNSList[$randomIndex];
            } else {
                return "Không có nhân sự hợp lệ để đăng ký.";
            }
        
            // Thêm thông tin vào bảng phieudangkykham
            $insertDKKhamQuery = "INSERT INTO phieudangkykham (MaDKK, NgayKham, TrangThai, ChiPhiKham, MaNS, MaKhoa, MaBN, maThanhToan)
                                  VALUES (NULL, CURRENT_TIMESTAMP, 'Chờ khám', ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertDKKhamQuery);
            $stmt->bind_param("diisi", $chiPhi, $maKhoa, $maBN, $selectedMaNS, $phuongThucThanhToan);
            if ($stmt->execute()) {
                // Trả về true nếu đã thêm thành công
                return true;
            } else {
                // Trả về false nếu có lỗi khi thêm vào bảng phieudangkykham
                return false;
            }
        
            return false;
        }
        
    }
?>
