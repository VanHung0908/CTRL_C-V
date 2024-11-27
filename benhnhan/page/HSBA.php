<?php include_once '../layout/header.php' ?>
<style>
 
 main {
    max-width: 800px; 
    margin: 20px auto; 
    padding: 20px;
    background-color: #f9f9f9; 
    border-radius: 8px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
}   
.actions {
    margin-top: 20px;
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 15px;
    margin-right: 10px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>
<main>
        <section class="patient-info">
            <h1>Thông Tin Bệnh Nhân</h1>
            <p><strong>Họ và tên:</strong> Nguyễn Văn A</p>
            <p><strong>Ngày sinh:</strong> 01/01/1990</p>
            <p><strong>Giới tính:</strong> Nam</p>
            <p><strong>Số điện thoại:</strong> 0901234567</p>
            <p><strong>Địa chỉ:</strong> 123 Đường ABC, Quận 1, TP.HCM</p>
        </section>

        <section class="medical-history">
            <h2>Lịch Sử Bệnh Án</h2>
            <ul>
                <li>Bệnh tiểu đường - Ngày chẩn đoán: 01/01/2020</li>
                <li>Bệnh cao huyết áp - Ngày chẩn đoán: 01/06/2021</li>
            </ul>
        </section>

        <section class="medications">
            <h2>Thuốc Đang Sử Dụng</h2>
            <ul>
                <li>Metformin - Liều lượng: 500mg, Tình trạng: Đang sử dụng</li>
                <li>Lisinopril - Liều lượng: 10mg, Tình trạng: Đang sử dụng</li>
            </ul>
        </section>

        <section class="appointments">
            <h2>Lịch Sử Khám Chữa Bệnh</h2>
            <ul>
                <li>Ngày khám: 15/08/2023, Bác sĩ: Dr. Smith, Chẩn đoán: Tăng huyết áp</li>
            </ul>
        </section>

        <div class="actions">
            <button onclick="updateInfo()">Cập Nhật Thông Tin</button>
            <button onclick="printInfo()">In Hồ Sơ</button>
        </div>
    </main>

    <script>
        function updateInfo() {
            alert("Chức năng cập nhật thông tin chưa được triển khai.");
        }

        function printInfo() {
            window.print();
        }

        function bookAppointment() {
            alert("Chức năng đặt lịch hẹn chưa được triển khai.");
        }
    </script>
<?php
include ('../layout/footer.php');
?>