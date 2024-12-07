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
<?php

include_once(BACKEND_URL . 'model/mEmployee.php');
$p = new mEmployee;
$kq = $p->selectLicTrucNV($_SESSION['maNS']);
$workShifts = [];
foreach ($kq as $row) {
    $date = $row['NgayTrongTuan'];
    $shift = $row['CaTrongNgay'];
    $phong = $row['TenPhong'];
    $workShifts[$date] = $shift;
}

$ngaynghiphep = $p->ngaynghiphep($_SESSION['maNS']);
$leaveDays = [];
$leaveStatus = [];
$leaveCa = [];
$lyDo = [];
foreach ($ngaynghiphep as $i) {
    $leaveDays[] = $i['NgayNghiPhep'];
    $leaveCa[$i['NgayNghiPhep']] = $i['CaLam'];
    $leaveStatus[$i['NgayNghiPhep']] = $i['TrangThai'];
    $lyDo[$i['NgayNghiPhep']] = $i['LyDo_TuChoi'];
}

$pp = $p->selectDateStartEnd($_SESSION['maNS']);
foreach ($pp as $i) {
    $StartDate = $i['NgayBatDau'];
    $EndDate = $i['NgayKetThuc'];
}

?>

<div class="main-content" id="main-content">

    <h2 align="center" style="color: #4682B4;;margin-top:20px;"><b>LỊCH LÀM VIỆC</b></h2>
    <span id="weekNumber"> </span>
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
            const formattedDate = currentDate.toISOString().split('T')[0]; // Định dạng yyyy-mm-dd
            datePicker.value = formattedDate;
        }
        //Cập nhật khi chọn lịch phụ sẽ update lịch chính
        function goToSelectedDate() {
            const datePicker = document.getElementById('datePicker');
            const selectedDate = datePicker.value;

            if (selectedDate) {
                // Chuyển đổi giá trị từ input type="date" thành đối tượng Date
                const selectedDateObj = new Date(selectedDate);

                // Cập nhật ngày hiện tại
                currentDate = selectedDateObj;

                // Hiển thị lịch với ngày đã chọn
                renderCalendar(new Date(selectedDateObj));
            } else {
                alert("Vui lòng chọn một ngày hợp lệ!");
            }
        }
        window.onload = setDefaultDate;
        window.reload

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
            <label for="reason">Lý do nghỉ:</label>
            <input type="text" name="lydo" required><br><br>
            <input type="submit" name="btn" value="Gửi">
            <button type="button" onclick="closeForm()">Hủy</button>
        </form>
    </div>

    <div id="notification" style="display:none; padding: 10px; margin: 10px 0; border-radius: 5px; font-size: 14px;">
    </div>

    <?php

    // Kiểm tra ngày và ca đã đăng ký
    $successMessage = '';
    if (isset($_POST['btn'])) {
        $ngaynghi = $_POST['ngaynghi'];
        $lydo = $_POST['lydo'];
        $ca = $_POST['ca'];
        $ngaynghiphep = $p->ngaynghiphep($_SESSION['maNS']);

        // Mảng để kiểm tra ngày và ca
        $checkDangKy = [];
        foreach ($ngaynghiphep as $i) {
            $checkDangKy[$i['NgayNghiPhep']][] = $i['CaLam']; // Tổ chức ngày và danh sách ca
        }

        // Kiểm tra ngày và ca
        if (isset($checkDangKy[$ngaynghi]) && in_array($ca, $checkDangKy[$ngaynghi])) {
            $errorMessage = 'Đã xin nghỉ phép ca làm việc này !';
            if ($errorMessage) {
                echo '<div id="notificationModal" class="modal" style="display: block;">
                        <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                            <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                            <button id="closeModal" style="margin-top: 20px; padding: 10px 20px; border: none; border-radius: 5px; background-color: #F44336; color: white; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">Đóng</button>
                        </div>
                      </div>';
            }
        } else {
            if (!empty($ngaynghi) && !empty($lydo) && !empty($ca)) {
                $con = new mEmployee;
                $kq = $con->dknp($_SESSION['maNS'], $ngaynghi, $ca, $lydo);
                if ($kq) {
                    $successMessage = 'Đăng ký nghỉ phép thành công !';
                    if (isset($successMessage)) {
                        echo '<div id="notificationModal" class="modal" style="display: block;">
                                <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                                    <p style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: center;">' . $successMessage . '</p>
                                    <button id="closeModal" style="margin-top: 20px; padding: 10px 20px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">Đóng</button>
                                </div>
                              </div>';
                    }
                } else {
                    $errorMessage = 'Xin nghỉ phép thất bại !';
                    if ($errorMessage) {
                        echo '<div id="notificationModal" class="modal" style="display: block;">
                        <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                            <p style="color: #F44336; font-size: 18px; font-weight: bold; text-align: center;">' . $errorMessage . '</p>
                            <button id="closeModal" style="margin-top: 20px; padding: 10px 20px; border: none; border-radius: 5px; background-color: #F44336; color: white; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">Đóng</button>
                        </div>
                      </div>';
                    }
                }
            }

        }

    }


    ?>
