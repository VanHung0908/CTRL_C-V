<?php
if (isset($_GET['themP'])) {
    echo '
            <div class="schedule-list">
                <h5 align="center"><b class="color">Thêm phòng</b></h5>
                <form action="" method="post">
                    <table class="schedule-table">
                        <tr>
                            <td>Tên phòng</td>
                            <td><input type="text" name="ten" style="width:500px;"></td>
                        </tr>
                        <tr>
                            <td>Tòa nhà</td>
                            <td><input type="text" name="toa" style="width:500px;"></td>
                        </tr>
                        <tr>
                            <td>Mô tả</td>
                            <td><textarea name="mt" id="" cols="30" rows="10" style="width:500px;"></textarea></td>
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
            <div class="schedule-list">
                <h5 align="center"><b class="color">Thêm Ca cho phònng ' . $name . '</b></h5>
                <form action="" method="post">
                    <table class="schedule-table">
                        <tr>
                            <td>Tên Ca</td>
                            <td><input type="text" name="ten" style="width:500px;"></td>
                        </tr>
                        <tr>
                            <td>Đã đăng ký</td>
                            <td><input type="text" name="dadk" style="width:500px;"></td>
                        </tr>
                        <tr>
                            <td>Đăng ký tối đa</td>
                            <td><input type="text" name="maxdk" style="width:500px;"></td>
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
     <div class="schedule-list">
         <h5 align="center"><b class="color">Thêm Chi tiết cho ' . $name . '</b></h5>
         <form action="" method="post">
             <table class="schedule-table">';

    for ($i = 1; $i <= 5; $i++) {
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
                    <option value="0">Cả ngày</option>
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