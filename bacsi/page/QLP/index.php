<?php
    include_once(BACKEND_URL.'/model/mQLPhongKham.php');
    $con = new phong;
    $dsKhoa = $con->AllPhongbyKhoa($_SESSION['maKhoa']);
    foreach ($dsKhoa as $i) {
        $tenkhoa = $i['TenKhoa'];
    }
?>
<div class="main-content" id="main-content">
        <h3 align="center" style="margin-top:20px;"><a href="index.php?page=QLP" style="color : #4682B4; "><b>QUẢN LÝ
                    PHÒNG KHÁM</b></a></h3>
        <p align="center" style="margin-top:10px;"><a href="index.php?page=QLP" style="color : #4682B4; "
                id="loadPageLink"><b>
                    <?= $tenkhoa ?></b></a></p>

        <?php 
        
        // Kiểm tra nếu không có tham số themP (thêm phòng) và chitietCa (chi tiết ca)
        if(!isset($_GET['themP']) && !isset($_GET['chitietCa']) && !isset($_GET['themCa']) && !isset($_GET['themCTCa']) && !isset($_GET['suaC'])&& !isset($_GET['suaCT'])&& !isset($_GET['suaP'])) {
            // Hiển thị danh sách phòng
            echo '
                <div class="schedule-list">
                    <h5 align="center"><b class="color">DANH SÁCH PHÒNG LÀM VIỆC</b></h5>
                    <div align="center" style="margin:10px;">
                            <b><a style="color : #FFCC00 ; border:solid 1px; padding:3px;" href="?page=QLP&themP">+ Thêm
                            Phòng</a></b>
                    </div>
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên phòng</th>
                                <th>Tòa nhà</th>
                                <th>Mô tả</th>
                                <th>Khoa</th>
                                <th>Sửa Phòng</th>
                                <th>Xóa Phòng</th>
                                <th>Xem chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>';
                        $dem = 1;
                        foreach ($dsKhoa as $i) {
                            echo '<tr>';
                            echo '<td>' . $dem++ . '</td>';
                            echo '<td>' . $i['TenPhong'] . '</td>';
                            echo '<td>' . $i['Toa'] . '</td>';
                            echo '<td>' . $i['MoTa'] . '</td>';
                            echo '<td>' . $tenkhoa . '</td>';
                            echo
                                '<td> 
                                        <a href="?page=QLP&suaP=' . $i['MaPhong'] . '">Sửa</a>
                                    </td>';
                            echo
                                '<td>
                                        <a href="?page=QLP&xoaP=' . $i['MaPhong'] . '" onclick="return confirm(\'Bạn có chắc muốn xóa Phòng này không ?\')">Xóa</a>
                                    </td>';
                            echo '<td> <a href="?page=QLP&chitiet=' . $i['MaPhong'] . '">Xem chi tiết</a> </td>';
                            echo '</tr>';
                        }
                        echo '
                        </tbody>
                    </table>
                </div>';
        } 
        if (isset($_GET['chitiet']) && !isset($_GET['themCTCa'])) { 
            // Xóa session 'chitiet' trước khi gán lại
            if (isset($_SESSION['chitiet'])) {
                unset($_SESSION['chitiet']);
            }
            $_SESSION['chitiet'] = $_GET['chitiet'];
            include_once('page/QLP/ajax.php');
            
            // Nếu có tham số themCa thì hiển thị thêm Ca
            
        }
        if (isset($_GET['themCa']) || isset($_GET['themP']) || isset($_GET['themCTCa'])) {
            include_once('page/QLP/them.php');
        } else if(isset($_GET['suaP']) || isset($_GET['suaC']) || isset($_GET['suaCT'])){
            include_once('page/QLP/sua.php');
        }
        if (isset($_GET['chitietCa'])) { 
            // Xóa session 'chitietCa' trước khi gán lại
            if (isset($_SESSION['chitietCa'])) {
                unset($_SESSION['chitietCa']);
            }
            $_SESSION['chitietCa'] = $_GET['chitietCa'];
            include_once('page/QLP/ajax2.php');
            
            // Nếu có tham số themCTCa thì hiển thị thêm chi tiết ca
            
        }
        
        
        ?>

        <!-- JavaScript -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function getALLCabyPhong(value) {
                $.ajax({
                    url: "page/QLP/hienthi.php",
                    type: "POST",
                    data: { value: value },
                    success: function (result) {
                        $("#Ca").html(result);
                    },
                });
            }
        </script>
    </div>
