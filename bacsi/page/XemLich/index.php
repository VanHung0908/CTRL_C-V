<?php

include_once(BACKEND_URL . 'model/mEmployee.php');
$p = new mEmployee;
$kq = $p->selectLicTrucNV($_SESSION['maNS']);
$workShifts = [];
foreach ($kq as $row) {
    $date = $row['NgayTrongTuan'];
    $shift = $row['CaTrongNgay'];
    $phong = $row['TenPhong'];
    $workShifts[$date][] = ['shift' => $shift, 'phong' => $phong];
}

$ngaynghiphep = $p->ngaynghiphep($_SESSION['maNS']);
$leaveShifts = [];

foreach ($ngaynghiphep as $i) {
    $date = $i['NgayNghiPhep'];
    $shift = $i['CaLam'];
    $status = $i['TrangThai'];

    if (!isset($leaveShifts[$date])) {
        $leaveShifts[$date] = [];
    }
    $leaveShifts[$date][$shift] = $status;
}

$pp = $p->selectDateStartEnd($_SESSION['maNS']);
$startDate = '';
$endDate = '';
foreach ($pp as $i) {
    $startDate = $i['NgayBatDau'];
    $endDate = $i['NgayKetThuc'];
}

?>

<div class="main-content" id="main-content">

    <h2 align="center" style="color: #4682B4;margin-top:20px;"><b>LỊCH LÀM VIỆC</b></h2>
    <div class="btn-group">
        <button onclick="previousWeek()" class="btn btn-outline-secondary">Tuần Trước</button>
        <button onclick="nextWeek()" class="btn btn-outline-secondary">Tuần Kế Tiếp</button>
        <button onclick="currentWeek()" class="btn btn-outline-secondary">Tuần Hiện Tại</button>
        <input type="date" id="datePicker" onchange="goToSelectedDate()" placeholder="Chọn ngày">
    </div>

    <div id="calendar" class="schedule-table"></div>

    <script>
        function setDefaultDate() {
            const datePicker = document.getElementById('datePicker');
            const currentDate = new Date();
            const formattedDate = currentDate.toISOString().split('T')[0];
            datePicker.value = formattedDate;
        }

        function goToSelectedDate() {
            const datePicker = document.getElementById('datePicker');
            const selectedDate = datePicker.value;

            if (selectedDate) {
                const selectedDateObj = new Date(selectedDate);
                currentDate = selectedDateObj;
                renderCalendar(new Date(selectedDateObj));
            } else {
                alert("Vui lòng chọn một ngày hợp lệ!");
            }
        }
        window.onload = setDefaultDate;
    </script>

    <div id="leaveForm"
        style="display: none; margin: 0 auto; width: 300px; padding: 20px; border: 2px solid #000; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); margin-top: 20px;"
        align="center">
        <form id="leaveRequestForm" method="post">
            <h2>Đăng Ký Nghỉ Phép</h2>
            <label for="leaveDate">Ngày nghỉ:</label>
            <input type="text" id="leaveDate" readonly name="ngaynghi"><br><br> 
            <label for="leaveShift">Ca làm việc:</label>
            <input type="text" id="leaveShift" readonly><br><br>
            <input type="hidden" id="hiddenShiftType" name="ca">
            <input type="hidden" id="phong" name="phong">
            <label for="reason">Lý do nghỉ:</label>
            <input type="text" name="lydo" required><br><br>
            <input type="submit" name="btn" value="Gửi">
            <button type="button" onclick="closeForm()">Hủy</button>
        </form>
    </div>

    <div id="notification" style="display:none; padding: 10px; margin: 10px 0; border-radius: 5px; font-size: 14px;">
    </div>

    <?php

    $successMessage = '';
    if (isset($_POST['btn'])) {
        $ngaynghi = $_POST['ngaynghi'];
        $lydo = $_POST['lydo'];
        $ca = $_POST['ca'];
        $phong = $_POST['phong'];
    
        // Chuyển ngày nghỉ từ dạng d/m/Y thành định dạng chuẩn
        $date = DateTime::createFromFormat('d/m/Y', $ngaynghi);
        if (!$date) {
            $errorMessage = 'Ngày nghỉ không hợp lệ!';
            echo '<div id="notificationModal" class="modal" style="display: block;">
                    <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                        <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                        <button id="closeModal" class="btn btn-danger">Đóng</button>
                    </div>
                  </div>';
        } else {
            // Chuyển đổi ngày nghỉ thành timestamp
            $ngaynghiTimestamp = $date->getTimestamp();
            $currentDateTimestamp = time(); // Timestamp của ngày hiện tại
    
            // Kiểm tra nếu ngày nghỉ bé hơn ngày hiện tại
            if ($ngaynghiTimestamp < $currentDateTimestamp) {
                $errorMessage = 'Ngày nghỉ phép không thể nhỏ hơn ngày hiện tại!';
                echo '<div id="notificationModal" class="modal" style="display: block;">
                        <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                            <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                            <button id="closeModal" class="btn btn-danger">Đóng</button>
                        </div>
                      </div>';
            } else {
                $checkDangKy = [];
                foreach ($ngaynghiphep as $i) {
                    $checkDangKy[$i['NgayNghiPhep']][] = $i['CaLam'];
                }
    
                if (isset($checkDangKy[$ngaynghi]) && in_array($ca, $checkDangKy[$ngaynghi])) {
                    $errorMessage = 'Đã xin nghỉ phép ca làm việc này!';
                    echo '<div id="notificationModal" class="modal" style="display: block;">
                            <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                                <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                                <button id="closeModal" class="btn btn-danger">Đóng</button>
                            </div>
                          </div>';
                } else {
                    if (!empty($ngaynghi) && !empty($lydo) && !empty($ca)) {
                        $con = new mEmployee;
                        $kq = $con->dknp($_SESSION['maNS'], $ngaynghi, $ca, $lydo, $phong);
                        if ($kq) {
                            $successMessage = 'Đăng ký nghỉ phép thành công!';
                            echo '<div id="notificationModal" class="modal" style="display: block;">
                                    <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                                        <p style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: center;">' . $successMessage . '</p>
                                        <button id="closeModal" class="btn btn-success">Đóng</button>
                                    </div>
                                  </div>';
                        } else {
                            $errorMessage = 'Xin nghỉ phép thất bại!';
                            echo '<div id="notificationModal" class="modal" style="display: block;">
                                    <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                                        <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                                        <button id="closeModal" class="btn btn-danger">Đóng</button>
                                    </div>
                                  </div>';
                        }
                    }
                }
            }
        }
    }
    
    
    ?>

