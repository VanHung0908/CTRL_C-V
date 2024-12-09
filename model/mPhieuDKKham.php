<?php
include_once('ketnoi.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

class mPhieuDKKham {
    // Phương thức để chèn dữ liệu vào bảng phiếu đăng ký khám
    public function insertPhieuDKKham($date, $time, $department, $doctor, $txnRef, $amount, $maBN) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        $amount=$amount/100;
        // Bước 1: Lấy MaKhoa từ bảng Khoa
        $sql = "SELECT MaKhoa FROM khoa WHERE TenKhoa = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $department);  
        $stmt->execute();
        $stmt->bind_result($maKhoa);
        $stmt->fetch();
        $stmt->close();

        // Tạo đối tượng DateTime từ định dạng d/m/Y và H:i
        $dateTime = DateTime::createFromFormat('d/m/Y H:i', $date . ' ' . $time);

        // Kiểm tra xem có lỗi khi tạo đối tượng DateTime không
        if ($dateTime === false) {
            echo "Lỗi khi tạo đối tượng DateTime";
        } else {
            // Đưa ngày giờ về định dạng yyyy-mm-dd H:i:s
            $ngayKham = $dateTime->format('Y-m-d H:i:s');
            echo "Ngày khám sau khi định dạng lại: " . $ngayKham;  // Kết quả: 2024-12-02 08:00:00
        }

        $doctor = trim($doctor);
        // Bước 2: Lấy MaNS từ bảng nhansu
        $sql = "SELECT MaNS FROM nhansu WHERE HoTen = ? AND MaKhoa = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $doctor, $maKhoa);  
        $stmt->execute();
        $stmt->bind_result($maNS);
        $stmt->fetch();
        $stmt->close();
    
        if (!$maNS) {
            $p->dongKetNoi($con);
            return "Không tìm thấy bác sĩ trong khoa này! Doctor: " . $doctor . " | MaKhoa: " . $maKhoa;
        }
        // Bước 3: Chèn dữ liệu vào bảng phiếu đăng ký khám
        $sql = "INSERT INTO phieudangkykham (NgayKham, TrangThai, ChiPhiKham, MaDV, MaNS, MaKhoa, MaBN, maThanhToan) 
                VALUES (?, 'Chờ khám', ?, NULL, ?, ?, ?, ?)";
    
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssiiis", $ngayKham, $amount, $maNS, $maKhoa, $maBN, $txnRef);
    
        // Kiểm tra giá trị sẽ chèn vào
        $result = "SQL: " . $sql . "<br>";
        $result .= "NgayKham: " . $ngayKham . "<br>";
        $result .= "ChiPhiKham: " . $amount . "<br>";
        $result .= "MaNS: " . $maNS . "<br>";
        $result .= "MaKhoa: " . $maKhoa . "<br>";
        $result .= "MaBN: " . $maBN . "<br>";
        $result .= "MaThanhToan: " . $txnRef . "<br>";
    
        // Thực thi truy vấn và kiểm tra kết quả
        if ($stmt->execute()) {
            $stmt->close();
            $p->dongKetNoi($con);
            return "Dữ liệu đã được chèn thành công!";
        } else {
            $stmt->close();
            $p->dongKetNoi($con);
            return "Lỗi khi chèn dữ liệu: " . $stmt->error;
        }
    }
    public function getPDKK($MaBN) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        $sql = "SELECT pd.MaDKK,pd.NgayKham, pd.TrangThai, k.TenKhoa, pd.ChiPhiKham, ns.HoTen
                FROM phieudangkykham pd
                JOIN khoa k ON k.MaKhoa = pd.MaKhoa
                JOIN nhansu ns ON pd.MaNS = ns.MaNS
                WHERE pd.MaBN = '$MaBN' and pd.TrangThai  in ('Chờ khám','Đã khám')";
    
        $result = mysqli_query($con, $sql);
        $resultPDKK = []; // Khởi tạo mảng rỗng để lưu kết quả
    
        // Kiểm tra và thêm dữ liệu vào mảng
        while ($row = mysqli_fetch_assoc($result)) {
            $resultPDKK[] = $row;
        }
    
        // Đóng kết nối
        $p->dongKetNoi($con);
    
        return $resultPDKK;
    }
    
    public function getKQK($MaBN) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        $sql = " select pkq.*,ns.HoTen from phieuketquakham pkq join nhansu ns on ns.MaNS=pkq.MaNS where MaBN='$MaBN'";
        $result = mysqli_query($con, $sql);
        $resultKQK = []; // Khởi tạo mảng rỗng để lưu kết quả
    
        // Kiểm tra và thêm dữ liệu vào mảng
        while ($row = mysqli_fetch_assoc($result)) {
            $resultKQK[] = $row;
        }
    
        // Đóng kết nối
        $p->dongKetNoi($con);
    
        return $resultKQK;
    }
    public function getPhacDo($MaBN) {
        $p = new clsKetNoi();
        $con = $p->moKetNoi();
        $sql = " select * from phacdo where MaBN='$MaBN'";
        $result = mysqli_query($con, $sql);
        $resultKQK = []; // Khởi tạo mảng rỗng để lưu kết quả
    
        // Kiểm tra và thêm dữ liệu vào mảng
        while ($row = mysqli_fetch_assoc($result)) {
            $resultKQK[] = $row;
        }
    
        // Đóng kết nối
        $p->dongKetNoi($con);
    
        return $resultKQK;
    }
}

?>