</div>
<script>
    let currentDate = new Date();

    const workShifts = <?php echo json_encode($workShifts); ?>;
    const leaveDays = <?php echo json_encode($leaveDays); ?>;
    const tenphong = <?php echo json_encode($phong); ?>;
    const leaveStatus = <?php echo json_encode($leaveStatus); ?>;
    const leaveCa = <?php echo json_encode($leaveCa); ?>;
    const lyDo = <?php echo json_encode($lyDo); ?>;
    function renderCalendar(date) {
        const startOfWeek = new Date(date.setDate(date.getDate() - date.getDay() + 1));
        const endOfWeek = new Date(date.setDate(startOfWeek.getDate() + 6));
        const StartDate = new Date(<?php echo json_encode($StartDate); ?>);
        const EndDate = new Date(<?php echo json_encode($EndDate); ?>);
        let calendarHTML = '<table><tr><th>Ca làm</th>';

        for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
            // Điều chỉnh giá trị của day.getDay() sao cho Thứ Hai là 0
            const adjustedDay = (day.getDay() === 0) ? 6 : day.getDay() - 1; // Chủ Nhật = 6, Thứ Hai = 0
            calendarHTML += `<th>${day.toLocaleDateString('vi-VN', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' })}</th>`;
        }

        calendarHTML += '</tr>';

        const shiftNames = ["Sáng", "Chiều", "Tối"];
        for (let shiftIndex = 1; shiftIndex <= 3; shiftIndex++) {
            const rowCells = [];

            for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
                let note = '';
                const dayIndex = (day.getDay() === 0) ? 6 : day.getDay() - 1; // Điều chỉnh dayIndex
                const dateString = day.toLocaleDateString('vi-VN');
                let phongText = '';
                let shiftClass = ''; // Lớp CSS cho ca làm việc
                let trangthai = '';
                let shiftText = '';

                // Kiểm tra nếu ca hiện tại tồn tại trong danh sách công việc

                if (workShifts[dayIndex] !== undefined && day > StartDate) {
                    // Xác định loại ca làm việc
                    if (workShifts[dayIndex] && workShifts[dayIndex].includes(shiftIndex)) {
                        if (shiftIndex == 1) {
                            shiftText = 'Giờ : 7h-11h30';
                            phongText = `Phòng: ${tenphong}`;
                            shiftClass = 'shift-morning'; // Sáng
                        } else if (shiftIndex == 2) {
                            shiftText = 'Giờ : 13h-17h';
                            phongText = `Phòng: ${tenphong}`;
                            shiftClass = 'shift-morning'; // Chiều
                        }
                        else if (shiftIndex == 3) {
                            shiftText = 'Giờ : 18h-22h';
                            phongText = `Phòng: ${tenphong}`;
                            shiftClass = 'shift-morning'; // Tối
                        }



                        // Kiểm tra trạng thái nghỉ phép
                        // Kiểm tra trạng thái nghỉ phép
                        if (leaveDays.includes(dateString) && leaveCa[dateString] == shiftIndex) {
                            if (leaveStatus[dateString] == 0) {
                                trangthai = '<span style="color: orange;font-size:10px;">Trạng thái: chờ xét duyệt</span>';
                                shiftClass = 'shift-pending';  // Thêm lớp CSS cho trạng thái chờ xét duyệt
                            } else if (leaveStatus[dateString] == 1) {
                                trangthai = '<span style="color: green;font-size:10px;">Trạng thái: Đã xét duyệt</span>';
                                shiftClass = 'shift-approved';  // Thêm lớp CSS cho trạng thái đã xét duyệt
                            } else if (leaveStatus[dateString] == 2) {
                                trangthai = '<span style="color: red;font-size:10px;">Trạng thái: Từ chối</span>';
                                shiftClass = 'shift-rejected';  // Thêm lớp CSS cho trạng thái từ chối
                            }
                        } else {
                            // Nếu không có trạng thái nghỉ phép, giữ màu mặc định cho các ca
                            if (shiftIndex == 1) {
                                shiftClass = 'shift-morning';
                            } else if (shiftIndex == 2) {
                                shiftClass = 'shift-morning';
                            } else if (shiftIndex == 3) {
                                shiftClass = 'shift-morning';
                            }
                        }

                        // Tạo nội dung hiển thị cho ca làm việc
                        note = `<a href="#" onclick="openLeaveForm('${dateString}', '${shiftText}', ${shiftIndex})">
                            <div class="shift-box ${shiftClass}">
                                ${shiftText}
                                <div class="room-info">${phongText}</div>
                                ${trangthai}
                            </div>
                        </a>`;


                        // Tạo nội dung hiển thị cho ca làm việc
                        note = `<a href="#" onclick="openLeaveForm('${dateString}', '${shiftText}', ${shiftIndex})">
                            <div class="shift-box ${shiftClass}">
                                ${shiftText}
                                <div class="room-info">${phongText}</div>
                                ${trangthai}
                            </div>
                        </a>`;
                    } if (workShifts[dayIndex] == 0) {
                        // Ca 0 sẽ hiển thị ở cả 2 ca "Sáng" và "Chiều"

                        // Hiển thị cho 7h-11h30 (Sáng)
                        if (shiftIndex == 1) {
                            shiftText = 'Giờ: 7h-11h30';
                            phongText = `Phòng: ${tenphong}`;
                            shiftClass = 'shift-morning'; // Sáng

                            // Kiểm tra trạng thái nghỉ phép cho ca 0
                            if (leaveDays.includes(dateString) && leaveCa[dateString] == 1) {
                                if (leaveStatus[dateString] == 0) {
                                    trangthai = '<span style="color: orange;font-size:10px;">Trạng thái: chờ xét duyệt</span>';
                                    shiftClass = 'shift-pending';  // Thêm lớp CSS cho trạng thái chờ xét duyệt
                                } else if (leaveStatus[dateString] == 1) {
                                    trangthai = '<span style="color: green;font-size:10px;">Trạng thái: Đã xét duyệt</span>';
                                    shiftClass = 'shift-approved';  // Thêm lớp CSS cho trạng thái đã xét duyệt
                                } else if (leaveStatus[dateString] == 2) {
                                    trangthai = '<span style="color: red;font-size:10px;">Trạng thái: Từ chối</span>';
                                    shiftClass = 'shift-rejected';  // Thêm lớp CSS cho trạng thái từ chối
                                }
                            } else {
                                // Nếu không có trạng thái nghỉ phép, giữ màu mặc định cho các ca
                                if (shiftIndex == 1) {
                                    shiftClass = 'shift-morning';
                                } else if (shiftIndex == 2) {
                                    shiftClass = 'shift-morning';
                                } else if (shiftIndex == 3) {
                                    shiftClass = 'shift-morning';
                                }
                            }

                            // Tạo nội dung hiển thị cho ca sáng
                            note = `<a href="#" onclick="openLeaveForm('${dateString}', '${shiftText}', 1)">
                                <div class="shift-box ${shiftClass}">
                                    ${shiftText}
                                    <div class="room-info">${phongText}</div>
                                    ${trangthai}
                                </div>
                            </a>`;
                        }

                        // Hiển thị cho 13h30-17h (Chiều)
                        if (shiftIndex == 2) {
                            shiftText = 'Giờ: 13h30-17h';
                            phongText = `Phòng: ${tenphong}`;
                            shiftClass = 'shift-afternoon'; // Chiều

                            // Kiểm tra trạng thái nghỉ phép cho ca 0
                            if (leaveDays.includes(dateString) && leaveCa[dateString] == 2) {
                                if (leaveStatus[dateString] == 0) {
                                    trangthai = '<span style="color: orange;font-size:10px;">Trạng thái: chờ xét duyệt</span>';
                                    shiftClass = 'shift-pending';  // Thêm lớp CSS cho trạng thái chờ xét duyệt
                                } else if (leaveStatus[dateString] == 1) {
                                    trangthai = '<span style="color: green;font-size:10px;">Trạng thái: Đã xét duyệt</span>';
                                    shiftClass = 'shift-approved';  // Thêm lớp CSS cho trạng thái đã xét duyệt
                                } else if (leaveStatus[dateString] == 2) {
                                    trangthai = '<span style="color: red;font-size:10px;">Trạng thái: Từ chối</span>';
                                    shiftClass = 'shift-rejected';  // Thêm lớp CSS cho trạng thái từ chối
                                }
                            } else {
                                // Nếu không có trạng thái nghỉ phép, giữ màu mặc định cho các ca
                                if (shiftIndex == 1) {
                                    shiftClass = 'shift-morning';
                                } else if (shiftIndex == 2) {
                                    shiftClass = 'shift-morning';
                                } else if (shiftIndex == 3) {
                                    shiftClass = 'shift-morning';
                                }
                            }

                            // Tạo nội dung hiển thị cho ca chiều
                            note = `<a href="#" onclick="openLeaveForm('${dateString}', '${shiftText}', 2)">
                                <div class="shift-box ${shiftClass}">
                                    ${shiftText}
                                    <div class="room-info">${phongText}</div>
                                    ${trangthai}
                                </div>
                            </a>`;
                        }
                    }


                }

                // Nếu không có ca làm việc, để trống
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


    function openLeaveForm(date, shift, shiftType) {

        document.getElementById('leaveDate').value = date;
        document.getElementById('leaveShift').value = shift;
        document.getElementById('hiddenShiftType').value = shiftType;
        document.getElementById('leaveForm').style.display = 'block';
    }




    function closeForm() {
        document.getElementById('leaveForm').style.display = 'none';
    }
    //

    //

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

<?php


?>
<script>
    var modal = document.getElementById("notificationModal");
    var notificationCloseModal = document.getElementById("closeModal");

    notificationCloseModal.onclick = function () {
        window.location.href = 'http://localhost/QLBV/bacsi/index.php?page=XemLich'; // Quay lại trang khi nhấn nút Đóng
    };

</script>