</div>

<script>
    var modal = document.getElementById("notificationModal");
    var notificationCloseModal = document.getElementById("closeModal");

    notificationCloseModal.onclick = function () {
        window.location.href = 'http://localhost/QLBV/bacsi/index.php?page=XemLich'; // Quay lại trang khi nhấn nút Đóng
    };
</script>

<script>
    let currentDate = new Date();
    const workShifts = <?php echo json_encode($workShifts); ?>;
    const leaveShifts = <?php echo json_encode($leaveShifts); ?>;

    function renderCalendar(date) {
        const startOfWeek = new Date(date.setDate(date.getDate() - date.getDay() + 1));
        const endOfWeek = new Date(date.setDate(startOfWeek.getDate() + 6));

        let calendarHTML = '<table><tr><th>Ca làm</th>';

        for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
            const adjustedDay = (day.getDay() === 0) ? 6 : day.getDay() - 1;
            calendarHTML += `<th>${day.toLocaleDateString('vi-VN', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' })}</th>`;
        }

        calendarHTML += '</tr>';
        const shiftNames = ["Sáng", "Chiều", "Tối"];
        for (let shiftIndex = 1; shiftIndex <= 3; shiftIndex++) {
            const rowCells = [];

            for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
                let note = '';
                const dayIndex = (day.getDay() === 0) ? 6 : day.getDay() - 1;
                const dateString = day.toLocaleDateString('vi-VN');
                const shiftsForDay = workShifts[dayIndex] || [];
                let phongText = '';
                let shiftClass = '';
                let trangthai = '';
                let shiftText = '';

                shiftsForDay.forEach((shift) => {
                    if (shift.shift == shiftIndex) {
                        if (shiftIndex == 1) shiftText = 'Giờ : 7h-11h30';
                        else if (shiftIndex == 2) shiftText = 'Giờ : 13h-17h';
                        else if (shiftIndex == 3) shiftText = 'Giờ : 18h-22h';

                        phongText = `Phòng: ${shift.phong}`;

                        if (leaveShifts[dateString] && leaveShifts[dateString][shiftIndex] !== undefined) {
                            const status = leaveShifts[dateString][shiftIndex];
                            if (status == 0) {
                                trangthai = '<span style="color: orange;font-size:10px;">Trạng thái: Chờ duyệt</span>';
                                shiftClass = 'shift-pending';
                            } else if (status == 1) {
                                trangthai = '<span style="color: green;font-size:10px;">Trạng thái: Đã duyệt</span>';
                                shiftClass = 'shift-approved';
                            } else if (status == 2) {
                                trangthai = '<span style="color: red;font-size:10px;">Trạng thái: Từ chối</span>';
                                shiftClass = 'shift-rejected';
                            }
                        } else {
                            trangthai = ''; // Không có trạng thái nghỉ phép
                        }

                        note = `<a href="#" onclick="openLeaveForm('${dateString}', '${shiftText}', '${shiftIndex}', '${phongText}')">
                            <div class="shift-box ${shiftClass}">
                                ${shiftText}
                                <div class="room-info"> ${phongText}</div>
                                ${trangthai}
                            </div>
                        </a>`;
                    }
                });

                rowCells.push(note || '');
            }

            calendarHTML += `<tr><td>${shiftNames[shiftIndex - 1]}</td>`;
            rowCells.forEach(cell => {
                calendarHTML += `<td>${cell}</td>`;
            });
            calendarHTML += '</tr>';
        }

        calendarHTML += '</table>';
        document.getElementById('calendar').innerHTML = calendarHTML;
        
    }

    function openLeaveForm(date, shift, shiftType,phongText) {
        document.getElementById('leaveDate').value = date;
        document.getElementById('leaveShift').value = shift;
        
        document.getElementById('hiddenShiftType').value = shiftType;
        document.getElementById('phong').value = phongText;
        document.getElementById('leaveForm').style.display = 'block'; 
    }

    function closeForm() {
        document.getElementById('leaveForm').style.display = 'none';
    }

    function previousWeek() {
        currentDate.setDate(currentDate.getDate() - 7);
        renderCalendar(new Date(currentDate));
    }

    function nextWeek() {
        currentDate.setDate(currentDate.getDate() + 7);
        renderCalendar(new Date(currentDate));
    }

    function currentWeek() {
        currentDate = new Date();
        renderCalendar(new Date(currentDate));
    }

    renderCalendar(new Date(currentDate));
