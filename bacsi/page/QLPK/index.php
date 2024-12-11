
<div class="main-content" id="main-content">
        <div class="header-date">
            <div class="btn-group">
                <button class="btn btn-outline-secondary" onclick="currentWeek()">Hiện tại</button>
                <button class="btn btn-outline-secondary" onclick="goToLastWeek()">Trở về</button>
                <button class="btn btn-outline-secondary" onclick="nextWeek()">Tiếp</button>
            </div>
            <div class="date-picker">
                <input type="date" id="datePicker" value="" onchange="updateSchedule()">
                <select id="clinicSelect" class="" onchange="updateSchedule()">
                    <option value="clinic1">Phòng Khám A</option>
                    <option value="clinic2">Phòng Khám B</option>
                    <option value="clinic3">Phòng Khám C</option>
                </select>
            </div>
        </div>
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Ca Làm</th>
                    <th id="day1">Thứ 2</th>
                    <th id="day2">Thứ 3</th>
                    <th id="day3">Thứ 4</th>
                    <th id="day4">Thứ 5</th>
                    <th id="day5">Thứ 6</th>
                    <th id="day6">Thứ 7</th>
                    <th id="day7">Chủ nhật</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="morning">Sáng</td>
                    <td id="morning1"></td>
                    <td id="morning2"></td>
                    <td id="morning3"></td>
                    <td id="morning4"></td>
                    <td id="morning5"></td>
                    <td id="morning6"></td>
                    <td id="morning7"></td>
                </tr>
                <tr>
                    <td class="afternoon">Chiều</td>
                    <td id="afternoon1"></td>
                    <td id="afternoon2"></td>
                    <td id="afternoon3"></td>
                    <td id="afternoon4"></td>
                    <td id="afternoon5"></td>
                    <td id="afternoon6"></td>
                    <td id="afternoon7"></td>
                </tr>
                <tr>
                    <td class="night">Tối</td>
                    <td id="night1"></td>
                    <td id="night2"></td>
                    <td id="night3"></td>
                    <td id="night4"></td>
                    <td id="night5"></td>
                    <td id="night6"></td>
                    <td id="night7"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        let currentDate = new Date();

        // Cập nhật giá trị của datePicker khi tải trang
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            document.getElementById("datePicker").value = today.toISOString().split('T')[0];
            renderSchedule('clinic1'); // Khởi tạo lịch
        });

        function updateSchedule() {
            const clinic = document.getElementById("clinicSelect").value;
            const datePicker = document.getElementById("datePicker").value;
            if (datePicker) {
                currentDate = new Date(datePicker);
            }
            renderSchedule(clinic);
        }

        function renderSchedule(clinic) {
            const days = [
                new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 1)), // Monday
                new Date(currentDate.setDate(currentDate.getDate() + 1)), // Tuesday
                new Date(currentDate.setDate(currentDate.getDate() + 1)), // Wednesday
                new Date(currentDate.setDate(currentDate.getDate() + 1)), // Thursday
                new Date(currentDate.setDate(currentDate.getDate() + 1)), // Friday
                new Date(currentDate.setDate(currentDate.getDate() + 1)), // Saturday
                new Date(currentDate.setDate(currentDate.getDate() + 1)), // Sunday
            ];

            // Cập nhật tiêu đề cho các ngày
            days.forEach((day, index) => {
                const dayCell = document.getElementById(`day${index + 1}`);
                dayCell.innerText = `${day.toLocaleDateString('vi-VN', { weekday: 'long' })}\n${day.getDate()}/${day.getMonth() + 1}/${day.getFullYear()}`;
            });

            // Dữ liệu lịch cho từng phòng khám (tùy chỉnh theo yêu cầu của bạn)
            const scheduleData = {
                clinic1: {
                    morning: ["", "", "Lâm Văn Hưng", "", "Nguyễn Tấn Đạt", "", ""],
                    afternoon: ["", "", "", "", "Lâm Văn Hưng", "", ""]
                },
                clinic2: {
                    morning: ["Đoàn Thị Mai Linh", "", "", "Nguyễn Tấn Đạt", "", "", ""],
                    afternoon: ["", "", "", "", "", "Nguyễn Tấn Đạt", ""]
                },
                clinic3: {
                    morning: ["", "", "", "", "", "", "Châu Duy Khánh"],
                    afternoon: ["Châu Duy Khánh", "", "", "", "", "", ""]
                }
            };

            // Làm sạch lịch
            for (let i = 1; i <= 7; i++) {
                const morningCell = document.getElementById(`morning${i}`);
                const afternoonCell = document.getElementById(`afternoon${i}`);
                
                // Thêm dropdown cho các ô trống
                morningCell.innerHTML = scheduleData[clinic].morning[i - 1] 
                    ? `<div class='event'>${scheduleData[clinic].morning[i - 1]} <span class='QLPK-btn' onclick='removeEvent(this)'>🗑️</span></div>` 
                    : `<select class='select-doctor' onchange='selectDoctor("morning", ${i}, this)'><option value=''>Chọn bác sĩ</option><option value='Lâm Văn Hưng'>Lâm Văn Hưng</option><option value='Nguyễn Tấn Đạt'>Nguyễn Tấn Đạt</option><option value='Đoàn Thị Mai Linh'>Đoàn Thị Mai Linh</option><option value='Châu Duy Khánh'>Châu Duy Khánh</option></select>`;
                
                afternoonCell.innerHTML = scheduleData[clinic].afternoon[i - 1] 
                    ? `<div class='event'>${scheduleData[clinic].afternoon[i - 1]} <span class='QLPK-btn' onclick='removeEvent(this)'>🗑️</span></div>` 
                    : `<select class='select-doctor' onchange='selectDoctor("afternoon", ${i}, this)'><option value=''>Chọn bác sĩ</option><option value='Lâm Văn Hưng'>Lâm Văn Hưng</option><option value='Nguyễn Tấn Đạt'>Nguyễn Tấn Đạt</option><option value='Đoàn Thị Mai Linh'>Đoàn Thị Mai Linh</option><option value='Châu Duy Khánh'>Châu Duy Khánh</option></select>`;
            }
        }

        function selectDoctor(shift, day, select) {
            const doctorName = select.value;
            const cell = document.getElementById(`${shift}${day}`);
            cell.innerHTML = `<div class='event'>${doctorName} <span class='QLPK-btn' onclick='removeEvent(this)'>🗑️</span></div>`;
        }

        function removeEvent(element) {
            const cell = element.parentElement.parentElement;
            cell.innerHTML = `<select class='select-doctor' onchange='selectDoctor("${cell.id.slice(0, cell.id.length - 1)}", ${cell.id.slice(-1)}, this)'><option value=''>Chọn bác sĩ</option><option value='Lâm Văn Hưng'>Lâm Văn Hưng</option><option value='Nguyễn Tấn Đạt'>Nguyễn Tấn Đạt</option><option value='Đoàn Thị Mai Linh'>Đoàn Thị Mai Linh</option><option value='Châu Duy Khánh'>Châu Duy Khánh</option></select>`;
        }

        function currentWeek() {
            const today = new Date();
            document.getElementById("datePicker").value = today.toISOString().split('T')[0];
            currentDate = today;
            updateSchedule();
        }
        function goToLastWeek() {
            currentDate.setDate(currentDate.getDate() - 8);
            document.getElementById("datePicker").value = currentDate.toISOString().split('T')[0];
            renderSchedule('clinic1');
        }

        function nextWeek() {
            currentDate.setDate(currentDate.getDate() + 7);
            document.getElementById("datePicker").value = currentDate.toISOString().split('T')[0];
            renderSchedule('clinic1');
        }
    </script>
