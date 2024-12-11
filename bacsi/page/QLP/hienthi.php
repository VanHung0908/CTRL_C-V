<!-- PHP -->
<?php
session_start();
include_once('../../../model/mQLPhongKham.php');
$con = new phong;
$dsCabyPhong = $con->ALLCTCaByPhong($_SESSION['chitiet']);
foreach ($dsCabyPhong as $i) {
    $ten = $i['TenPhong'];
}
$daysOfWeek = [
    0 => "Thứ 2",
    1 => "Thứ 3",
    2 => "Thứ 4",
    3 => "Thứ 5",
    4 => "Thứ 6",
    5 => "Thứ 7",
    6 => "Chủ nhật"
];

// Mảng ánh xạ CaTrongNgay
$shifts = [
    1 => "Ca sáng",
    2 => "Ca chiều"
];
?>
<div class="schedule-list">
    <h5 align="center"><b class="color">DANH SÁCH CHI TIẾT CA LÀM VIỆC ĐÃ TỒN TẠI Ở PHÒNG <? if(isset( $ten)) echo $ten?> </b></h5>
    <table class="schedule-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên ca</th>
                <th>Ngày trong tuần</th>
                <th>Ca trong ngày</th>
                <th>Phòng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($dsCabyPhong) == 0) {
                echo '<tr>';
                echo '<td colspan="7">';
                echo 'Phòng này chưa có ca làm việc nào !';
                echo '</td>';
                echo '</tr>';
            } else {
                $dem = 1;
                foreach ($dsCabyPhong as $i) {
                    echo '<tr>';
                    echo '<td>' . $dem++ . '</td>';
                    echo '<td>' . $i['TenCa'] . '</td>';
                    echo '<td>' . $daysOfWeek[$i['NgayTrongTuan']] . '</td>';
                    echo '<td>' . $shifts[$i['CaTrongNgay']] . '</td>';
                    echo '<td>' . $i['TenPhong'] . '</td>';
                    echo '</tr>';
                }
            }

            ?>
        </tbody>
    </table>
</div>