</script>

<style>
    /* Khung cho mỗi ca làm việc */
    .shift-box {
        padding: 10px;
        margin: 5px 0;
        border: 2px solid #007bff;
        border-radius: 5px;
        background-color: #f0f8ff;
        text-align: center;
        font-weight: bold;
        font-size: 14px;
    }

    #leaveForm {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 350px;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        background-color: #f9f9f9;
        z-index: 1000;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    #leaveForm h2 {
        text-align: center;
        color: #4682B4;
        font-size: 22px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    #leaveForm label {
        display: block;
        font-size: 14px;
        margin-bottom: 8px;
        color: #333;
    }

    #leaveForm input[type="text"],
    #leaveForm input[type="submit"],
    #leaveForm button {
        width: 100%;
        padding: 10px;
        margin: 8px 0 16px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    #leaveForm input[type="text"]:focus,
    #leaveForm input[type="submit"]:hover,
    #leaveForm button:hover {
        border-color: #4682B4;
        outline: none;
        box-shadow: 0 0 10px rgba(70, 130, 180, 0.5);
    }

    #leaveForm input[type="submit"],
    #leaveForm button {
        background-color: #4682B4;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }

    #leaveForm input[type="submit"]:hover,
    #leaveForm button:hover {
        background-color: #5A9BD4;
    }

    #leaveForm .cancel-btn {
        background-color: #f44336;
        margin-top: 10px;
    }

    #leaveForm .cancel-btn:hover {
        background-color: #d32f2f;
    }

    .room-info {
        font-size: 12px;
        font-style: italic;
        color: #555;
        margin-top: 5px;
    }



    /* Màu sắc cho các ca làm việc */
    /* Định nghĩa màu nền cho mỗi ca làm việc */
    .shift-morning {
        background-color: #d1e7ff;
        /* Màu cho ca sáng */
        border-color: #80b3ff;
    }

    .shift-afternoon {
        background-color: #fff3cd;
        /* Màu cho ca chiều */
        border-color: #ffec8b;
    }

    .shift-evening {
        background-color: #e2e3e5;
        /* Màu cho ca tối */
        border-color: #b1b3b8;
    }

    /* Trạng thái chờ xét duyệt */
    .shift-pending {

        border-color: #ff9900;
    }

    /* Trạng thái đã xét duyệt */
    .shift-approved {

        border-color: #218838;
    }

    /* Trạng thái từ chối */
    .shift-rejected {

        border-color: #c82333;
    }


    /* Khi người dùng hover lên ca làm */
    .shift-box:hover {
        background-color: #e6f7ff;
        cursor: pointer;
    }

    /* Phòng làm việc */
    .room-info {
        font-size: 12px;
        font-style: italic;
        color: #555;
    }

    #notification {
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    button {
        margin-right: 10px;
    }
</style>