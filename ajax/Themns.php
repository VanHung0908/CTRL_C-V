<?php
include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/ketnoi.php');  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $p = new clsketnoi();
    $con = $p->MoKetNoi();  // Open the database connection
    $HoTen = isset($_POST['HoTen']) ? $_POST['HoTen'] : null;
    $NgaySinh = isset($_POST['NgaySinh']) ? $_POST['NgaySinh'] : null;
    $GioiTinh = isset($_POST['GioiTinh']) ? $_POST['GioiTinh'] : null;
    $Email = isset($_POST['Email']) ? $_POST['Email'] : null;
    $DiaChi = isset($_POST['DiaChi']) ? $_POST['DiaChi'] : null;
    $CCCD = isset($_POST['CCCD']) ? $_POST['CCCD'] : null;
    $SoDienThoai = isset($_POST['SoDienThoai']) ? $_POST['SoDienThoai'] : null;
    $MaCV = isset($_POST['ChucVu']) ? $_POST['ChucVu'] : null;
    $MaKhoa = isset($_POST['Khoa']) ? $_POST['Khoa'] : null;

    // Thực hiện câu lệnh SQL để lưu vào cơ sở dữ liệu
    $NgayBatDau = date('Y-m-d');
    $insert_query = "INSERT INTO nhansu(HoTen, NgaySinh, Email, GioiTinh,SoDienThoai, CCCD, NgayBatDau, DiaChi, MaCV, MaKhoa) 
                     VALUES ('$HoTen', '$NgaySinh', '$Email', '$GioiTinh',$SoDienThoai, '$CCCD', '$NgayBatDau', '$DiaChi', '$MaCV', '$MaKhoa');";
    
    // Thực hiện truy vấn để thêm nhân sự mới
    $result = mysqli_query($con, $insert_query);
    
    if ($result) {
        // Cập nhật TenTK sau khi insert
        $update_query = "UPDATE nhansu 
                         SET TenTK = CONCAT(
                             LPAD(MaKhoa, 2, '0'), 
                             LPAD(LAST_INSERT_ID(), 3, '0')
                         )
                         WHERE MaNS = LAST_INSERT_ID()";
    
        mysqli_query($con, $update_query);
    
        // Lấy TenTK và NgaySinh để tạo mật khẩu
        $TenTK = mysqli_fetch_assoc(mysqli_query($con, "SELECT TenTK FROM nhansu WHERE MaNS = LAST_INSERT_ID()"))['TenTK'];
        $NgaySinh = date('d-m-Y', strtotime($NgaySinh)); // Chuyển đổi Ngày sinh thành định dạng d-m-Y
    
        // Tạo mật khẩu từ ngày tháng năm sinh (ngày sinh định dạng ddmmyyyy@A)
        $MatKhau = str_replace("-", "", $NgaySinh) . "@A";
        $matKhau=md5($MatKhau);
        // Insert vào bảng taikhoan
        $insert_taikhoan_query = "INSERT INTO taikhoan(TenTK, MatKhau) 
                                  VALUES ('$TenTK', '$matKhau')";
        mysqli_query($con, $insert_taikhoan_query);
        
        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Error handling for the INSERT query
        echo "Error in INSERT query: " . mysqli_error($con);
    }
}
?>
