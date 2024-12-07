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
                } elseif ($currentTime >= "13:00" && $currentTime <= "23:00") {
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
                    return "Không có nhân sự hợp lệ trong ca làm này.";
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
                $stmt->bind_param("diiis", $chiPhi,   $selectedMaNS,$maKhoa, $maBN,$phuongThucThanhToan);
                if ($stmt->execute()) {
                    return true;
                } else {
                    return "Lỗi khi thêm vào phieudangkykham: " . $stmt->error;
                }
            
                return false;
            }
        
            public function dsBenhNhan($MaCV, $MaNS) {
                // Tạo đối tượng lớp clsKetNoi
                $p = new clsKetNoi();
            
                // Mở kết nối cơ sở dữ liệu
                $conn = $p->moKetNoi();
            
                // Khởi tạo câu truy vấn mặc định
                $sql = "SELECT 
                            b.MaBN,
                            b.HoTen , 
                            b.NgaySinh, 
                            b.GioiTinh, 
                            b.DiaChi, 
                            b.SDT, 
                            b.CCCD, 
                            b.BHYT, 
                            b.LoaiBHYT, 
                            p.TrangThai, 
                            p.NgayKham,
                            p.MaDKK,
                            ns.HoTen AS TenNhanSu
                        FROM 
                            benhnhan b
                        INNER JOIN 
                            phieudangkykham p ON b.MaBN = p.MaBN
                        INNER JOIN 
                            nhansu ns ON p.MaNS = ns.MaNS";
    
                if ($MaCV == 1) {
                    // Nếu MaCV = 1 thì hiển thị tất cả bệnh nhân
                    $sql .= " ORDER BY p.MaBN DESC";
                } elseif ($MaCV == 6) {
                    $sql .= " WHERE DATE(p.NgayKham) = CURDATE() AND p.TrangThai IN ('Đã khám', 'Chờ khám') ORDER BY p.MaBN DESC";

                }elseif ($MaCV == 7) {
                    $sql .= " WHERE DATE(p.NgayKham) = CURDATE() AND p.TrangThai = 'Nhập viện' ORDER BY p.MaBN DESC";
                } 
                elseif ($MaCV == 4) {
                    // Nếu MaCV = 4 thì hiển thị bệnh nhân theo MaNS từ session và trạng thái "Chờ khám"
                    $sql .= " WHERE DATE(p.NgayKham) = CURDATE() AND p.MaNS = '$MaNS' AND p.TrangThai = 'Chờ khám' ORDER BY p.MaBN DESC";
                }
                elseif ($MaCV == 5) {
                    $sql .= " WHERE  p.MaNS = '$MaNS' AND p.TrangThai  in('Nhập viện', 'Đang điều trị') ORDER BY p.MaBN DESC";
                }
                if (!empty($searchTerm)) {
                    $sql .= " AND b.HoTen LIKE '%$searchTerm%'";
                }
                // Thực thi câu truy vấn
                $result = $conn->query($sql);
            
                // Mảng để lưu danh sách bệnh nhân
                $dsBenhNhan = [];
            
                // Kiểm tra nếu có dữ liệu
                if ($result->num_rows > 0) {
                    // Duyệt qua các hàng dữ liệu và thêm vào mảng
                    while ($row = $result->fetch_assoc()) {
                        $dsBenhNhan[] = $row; // Thêm mỗi bệnh nhân vào mảng
                    }
                }
                // Trả về danh sách bệnh nhân
                return $dsBenhNhan;
            }
            public function PhieuKhamBN($MaBN, $MaNS) {
                // Tạo đối tượng lớp clsKetNoi
                $p = new clsKetNoi();
                
                // Mở kết nối cơ sở dữ liệu
                $conn = $p->moKetNoi();
                
                // Câu truy vấn kết hợp thông tin từ các bảng benhnhan, phieudangkykham, nhansu và khoa
                $sql = "SELECT 
                            b.MaBN,
                            b.HoTen AS HoTenBN, 
                            b.NgaySinh, 
                            b.GioiTinh, 
                            b.DiaChi, 
                            b.SDT, 
                            b.BHYT, 
                            b.LoaiBHYT,
                            n.HoTen AS BacSi,
                            k.TenKhoa
                        FROM 
                            benhnhan b
                        INNER JOIN 
                            phieudangkykham p ON b.MaBN = p.MaBN
                        LEFT JOIN 
                            nhansu n ON p.MaNS = n.MaNS
                        LEFT JOIN 
                            khoa k ON n.MaKhoa = k.MaKhoa
                        WHERE
                            b.MaBN = '$MaBN' AND p.MaNS = '$MaNS'";
            
                $result = $conn->query($sql);
            
                $dsBenhNhan = [];
            
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dsBenhNhan[] = $row; // Thêm mỗi bệnh nhân vào mảng
                    }
                }
            
                return $dsBenhNhan;
            }
            
            public function getTTBN($MaBN) {
                $p = new clsKetNoi();
                
                $conn = $p->moKetNoi();
                $sql= "select * from benhnhan WHERE MaBN = '$MaBN'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dsBenhNhan[] = $row; 
                    }
                }
                return $dsBenhNhan;
            }
            public function getTTBNNV($MaBN) {
                $p = new clsKetNoi();
                $conn = $p->moKetNoi();
            
                $stmt = $conn->prepare("SELECT 
                                            bn.*, 
                                            pnv.DiaChi AS DiaChiPNV, 
                                            pnv.SDT AS SDTPNV, 
                                            pnv.GioiTinh AS GioiTinhPNV,
                                            pnv.MaNV, 
                                            pnv.MaNS, 
                                            pnv.TenNguoiLienHe, 
                                            pnv.QuanHe, 
                                            pnv.TamUng, 
                                            pnv.MaGiuong, 
                                            pnv.MaPhong,
                                            pnv.MaKhoa, 
                                            pg.TenPhong, 
                                            gg.TenGiuong
                                        FROM benhnhan bn
                                        JOIN phieunamvien pnv ON bn.MaBN = pnv.MaBN
                                        LEFT JOIN Phong pg ON pnv.MaPhong = pg.MaPhong
                                        LEFT JOIN Giuong gg ON pnv.MaGiuong = gg.MaGiuong
                                        WHERE bn.MaBN = ? AND pnv.TrangThai = 'Nhập viện';
                                        ");
                $stmt->bind_param("s", $MaBN); 
                $stmt->execute();
                $result = $stmt->get_result();
            
                $dsBenhNhan = [];
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dsBenhNhan[] = $row; 
                    }
                }
                $stmt->close();
                $conn->close();
                return $dsBenhNhan;
            }
            
            public function dsBenhNhanNV($MaCV, $MaNS, $searchTerm = '') {
                $p = new clsKetNoi();
                
                $conn = $p->moKetNoi();
                
                $sql = "SELECT 
                            b.MaBN,
                            b.HoTen, 
                            b.NgaySinh, 
                            b.GioiTinh, 
                            b.DiaChi, 
                            b.SDT, 
                            b.CCCD, 
                            b.BHYT, 
                            b.LoaiBHYT, 
                            p.TrangThai, 
                            p.NgayKham,
                            p.MaDKK,
                            ns.HoTen AS TenNhanSu
                        FROM 
                            benhnhan b
                        INNER JOIN 
                            phieudangkykham p ON b.MaBN = p.MaBN
                        INNER JOIN 
                            nhansu ns ON p.MaNS = ns.MaNS";
            
                if ($MaCV == 6) {
                    $sql .= " WHERE DATE(p.NgayKham) = CURDATE() AND p.TrangThai IN ('Nhập viện') ORDER BY p.MaBN DESC";
                } elseif ($MaCV == 7) {
                    $sql .= " WHERE  p.TrangThai = 'Đang điều trị' ORDER BY p.MaBN DESC";
                } elseif ($MaCV == 4) {
                    $sql .= " WHERE DATE(p.NgayKham) = CURDATE() AND p.MaNS = '$MaNS' AND p.TrangThai = 'Chờ khám' ORDER BY p.MaBN DESC";
                }
            
                if (!empty($searchTerm)) {
                    $sql .= " AND b.HoTen LIKE '%$searchTerm%'";
                }
            
                $result = $conn->query($sql);
            
                $dsBenhNhan = [];
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dsBenhNhan[] = $row; // Thêm mỗi bệnh nhân vào mảng
                    }
                }
                
                return $dsBenhNhan;
            }
            public function dsBenhNhanNTRu($MaCV, $MaNS, $searchTerm = '') {
                $p = new clsKetNoi();
                
                $conn = $p->moKetNoi();
                
                $sql = "SELECT 
                            b.MaBN,
                            b.HoTen, 
                            b.NgaySinh, 
                            b.GioiTinh, 
                            b.DiaChi, 
                            b.SDT, 
                            b.CCCD, 
                            b.BHYT, 
                            b.LoaiBHYT, 
                            b.TrangThai, 
                            p.ThoiGianNV,
                            p.MaNV,
                            ns.HoTen AS TenNhanSu,
                            ph.TenPhong,
                            gg.TenGiuong

                        FROM 
                            benhnhan b
                         JOIN 
                            phieunamvien p ON b.MaBN = p.MaBN
                         JOIN 
                            phong ph on ph.MaPhong=p.MaPhong
                         JOIN 
                            giuong gg on gg.MaGiuong=p.MaGiuong
                         JOIN 
                            nhansu ns ON p.MaNS = ns.MaNS";
            
                $sql .= " WHERE  b.TrangThai  ='Nhập viện' ORDER BY p.MaBN DESC";
              
            
                if (!empty($searchTerm)) {
                    $sql .= " AND b.HoTen LIKE '%$searchTerm%'";
                }
            
                $result = $conn->query($sql);
            
                $dsBenhNhan = [];
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dsBenhNhan[] = $row; // Thêm mỗi bệnh nhân vào mảng
                    }
                }
                
                return $dsBenhNhan;
            }
            public function dsBenhNhanXV($MaCV, $MaNS, $searchTerm = '') {
                $p = new clsKetNoi();
                
                $conn = $p->moKetNoi();
                
                $sql = "SELECT 
                            b.MaBN,
                            b.HoTen, 
                            b.NgaySinh, 
                            b.GioiTinh, 
                            b.DiaChi, 
                            b.SDT, 
                            b.CCCD, 
                            b.BHYT, 
                            b.LoaiBHYT, 
                            b.TrangThai, 
                            p.ThoiGianNV,
                            p.MaNV,
                            ns.HoTen AS TenNhanSu,
                            ph.TenPhong,
                            gg.TenGiuong

                        FROM 
                            benhnhan b
                         JOIN 
                            phieunamvien p ON b.MaBN = p.MaBN
                         JOIN 
                            phong ph on ph.MaPhong=p.MaPhong
                         JOIN 
                            giuong gg on gg.MaGiuong=p.MaGiuong
                         JOIN 
                            nhansu ns ON p.MaNS = ns.MaNS";
            
                $sql .= " WHERE b.TrangThai  ='Xuất viện' ORDER BY p.MaBN DESC";
              
            
                if (!empty($searchTerm)) {
                    $sql .= " AND b.HoTen LIKE '%$searchTerm%'";
                }
            
                $result = $conn->query($sql);
            
                $dsBenhNhan = [];
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dsBenhNhan[] = $row; // Thêm mỗi bệnh nhân vào mảng
                    }
                }
                
                return $dsBenhNhan;
            }
            public function updateBenhNhan($MaBN, $HoTen, $GioiTinh, $SDT, $CCCD, $BHYT, $DiaChi) {
                $p = new clsKetNoi();
                $con = $p->moKetNoi(); 
                $sql = "UPDATE benhnhan SET HoTen = '$HoTen', GioiTinh = '$GioiTinh', SDT = '$SDT', CCCD = '$CCCD', BHYT = '$BHYT', DiaChi = '$DiaChi' WHERE MaBN = '$MaBN'";
                $result = mysqli_query($con, $sql);
                $p -> dongKetNoi($con);
                return $result;
            }
            
            public function getBenhNhan( $MaBN) {
                $p = new clsKetNoi();
                
                $conn = $p->moKetNoi();
                
                $sql = "SELECT 
                            b.MaBN,
                            b.HoTen, 
                            b.NgaySinh, 
                            b.GioiTinh, 
                            b.DiaChi, 
                            b.SDT, 
                            b.CCCD, 
                            b.BHYT, 
                            b.LoaiBHYT, 
                            b.TrangThai, 
                            p.ThoiGianNV,
                            p.MaNV,
                            p.LyDo,
                            p.ChuanDoanBD
                        FROM 
                            benhnhan b
                         JOIN 
                            phieunamvien p ON b.MaBN = p.MaBN
                        WHERE  b.MaBN = '$MaBN' AND b.TrangThai  ='Nhập viện' ";
              
                $result = $conn->query($sql);
            
                $BenhNhan = [];
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $BenhNhan[] = $row; 
                    }
                }
                
                return $BenhNhan;
            }
            
        }
    ?>
