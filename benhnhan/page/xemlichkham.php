<?php 
include_once '../layout/header.php';
?>
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Arial', sans-serif;
    }
    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .table thead {
        background-color: #0056b3;
        color: white;
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .badge-status {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 12px;
    }
    .info-section {
        margin-bottom: 30px;
    }
    .info-card {
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background-color: #007bff;
        color: white;
        font-weight: bold;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .card-header button {
        border-radius: 50px;
        padding: 5px 15px;
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .card-body {
        padding: 20px;
    }
    .card-body p {
        margin: 10px 0;
        font-size: 1rem;
        color: #343a40;
    }
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529;
    }
    .badge.bg-danger {
        background-color: #dc3545 !important;
    }
    .card-header.bg-primary {
        background-color: #0056b3 !important;
    }
    .card-header.bg-success {
        background-color: #28a745 !important;
    }
    a {
        color: #007bff;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>

<!-- Header -->
<div class="section-2-1-1">
    <div class="inner-wrap wow fadeInRight">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10">
                    <!-- Thông tin cá nhân bệnh nhân -->
                    <div class="info-section">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Thông Tin Cá Nhân</h4>
                                <button class="btn btn-light btn-sm text-primary" onclick="updateInfo()">Cập Nhật</button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Mã Bệnh Nhân:</strong> <span id="MaBN">BN123456</span></p>
                                        <p><strong>Họ Tên:</strong> <span id="HoTen">Nguyễn Văn A</span></p>
                                        <p><strong>Ngày Sinh:</strong> <span id="NgaySinh">1990-05-15</span></p>
                                        <p><strong>Giới Tính:</strong> <span id="GioiTinh">Nam</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Địa Chỉ:</strong> <span id="DiaChi">123 Đường ABC, TP. Hồ Chí Minh</span></p>
                                        <p><strong>Số Điện Thoại:</strong> <span id="SDT">0123 456 789</span></p>
                                        <p><strong>CCCD:</strong> <span id="CCCD">012345678901</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng lịch khám -->
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0">Lịch Đăng Ký Khám Bệnh</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Ngày Giờ</th>
                                        <th>Bác Sĩ</th>
                                        <th>Khoa Khám</th>
                                        <th>Số Tiền Thanh Toán</th>
                                        <th>Trạng Thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2024-12-06 08:30</td>
                                        <td>BS. Nguyễn Văn A</td>
                                        <td>Nội Tổng Quát</td>
                                        <td>500,000 VND</td>
                                        <td><span class="badge bg-success badge-status">Đã Thanh Toán</span></td>
                                    </tr>
                                    <tr>
                                        <td>2024-12-07 10:00</td>
                                        <td>BS. Trần Thị B</td>
                                        <td>Nhi Khoa</td>
                                        <td>300,000 VND</td>
                                        <td><span class="badge bg-warning badge-status">Chờ Thanh Toán</span></td>
                                    </tr>
                                    <tr>
                                        <td>2024-12-08 14:00</td>
                                        <td>BS. Lê Văn C</td>
                                        <td>Da Liễu</td>
                                        <td>400,000 VND</td>
                                        <td><span class="badge bg-danger badge-status">Hủy</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bảng kết quả khám bệnh -->
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h4 class="mb-0">Kết Quả Khám Bệnh</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ngày</th>
                                            <th>Khoa Khám</th>
                                            <th>Bác Sĩ</th>
                                            <th>Kết Quả</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2024-12-06</td>
                                            <td>Nội Tổng Quát</td>
                                            <td>BS. Nguyễn Văn A</td>
                                            <td>Không phát hiện bệnh nghiêm trọng</td>
                                        </tr>
                                        <tr>
                                            <td>2024-12-07</td>
                                            <td>Nhi Khoa</td>
                                            <td>BS. Trần Thị B</td>
                                            <td>Chẩn đoán viêm họng nhẹ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="mt-3">
                        <p><strong>Lưu ý:</strong> Vui lòng mang theo CMND hoặc CCCD khi đến khám. Nếu cần hỗ trợ, liên hệ hotline <a href="tel:+840123456789">0123 456 789</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../layout/footer.php'; ?>