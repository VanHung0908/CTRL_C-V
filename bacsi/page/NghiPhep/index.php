<?php
ob_start();
?>
<a href=""></a>
<p></p>
<?php
include_once(BACKEND_URL . 'model/mEmployee.php');
$con = new mEmployee;
$dsYCNP = $con->NPCaNhan($_SESSION['maNS']);

echo '<div class="main-content" id="main-content">
<h3 align="center" style="margin-top:20px;"><b style="color:#D2691E;margin-top:50px;">DANH SÁCH NGHỈ PHÉP CỦA BẠN</b></h3>
<div align="center" style="margin:10px;">
<b><a style="color : #FFCC00 ; border:solid 1px; padding:3px;" href="?page=XemLich" onclick="return confirm(\'Vui lòng nhấn vào ca của ngày bạn muốn xin nghỉ trong chức năng Xem lịch. Tiếp tục ? \')">+ Đăng ký nghỉ phép</a></b>
</div>
    <form action="" method="post">
        <table class="leave-request-table" align="center">
            <tr>
                <th>STT</th>
                <th>Phòng làm việc</th>
                <th>Ngày Nghỉ Phép</th>
                <th>Ca</th>
                <th>Lý Do</th>
                <th>Thời gian đăng ký</th>
                <th>Trạng thái</th>
                <th>Lý do bị từ chối</th>
            </tr>';
    if (!mysqli_num_rows($dsYCNP) > 0) {
        echo '
        <tr>
        <td colspan="10"> Chưa có yêu cầu nào</td>
        </tr>';
        
    }else{
        $tt = 1;
        $ttt = [
            0 => 'Chờ duyệt',
            1 => 'Đã duyệt',
            2 => 'Từ chối',
        ];
    foreach ($dsYCNP as $i) {
        echo '<tr>
                <td>' . $tt++ . '</td>
                <td>' . $i['Phong'] . '</td>
                <td>' . $i['NgayNghiPhep'] . '</td>
                <td>' . $i['CaLam'] . '</td>
                <td>' . $i['LyDo'] . '</td>
                <td>' . $i['ThoiGianDK'] . '</td>
                <td>' . $ttt[$i['TrangThai']] . '</td>
                <td>' . $i['LyDo_TuChoi'] . '</td>
            </tr>';
    }
    
    }

    echo '</table>
          </form>
          </div>';

?>