</body>
<!-- PHP -->
<?php
if (isset($_POST['btnThemP'])) {
    $checkTenPhong = $con->AllPhongbyKhoa($_SESSION['maKhoa']);
    $arr = [];
    foreach ($checkTenPhong as $i) {
        $arr[] = $i['TenPhong'];
    }
    if (in_array($_POST['ten'], $arr)) {
        echo '<script>alert("Tên phòng đã tồn tại !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP&themP";
          </script>';
    }else{
        $kq = $con->InsertPhong($_POST['ten'], $_POST['toa'], $_POST['mt'], $_SESSION['maKhoa']);
    if ($kq) {
        echo '<script>alert("Thêm phòng thành công !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP";
          </script>';
    }
}
}if (isset($_POST['btnSuaP'])) {
    $checkTenPhong = $con->AllPhongbyKhoa($_SESSION['maKhoa']);
    $arr = [];
    foreach ($checkTenPhong as $i) {
        $arr[] = $i['TenPhong'];
    }
    if (in_array($_POST['ten'], $arr) && $_POST['ten'] != $t ) {
        echo '<script>alert("Tên phòng đã tồn tại !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP&suaP='.$_GET['suaP'].'";
          </script>';
          exit();
    }
        $kq = $con->UpdatePhong($_POST['ten'], $_POST['toa'], $_POST['mt'], $_GET['suaP']);
    if ($kq) {
        echo '<script>alert("Sửa phòng thành công !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP";
          </script>';
    }
} else if (isset($_POST['btnThemCa'])) {
    $ktra = $con -> AllCabyPhong($_SESSION['chitiet']);
    $arr = [];
    foreach ($ktra as $i) {
        $arr[] = $i['TenCa'];
    }
    if (in_array($_POST['ten'], $arr)) {
        echo '<script>alert("Tên Ca đã tồn tại !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP&themCa='.$_SESSION['chitiet'].'";
          </script>';
    }else{
    $kq = $con->InsertCaByPhong($_GET['themCa'], $_POST['ten'], $_POST['dadk'], $_POST['maxdk']);
    if ($kq) {
        echo '<script>alert("Thêm ca thành công !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'";
          </script>';
    } else {
        echo 'Lỗi khi thêm Ca.';
    }
}

}else if (isset($_POST['btnSuaCa'])) {
    $ktra = $con -> AllCabyPhong($_SESSION['chitiet']);
    $arr = [];
    foreach ($ktra as $i) {
        $arr[] = $i['TenCa'];
    }
    if (in_array($_POST['ten'], $arr)) {
        echo '<script>alert("Tên Ca đã tồn tại !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP&SuaCa='.$_GET['suaC'].'";
          </script>';
          exit();
    }
    $kq = $con->UpdateCa($_GET['suaC'], $_POST['ten'], $_POST['dadk'], $_POST['maxdk']);
    if ($kq) {
        echo '<script>alert("Sửa ca thành công !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'";
          </script>';
    } else {
        echo 'Lỗi khi thêm Ca.';
    }

} else
if (isset($_POST['btnThemCTCa'])) {
    $maCa = $_GET['themCTCa'];
    $errors = [];
    $dataToInsert = []; // Mảng để lưu các dữ liệu cần thêm vào

    // Lưu dữ liệu từ form vào mảng $dataToInsert
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_POST["day_of_week_$i"]) && isset($_POST["shift_$i"])) {
            $day_of_week = $_POST["day_of_week_$i"];
            $shift = $_POST["shift_$i"];

            // Kiểm tra tính hợp lệ của dữ liệu
            if (
                !is_numeric($day_of_week) || $day_of_week < 0 || $day_of_week > 6 ||
                !is_numeric($shift) || $shift < 0 || $shift > 2
            ) {
                $errors[] = "Dữ liệu không hợp lệ cho ngày $day_of_week và ca $shift.";
                continue;
            }

            // Thêm vào mảng để kiểm tra sau
            $dataToInsert[] = ['day_of_week' => $day_of_week, 'shift' => $shift];
        }
    }

    // Kiểm tra tất cả dữ liệu có trùng lặp trong cơ sở dữ liệu không
    $isDuplicate = false;
    foreach ($dataToInsert as $data) {
        $existingData = $con->checkExistingSchedule($maCa, $data['day_of_week'], $data['shift']);
        if (mysqli_num_rows($existingData)>0) {
            $isDuplicate = true; // Nếu có dòng trùng thì gán flag thành true
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
            $errors[] = "Ca vào ngày : " . $daysOfWeek[$data['day_of_week']] . " (" . $shifts[$data['shift']] . ") đã tồn tại.";
            break; // Dừng kiểm tra khi tìm thấy trùng
        }
    }

    // Nếu không có trùng, tiến hành thêm tất cả dữ liệu vào cơ sở dữ liệu
    if (!$isDuplicate) {
        foreach ($dataToInsert as $data) {
            $result = $con->CTCabyCa($maCa, $data['day_of_week'], $data['shift']);
            if (!$result) {
                $errors[] = "Có lỗi xảy ra khi thêm ca vào ngày " . $data['day_of_week'] . " (shift " . $data['shift'] . ").";
            }
        }
    }

    // Hiển thị kết quả
    if (empty($errors)) {
        echo '<script>alert("Thêm chi tiết ca thành công !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'&chitietCa='.$_SESSION['chitietCa'].'";
          </script>';
    } else {
        echo '<script>alert("'. implode("<br>", $errors).'!")</script>';
        echo " <p style=color:red;'>Thông báo :" . implode("<br>", $errors)."</p>" ;
    }
}
 else
