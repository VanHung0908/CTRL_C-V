<!-- PHP -->
<?php
$dsCabyPhong = $con->AllCabyPhong($_GET['chitiet']);
$Phong = $con->PhongByID($_GET['chitiet']);
foreach($Phong as $i){
    $id = $i['MaPhong'];
    $ten = $i['TenPhong'];
}

?>

<div class="schedule-list">
    <?php
        if(isset($_GET['chitietCa'])){
            echo '<a href="index.php?page=QLP" style="color:#007bff"><b> <i class="fa-solid fa-house"></i>   DANH SÁCH PHÒNG</b></a>';
        }
    
    ?>

    <h5 align="center"><b class="color">DANH SÁCH CA LÀM VIỆC PHÒNG <?=$ten?> </b></h5>
    <div align="center" style="margin:10px;">
        <b><a style="color :#FFCC00 ; border:solid 1px; padding:3px;" href="?page=QLP&themCa=<?=$id?>">+ Thêm
                Ca</a></b>
    </div>
    <table class="schedule-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên ca</th>
                <th>Đã đăng ký</th>
                <th>Đăng ký tối đa</th>
                <th>Sửa Ca</th>
                <th>Xóa Ca</th>
                <th>Xem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($dsCabyPhong) == 0) {
                echo '<tr>';
                echo '<td colspan="6">';
                echo 'Phòng này đang lên kế hoạch !';
                echo '</td>';
                echo '</tr>';
            } else {
                $dem = 1;
                foreach ($dsCabyPhong as $i) {
                    echo '<tr>';
                    echo '<td>' . $dem++ . '</td>';
                    echo '<td>' . $i['TenCa'] . '</td>';
                    echo '<td>' . $i['DaDangKy'] . '</td>';
                    echo '<td>' . $i['DangKyToiDa'] . '</td>';
                    echo
                        '<td> 
                            <a href="?page=QLP&suaC=' . $i['MaCTPhongKham'] . '">Sửa</a>
                        </td>';
                    echo
                        '<td>
                            <a href="?page=QuanLyKhoa&xoaC=' . $i['MaCTPhongKham'] . '" onclick="return confirm(\'Bạn có chắc muốn xóa Phòng này không ?\')">Xóa</a>
                        </td>';
                    echo
                        '<td> 
                            <a href="?page=QLP&chitiet=' . $i['MaPhong'] . '&chitietCa=' . $i['MaCTPhongKham'] . '">Xem chi tiết</a>
                        </td>';
                    echo '</tr>';
                }
            }

            ?>
        </tbody>
    </table>
</div>