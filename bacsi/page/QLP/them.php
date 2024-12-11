<?php
if (isset($_GET['themP'])) {
    echo '
            <div class="schedule-list">
                <a href="index.php?page=QLP" style="color:#007bff"><b> <i class="fa-solid fa-house"></i>   TRỞ VỀ DANH SÁCH PHÒNG</b></a>
                <h5 align="center"><b class="color">THÊM PHÒNG</b></h5>
                <form action="" method="post">
                    <table class="schedule-table">
                        <tr>
                            <td>Tên phòng</td>
                            <td><input type="text" name="ten" style="width:500px;" value="' . (isset($_POST['ten']) ? $_POST['ten'] : '') . '"></td>
                        </tr>
                        <tr>
                            <td>Tòa nhà</td>
                            <td><input type="text" name="toa" style="width:500px;" value="' . (isset($_POST['toa']) ? $_POST['toa'] : '') . '"></td>
                        </tr>
                        <tr>
                            <td>Mô tả</td>
                            <td><textarea name="mt" id="" cols="30" rows="10" style="width:500px;" value="' . (isset($_POST['mt']) ? $_POST['mt'] : '') . '"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Thêm" name="btnThemP" class="custom-button" onclick="return confirm(\'Bạn có chắc chắn lưu những thay đổi này không ?\')"></td>
                        </tr>
                    </table>
                </form>
            </div>';

} else if (isset($_GET['themCa'])) {
    $dsCabyPhong = $con->PhongByID($_GET['themCa']);
    foreach ($dsCabyPhong as $i) {
        $name = $i['TenPhong'];
    }
    echo '
    <a href="index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'" style="color:#007bff"><b> <i class="fa-solid fa-house"></i>  TRỞ VỀ DANH SÁCH CA</b></a>

            <div class="schedule-list">
                <h5 align="center"><b class="color">THÊM CA CHO PHÒNG ' . $name . '</b></h5>
                <form action="" method="post">
                    <table class="schedule-table">
                        <tr>
                            <td>Tên Ca</td>
                            <td><input type="text" name="ten" style="width:500px;"></td>
                        </tr>
                        <tr>
                            <td>Đã đăng ký</td>
                            <td><input type="text" name="dadk" value="0" style="width:500px;" readonly></td>
                        </tr>
                        <tr>
                            <td>Đăng ký tối đa</td>
                            <td><input type="text" name="maxdk" value="1" style="width:500px;" readonly></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Thêm" name="btnThemCa" class="custom-button" onclick="return confirm(\'Bạn có chắc chắn lưu những thay đổi này không ?\')"></td>
                        </tr>
                    </table>
                </form>
            </div>';
} else if (isset($_GET['themCTCa'])) {
    $dsCabyPhong = $con->CabyID($_GET['themCTCa']);
    foreach ($dsCabyPhong as $i) {
        $name = $i['TenCa'];
    }
    echo '
    <a href="index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'&chitietCa='.$_SESSION['chitietCa'].'" style="color:#007bff"><b> <i class="fa-solid fa-house"></i> TRỞ VỀ  DANH SÁCH CHI TIẾT CA</b></a> <br>
              
     <div class="schedule-list">

     <input type="radio" name="CTshift" onclick="getALLCabyPhong(' . $i['MaCTPhongKham'] . ')"> Hiện thi lịch đã tồn tại
     <div id="Ca">
                                    <!-- Hiển thị Ca theo Phòng (AJAX) -->
                    </div>
         <h5 align="center"><b class="color">THÊM CHI TIẾT CA CHO ' . $name . '</b></h5>
         <form action="" method="post">
             <table class="schedule-table">';

    for ($i = 1; $i <= 6; $i++) {
        echo '
        <tr>
            <td>
                <select name="day_of_week_' . $i . '" style="width:300px;">
                    <option value="0">Thứ 2</option>
                    <option value="1">Thứ 3</option>
                    <option value="2">Thứ 4</option>
                    <option value="3">Thứ 5</option>
                    <option value="4">Thứ 6</option>
                    <option value="5">Thứ 7</option>
                    <option value="6">Chủ nhật</option>
                </select>
            </td>
            <td>
                <select name="shift_' . $i . '" style="width:300px;">
                    <option value="1">Ca sáng</option>
                    <option value="2">Ca chiều</option>
                    
                </select>
            </td>
        </tr>';
    }
    echo '
                 <tr>
                     <td colspan="2"><input type="submit" value="Thêm" name="btnThemCTCa" class="custom-button" onclick="return confirm(\'Bạn có chắc chắn lưu những thay đổi này không?\')"></td>
                 </tr>
             </table>
         </form>
     </div>';

}


?>



<style>
    .custom-button {
        width: 200px;
        background-color: #66FF00;
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .custom-button:hover {
        background-color: #55cc00;
        transform: scale(1.05);
    }

    .custom-button:active {
        background-color: #4db200;
        transform: scale(0.95);
    }
</style>