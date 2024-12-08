<!-- PHP -->
<?php
include_once('../../../model/mPhong.php');
$con = new phong;
$dsCabyPhong = $con->AllCabyPhong($_POST['value']);
$Phong = $con->PhongByID($_POST['value']);
foreach($Phong as $i){
    $id = $i['MaPhong'];
}
?>
<div class="schedule-list">
    <h5 align="center"><b class="color">DANH SÁCH CA LÀM VIỆC</b></h5>
    <div align="center" style="margin:10px;">
        <b><a style="color : #FFCC00 ; border:solid 1px; padding:3px;" href="?page=QLP&themCa=<?=$id?>" id="loadPageLink">+ Thêm
                Ca</a></b>
    </div>
    <table class="schedule-table">
        <thead>
            <tr>
                <th></th>
                <th>STT</th>
                <th>Tên ca</th>
                <th>Đã đăng ký</th>
                <th>Đăng ký tối đa</th>
                <th>Sửa Ca</th>
                <th>Xóa Ca</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($dsCabyPhong) == 0) {
                echo '<tr>';
                echo '<td colspan="7">';
                echo 'Phòng này đang lên kế hoạch !';
                echo '</td>';
                echo '</tr>';
            } else {
                $dem = 1;
                foreach ($dsCabyPhong as $i) {
                    echo '<tr>';
                    echo '<td><input type="radio" name="shift" onclick="getCTCa(' . $i['MaCTPhongKham'] . ')"></td>';
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
                    echo '</tr>';
                }
            }

            ?>
        </tbody>
    </table>
</div>