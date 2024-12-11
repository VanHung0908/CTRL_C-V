<?php
$dsCabyPhong = $con->AllCTCabyCa($_GET['chitietCa']);
$Ca = $con->CabyID($_GET['chitietCa']);
foreach ($Ca as $i) {
    $id = $i['MaCTPhongKham'];
}

// Mảng ánh xạ NgayTrongTuan
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
    <h5 align="center"><b class="color">DANH SÁCH CHI TIẾT CA LÀM VIỆC</b></h5>
    <div align="center" style="margin:10px;">
        <b><a style="color : #FFCC00 ; border:solid 1px; padding:3px;" href="?page=QLP&themCTCa=<?=$id?>">+ Thêm
                Chi Tiết Ca</a></b>
    </div>
    <table class="schedule-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ngày trong tuần</th>
                <th>Ca trong ngày</th>
                <th>MaNS</th>
                <th>Sửa CTCa</th>
                <th>Xóa CTCa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($dsCabyPhong) == 0) {
                echo '<tr>';
                echo '<td colspan="6">';
                echo 'Ca này chưa có lịch !';
                echo '</td>';
                echo '</tr>';
            } else {
                $dem = 1;
                foreach ($dsCabyPhong as $i) {
                    echo '<tr>';
                    echo '<td>' . $dem++ . '</td>';
                    
                    // Hiển thị NgàyTrongTuan bằng chữ
                    echo '<td>' . $daysOfWeek[$i['NgayTrongTuan']] . '</td>';
                    
                    // Hiển thị CaTrongNgay bằng chữ
                    echo '<td>' . $shifts[$i['CaTrongNgay']] . '</td>';
                    
                    echo '<td>' . $i['MaNS'] . '</td>';
                    echo '<td><a href="?page=QLP&suaCT=' . $i['MaLLV'] . '">Sửa</a></td>';
                    echo '<td><a href="?page=QLP&xoaCT=' . $i['MaLLV'] . '" onclick="return confirm(\'Bạn có chắc muốn xóa Chi tiết ca này không ? Nó có thể làm thay đổi lịch làm việc của những người đã đăng ký !\')">Xóa</a></td>';
                    
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>
