<style>
    .color{
        color:#D2691E;
    }
</style>
<?php
session_start();
include_once('../../../model/mEmployee.php');
$con = new mEmployee();

if (isset($_POST['caID'])) {
    $caID = $_POST['caID'];
    // Lấy thông tin chi tiết từ cơ sở dữ liệu
    $result = $con->lichlamviecbyCa($caID);

    // Mảng ánh xạ ngày trong tuần
    $daysOfWeek = [
        6 => 'Chủ Nhật',
        0 => 'Thứ 2',
        1 => 'Thứ 3',
        2 => 'Thứ 4',
        3 => 'Thứ 5',
        4 => 'Thứ 6',
        5 => 'Thứ 7'
    ];

    // Mảng ánh xạ khung giờ theo ca
    $caGio = [
        1 => '7h - 11h30',
        2 => '13h30 - 17h',
        3 => '7h - 11h và 13h30 - 17h'
    ];

    // Kiểm tra nếu không có dữ liệu
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="details-table">';
        echo '<h5 align="center"><b class="color">CHI TIẾT CA LÀM VIỆC</b></h5>';
        echo '<table class="schedule-table">';
        echo '<thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày trong tuần</th>
                    <th>Khung giờ</th>
                </tr>
            </thead>';
        echo '<tbody>';
        echo '<tr>';
        echo '<td colspan="3">';
        echo 'Ca này chưa lên lịch !';
        echo '</td>';
        echo '</tr>';
        echo '</tbody></table>';
    }else{

    // Bắt đầu bảng
    echo '<div class="details-table">';
    echo '<h5 align="center"><b class="color">CHI TIẾT CA LÀM VIỆC</b></h5>';
    echo '<table class="schedule-table">';
    echo '<thead>
            <tr>
                <th>STT</th>
                <th>Ngày trong tuần</th>
                <th>Khung giờ</th>
            </tr>
          </thead>';
    echo '<tbody>';
    
    // Hiển thị dữ liệu
    $stt = 1;
    foreach ($result as $i) {
        $ngayTrongTuan = $i['NgayTrongTuan'];
        $tenNgay = isset($daysOfWeek[$ngayTrongTuan]) ? $daysOfWeek[$ngayTrongTuan] : 'Ngày không hợp lệ';

        $caTrongNgay = $i['CaTrongNgay'];
        $khungGio = isset($caGio[$caTrongNgay]) ? $caGio[$caTrongNgay] : 'Ca không hợp lệ';

        echo '<tr>';
        echo '<td>' . $stt++ . '</td>';
        echo '<td>' . htmlspecialchars($tenNgay) . '</td>';
        echo '<td>' . htmlspecialchars($khungGio) . '</td>';
        echo '</tr>';
    }
    
    // Kết thúc bảng
    echo '</tbody></table>';
    $ktra = $con -> ktraDaDKL($_SESSION['maNS']);
    if(mysqli_num_rows($ktra)){
        echo '<div align="center"><button class="register-btn" disabled  onclick="registerShift(' . $_POST['caID'] . ')">Đăng ký</button></div>';
        
    }else{
        echo '<div align="center"><button class="register-btn" onclick="registerShift(' . $_POST['caID'] . ')">Đăng ký</button></div>';
    }
    
    echo '</div>';
}
}
?>