if (isset($_POST['btnSuaCTCa'])) {
    $maCa = $_SESSION['chitiet']; // Lấy mã ca cần sửa từ tham số GET
    $errors = [];
    
    // Lấy dữ liệu từ form
    if (isset($_POST["day_of_week"]) && isset($_POST["shift"])) {
        $day_of_week = $_POST["day_of_week"];
        $shift = $_POST["shift"];

        // Kiểm tra tính hợp lệ của dữ liệu
        if (
            !is_numeric($day_of_week) || $day_of_week < 0 || $day_of_week > 6 ||
            !is_numeric($shift) || $shift < 1 || $shift > 2
        ) {
            $errors[] = "Dữ liệu không hợp lệ: ngày $day_of_week và ca $shift.";
        } else {
            // Kiểm tra trùng lặp dữ liệu trong cơ sở dữ liệu
            $existingData = $con->checkExistingSchedule($maCa, $day_of_week, $shift);
            if (mysqli_num_rows($existingData)>0) {
                $daysOfWeek = [
                    0 => "Thứ 2",
                    1 => "Thứ 3",
                    2 => "Thứ 4",
                    3 => "Thứ 5",
                    4 => "Thứ 6",
                    5 => "Thứ 7",
                    6 => "Chủ nhật"
                ];

                $shifts = [
                    1 => "Ca sáng",
                    2 => "Ca chiều"
                ];

                $errors[] = "Ca vào ngày: " . $daysOfWeek[$day_of_week] . " (" . $shifts[$shift] . ") đã tồn tại.";
            }
        }

        // Nếu không có lỗi, tiến hành cập nhật
        if (empty($errors)) {
           
            $result = $con->UpdateCTCa($_GET['suaCT'], $day_of_week, $shift); // Hàm cập nhật dữ liệu
            if ($result) {
                echo '<script>alert("Sửa chi tiết ca thành công !")</script>';
                echo '<script>
                    window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'&chitietCa='.$_SESSION['chitietCa'].'";
                </script>';
            } else {
                $errors[] = "Có lỗi xảy ra khi cập nhật dữ liệu.";
            }
        }
    } else {
        $errors[] = "Dữ liệu không đầy đủ.";
    }

    // Hiển thị thông báo lỗi nếu có
    if (!empty($errors)) {
        echo '<script>alert("' . implode("\\n", $errors) . '");</script>';
        // echo '<p style="color:red;">Thông báo: ' . implode("<br>", $errors) . '</p>';
    }
}else if(isset($_GET['xoaCT'])){
    $ktra = $con -> xoaChiTiet($_GET['xoaCT']);
    if($ktra){
        echo '<script>alert("Xóa chi tiết ca thành công !")</script>';
                echo '<script>
                    window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'&chitietCa='.$_SESSION['chitietCa'].'";
                </script>';
    }else{
        echo '<script>alert("Xóa chi tiết ca thất bại !")</script>';
                echo '<script>
                    window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'&chitietCa='.$_SESSION['chitietCa'].'";
                </script>';
    }

}
else if(isset($_GET['xoaC'])){
    $ktraCaDDK = $con -> ktraCaDDK($_GET['xoaC']);
    if(mysqli_num_rows($ktraCaDDK ) > 0){
        echo '<script>alert("Không thể xóa Ca này do đang có người đăng ký !")</script>';
                echo '<script>
                    window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'";
                </script>';
    }else{
        $ktra = $con -> xoaCa($_GET['xoaC']);
        if($ktra){
            echo '<script>alert("Xóa Ca thành công !")</script>';
                    echo '<script>
                        window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'";
                    </script>';
        }else{
            echo '<script>alert("Xóa Ca thất bại !")</script>';
                    echo '<script>
                        window.location.href = "index.php?page=QLP&chitiet='.$_SESSION['chitiet'].'";
                    </script>';
        }
    }
    

}else if(isset($_GET['xoaP'])){
    $ktraCaDDK = $con -> ktraPhongCoCa($_GET['xoaP']);
    if(mysqli_num_rows($ktraCaDDK ) > 0){
        echo '<script>alert("Không thể xóa Phòng này do có Ca có người đăng ký !")</script>';
                echo '<script>
                    window.location.href = "index.php?page=QLP";
                </script>';
    }else{
        $ktra = $con -> xoaPhong($_GET['xoaP']);
        if($ktra){
            echo '<script>alert("Xóa Phòng thành công !")</script>';
                    echo '<script>
                        window.location.href = "index.php?page=QLP";
                    </script>';
        }else{
            echo '<script>alert("Xóa Phòng thất bại !")</script>';
                    echo '<script>
                        window.location.href = "index.php?page=QLP";
                    </script>';
        }
    }
    

}



?>



<!-- CSS -->
<style>
    .schedule-list {
        width: 80%;
        margin: 0 auto;
        margin-top: 20px;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin: 0;
    }

    .schedule-table th,
    .schedule-table td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 8px;
        height: 40px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;

    }

    .schedule-table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .details-table {
        margin-top: 20px;

    }

    .color {
        color: #D2691E;
    }


    .register-btn {
        margin-top: 20px;
        display: flex;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: #FFA500;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;

    }

    .register-btn:hover {
        background-color: #FFA500;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .register-btn:active {
        background-color: #FF4500;
        transform: scale(0.98);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>