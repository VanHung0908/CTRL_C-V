
<?php

session_start();
include_once('../../../model/mEmployee.php');
$con = new mEmployee();
if(isset($_POST['caID'])){
$kqq = $con->LichByCa($_POST['caID']);
$workShifts = [];
foreach ($kqq as $row) {
    $date = $row['NgayTrongTuan'];
    $shift = $row['CaTrongNgay'];

    if (!isset($workShifts[$date])) {
        $workShifts[$date] = [];
    }
    $workShifts[$date][] = ['shift' => $shift];
}
}


?>


<h5 align="center" style="color: #4682B4;margin-top:20px;"><b>LỊCH LÀM VIỆC</b></h55>
<div id="calendar" class="schedule-table"></div>
</div>
<script>
    
    let currentDate = new Date();
    const workShifts = <?php echo json_encode($workShifts); ?>;
    console.log(workShifts);
    function renderCalendar(date) {
    console.log('Rendering calendar for date:', date); // Debug thông tin ngày
    
    // Cập nhật startOfWeek và endOfWeek đúng
    const startOfWeek = new Date(date);
    startOfWeek.setDate(date.getDate() - date.getDay() + 1); // Đảm bảo bắt đầu từ Thứ 2

    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6); // Kết thúc vào Thứ 7

    let calendarHTML = '<table><tr><th>Ca làm</th>';

    for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
        const adjustedDay = (day.getDay() === 0) ? 6 : day.getDay() - 1; // Chuyển đổi ngày chủ nhật thành 6
        calendarHTML += `<th>${day.toLocaleDateString('vi-VN', { weekday: 'long' })}</th>`;
    }

    calendarHTML += '</tr>';
    const shiftNames = ["Sáng", "Chiều", "Tối"];
    for (let shiftIndex = 1; shiftIndex <= 3; shiftIndex++) {
        const rowCells = [];

        for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
            let note = '';
            const dayIndex = (day.getDay() === 0) ? 6 : day.getDay() - 1; // Điều chỉnh lại chỉ số ngày
            const dateString = day.toLocaleDateString('vi-VN');
            const shiftsForDay = workShifts[dayIndex] || [];
            let shiftText = '';

            shiftsForDay.forEach((shiftData) => {
                if (shiftData.shift == shiftIndex) {
                    shiftText = `Giờ: ${shiftIndex === 1 ? '7h-11h30' : shiftIndex === 2 ? '13h-17h' : '18h-22h'}`;
                    note = `<div class="shift-box">${shiftText}</div>`;
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

    
    #lich table{
        margin: 0 auto;
    }
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