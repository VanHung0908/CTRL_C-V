<!-- PHP -->
<?php
include_once(BACKEND_URL . 'model/mPhong.php');
$con = new phong;
$dsKhoa = $con->AllPhongbyKhoa($_SESSION['maKhoa']);
foreach ($dsKhoa as $i) {
    $tenkhoa = $i['TenKhoa'];
}
?>

<body>
    <div class="main-content" id="main-content">
        <h3 align="center" style="margin-top:20px;"><a href="index.php?page=QLP" style="color : #4682B4; "><b>QUẢN LÝ
                    PHÒNG KHÁM</b></a></h3>
        <p align="center" style="margin-top:10px;"><a href="index.php?page=QLP" style="color : #4682B4; " id="loadPageLink"><b>
                    <?= $tenkhoa ?></b></a></p>

        <?php
        
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
                                    <th></th>
                                    <th>STT</th>
                                    <th>Tên phòng</th>
                                    <th>Tòa nhà</th>
                                    <th>Mô tả</th>
                                    <th>Khoa</th>
                                    <th>Sửa Phòng</th>
                                    <th>Xóa Phòng</th>
                                </tr>
                            </thead>
                            <tbody>';
            $dem = 1;
            foreach ($dsKhoa as $i) {
                echo '<tr>';
                echo '<td><input type="radio" name="shift" onclick="getMaPhong(' . $i['MaPhong'] . ')"></td>';
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
                                            <a href="?page=QuanLyKhoa&xoaP=' . $i['MaPhong'] . '" onclick="return confirm(\'Bạn có chắc muốn xóa Phòng này không ?\')">Xóa</a>
                                        </td>';
                echo '</tr>';
            }
            echo '
                            </tbody>
                        </table>
                    </div>

                    <div id="Ca">
                                    <!-- Hiển thị Ca theo Phòng (AJAX) -->
                    </div>
                    <div id="CTCa">
                                    <!-- Hiển thị Chi tiết theo Ca (AJAX) -->
                    </div>';
        
                    if (isset($_GET['themP']) || isset($_GET['themCa']) || isset($_GET['themCTCa'])) 
            include_once('page/QLP/them.php');
        
        ?>

        <!-- JavaScript -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function getMaPhong(value) {
                $.ajax({
                    url: "page/QLP/ajax.php",
                    type: "POST",
                    data: { value: value },
                    success: function (result) {
                        $("#Ca").html(result);
                    },
                });
            }
            function reloadCaListAfterAdd(value) {
    // Call getCaByPhong to refresh the list of shifts
                getCaByPhong(value);
            }

            function getCTCa(value) {
                $.ajax({
                    url: "page/QLP/ajax2.php",
                    type: "POST",
                    data: { value: value },
                    success: function (result) {
                        $("#CTCa").html(result);
                    },
                });
            }
        </script>
</body>
<!-- PHP -->
<?php
$successMessage = '';
$errorMessage = '';
if (isset($_POST['btnThemP'])) {
    $checkTenPhong = $con->AllPhongbyKhoa($_SESSION['maKhoa']);
    $arr = [];
    foreach ($checkTenPhong as $i) {
        $arr[] = $i['TenPhong'];
    }
    if (in_array($_POST['ten'], $arr)) {
        $errorMessage = 'Phòng này đã tồn tại !';
        echo '<div id="notificationModal" class="modal" style="display: block;">
                    <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                        <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                        <button id="ERRcloseModal" class="btn btn-danger">Đóng</button>
                    </div>
                </div>';
        exit();
    }
    $kq = $con->InsertPhong($_POST['ten'], $_POST['toa'], $_POST['mt'], $_SESSION['maKhoa']);
    if ($kq) {
        $successMessage = 'Thêm Phòng mới thành công!';
        echo '<div id="notificationModal" class="modal" style="display: block;">
                <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                    <p style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: center;">' . $successMessage . '</p>
                    <button id="closeModal" class="btn btn-success">Đóng</button>
                </div>
            </div>';
    } else {
        $errorMessage = 'Đã xảy ra lỗi. Vui lòng thử lại !';
        echo '<div id="notificationModal" class="modal" style="display: block;">
                    <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                        <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                        <button id="ERRcloseModal" class="btn btn-danger">Đóng</button>
                    </div>
                </div>';
    }
} else if (isset($_POST['btnThemCa'])) {
    // Insert new shift
    $kq = $con->InsertCaByPhong($_GET['themCa'], $_POST['ten'], $_POST['dadk'], $_POST['maxdk']);
    if ($kq) {
        echo '<script>
            reloadCaListAfterAdd(' . $_GET['themCa'] . ');
        </script>';
    } else {
        echo 'Lỗi khi thêm Ca.';
    }

} else
    if (isset($_POST['btnThemCTCa'])) {
        $maCa = $_GET['themCTCa'];
        $errors = [];

        for ($i = 1; $i <= 5; $i++) {
            if (isset($_POST["day_of_week_$i"]) && isset($_POST["shift_$i"])) {
                $day_of_week = $_POST["day_of_week_$i"];
                $shift = $_POST["shift_$i"];

                // Kiểm tra tính hợp lệ
                if (
                    !is_numeric($day_of_week) || $day_of_week < 0 || $day_of_week > 6 ||
                    !is_numeric($shift) || $shift < 0 || $shift > 2
                ) {
                    $errors[] = "Dữ liệu không hợp lệ cho ngày $day_of_week và ca $shift.";
                    continue;
                }

                // Gọi hàm để thêm dữ liệu
                $result = $con->CTCabyCa($maCa, $day_of_week, $shift);
                if (!$result) {
                    $errors[] = "Lỗi thêm chi tiết ca ngày $day_of_week - ca $shift.";
                }
            }
        }

        // Kết quả
        if (empty($errors)) {
            echo "Thêm chi tiết ca thành công!";
        } else {
            echo "Có lỗi xảy ra:<br>" . implode("<br>", $errors);
        }
    }

?>

<!-- JS -->
<script>
    document.getElementById("loadPageLink").addEventListener("click", function(event) {
        event.preventDefault(); // Ngừng sự kiện mặc định (không tải lại trang)
    });

    var modal = document.getElementById("notificationModal");
    var notificationCloseModal = document.getElementById("closeModal");
    var notificationCloseModalERR = document.getElementById("ERRcloseModal");

    // Kiểm tra nếu phần tử tồn tại trước khi thêm sự kiện
    if (notificationCloseModal) {
        notificationCloseModal.onclick = function () {
            // Gọi lại AJAX để tải lại danh sách phòng sau khi đóng modal
            $.ajax({
                url: "index.php?page=QLP", // URL để lấy lại danh sách phòng
                success: function(result) {
                    // Cập nhật lại nội dung phòng khi đóng modal
                    $("#main-content").html(result);
                }
            });
        };
    }

    if (notificationCloseModalERR) {
        notificationCloseModalERR.onclick = function() {
            modal.style.display = "none";  // Ẩn modal
        };
    }

    // Thêm sự kiện khi nhấn vào vùng ngoài modal để đóng modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";  // Ẩn modal nếu nhấn vào vùng ngoài modal
        }
    }
</script>



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