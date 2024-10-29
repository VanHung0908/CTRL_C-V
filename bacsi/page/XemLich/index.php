    <?php
    include_once(BACKEND_URL . 'model\mEmployee.php');
    $p = new mEmployee;
    $kq = $p->selectLicTrucNV($_SESSION['dn']);
    $workShifts = [];
    foreach ($kq as $row) {
        $date = $row['Thu'];
        $shift = $row['Ca'];
        $workShifts[$date] = $shift;
    }
    $ngaynghiphep = $p->ngaynghiphep();
    $leaveDays = [];
    $leaveStatus = [];
    $leaveCa = [];
    $lyDo = [];
    foreach ($ngaynghiphep as $i) {
        $leaveDays[] = $i['NgayNghiPhep'];
        $leaveCa[$i['NgayNghiPhep']] = $i['ca'];
        $leaveStatus[$i['NgayNghiPhep']] = $i['TrangThai'];
        $lyDo[$i['NgayNghiPhep']] = $i['LyDo_TuChoi'];
    }

    $pp = $p->selectDateStartEnd($_SESSION['dn']);
    foreach ($pp as $i) {
        $StartDate = $i['NgayBatDau'];
        $EndDate = $i['NgayKetThuc'];
    }
    ?>
<div class="main-content" id="main-content">
    <h1>Lịch Tuần</h1>
    <span id="weekNumber">Tuần: </span>
    <div class="btn-group">
        <button onclick="previousWeek()" class="btn btn-outline-secondary">Tuần Trước</button>
        <button onclick="nextWeek()" class="btn btn-outline-secondary">Tuần Kế Tiếp</button>
        <button onclick="currentWeek()" class="btn btn-outline-secondary">Tuần Hiện Tại</button>
    </div>
   
    <div id="calendar" class="schedule-table"></div>

    <div id="leaveForm" style="display: none; margin: 0 auto; width: 300px; padding: 20px; border: 2px solid #000; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); margin-top: 20px;" align="center">
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

    <?php
    if (isset($_POST['btn'])) {
        $ngaynghi = $_POST['ngaynghi'];
        $lydo = $_POST['lydo'];
        $ca = $_POST['ca'];
        $ngaynghiphep = $p->ngaynghiphep();
        $checkngaydaxinnghi = [];
        foreach ($ngaynghiphep as $i) {
            $checkngaydaxinnghi[] = $i['NgayNghiPhep'];
        }
        $checkngaydangky = in_array($ngaynghi, $checkngaydaxinnghi);
        if ($checkngaydangky) {
            echo '<script>alert("Bạn đã xin nghỉ phép ngày này rồi. Vui lòng chọn ngày khác!")</script>';
        } else {
            if (!empty($ngaynghi) && !empty($lydo) && !empty($ca)) {
                $con = new mEmployee;
                $kq = $con->dknp($_SESSION['dn'], $ngaynghi, $ca, $lydo);
                if ($kq) {
                    echo '<script>alert("Đăng ký nghỉ phép thành công!")</script>';
                } else {
                    echo '<script>alert("Đăng ký nghỉ phép thất bại!")</script>';
                }
            } else {
                echo '<script>alert("Vui lòng điền đầy đủ thông tin!")</script>';
            }
        }
    }
    ?>

    <script>
        let currentDate = new Date();

        const workShifts = <?php echo json_encode($workShifts); ?>;
        const leaveDays = <?php echo json_encode($leaveDays); ?>;
        const leaveStatus = <?php echo json_encode($leaveStatus); ?>;
        const leaveCa = <?php echo json_encode($leaveCa); ?>;
        const lyDo = <?php echo json_encode($lyDo); ?>;
        const StartDate = new Date(<?php echo json_encode($StartDate); ?>);
        const EndDate = new Date(<?php echo json_encode($EndDate); ?>);

        function renderCalendar(date) {
            const startOfWeek = new Date(date.setDate(date.getDate() - date.getDay() + 1));
            const endOfWeek = new Date(date.setDate(startOfWeek.getDate() + 6));
            let calendarHTML = '<table><tr><th>Ca làm</th>';


            for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
                calendarHTML += `<th>${day.toLocaleDateString('vi-VN', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' })}</th>`;
            }

            calendarHTML += '</tr><tr>';


            const shiftNames = ["Sáng", "Chiều", "Tối"];
            for (let shiftIndex = 1; shiftIndex <= 3; shiftIndex++) {

                const rowCells = [];

                for (let day = new Date(startOfWeek); day <= endOfWeek; day.setDate(day.getDate() + 1)) {
                    let note = '';
                    const dayIndex = day.getDay();
                    const dateString = day.toLocaleDateString('vi-VN');
                    let shiftText = '';

                    if (day > StartDate && day < EndDate) {
                        if (workShifts[dayIndex] !== undefined) {

                            if (workShifts[dayIndex] == 1 && shiftIndex == 1) {
                                shiftText = 'Giờ : 7h-11h30';
                            } else if (workShifts[dayIndex] == 2 && shiftIndex == 2) {
                                shiftText = 'Giờ : 13h30-17h30';
                            } else if (workShifts[dayIndex] == 3 && shiftIndex == 3) {
                                shiftText = 'Giờ : 18h - 22h ';
                            }


                            if (shiftText) {
                                note = `<br><a href="#" onclick="openLeaveForm('${dateString}', '${shiftText}', ${workShifts[dayIndex]})"><span style="color: blue;">${shiftText}</span></a>`;
                            }
                        }
                    }

                    if (leaveDays.includes(dateString) && leaveCa[dateString] == shiftIndex) {
                        if (leaveStatus[dateString] == 0) {
                            note += `<br><span style="color: orange;">Trạng thái: chờ xét duyệt</span>`;
                        } else if (leaveStatus[dateString] == 1) {
                            note += `<br><span style="color: green;">Trạng thái: đã duyệt</span>`;
                        } else if (leaveStatus[dateString] == 2) {
                            note += `<br><span style="color: red;">Trạng thái: Từ chối duyệt</span>`;
                            if (lyDo[dateString]) {
                                note += `<br><span style="color: red;">Lý do từ chối: ${lyDo[dateString]}</span>`;
                            }
                        }
                    }

                    if (note.trim() !== '') {
                        rowCells.push(`<div class="shift-box">${note}</div>`);
                    } else {
                        rowCells.push('');
                    }
                }

                calendarHTML += `<tr><td>${shiftNames[shiftIndex - 1]}</td>`;
                rowCells.forEach(cell => {
                    if (cell) {
                        calendarHTML += `<td>${cell}</td>`;
                    } else {
                        calendarHTML += `<td></td>`;
                    }
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
