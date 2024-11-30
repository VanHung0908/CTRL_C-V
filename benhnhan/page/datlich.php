<?php 
include_once '../layout/header.php';
include_once(BACKEND_URL . 'model/mKhoa.php');
$model = new mKhoa();

$departments = $model->getAllDepartments();
 ?>

<!-- Header -->
<div class="section-2-1-1">
    <div class="inner-wrap wow fadeInRight">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-6">
                    <!-- Lịch -->
                    <div class="calendar-container bg-white p-4 rounded shadow-sml" id="calendarContainer">
                        <h2>Chọn Ngày</h2>
                        <div class="lich">
                            <button id="prevMonth">&#8249;</button>
                            <div id="monthYear"></div>
                            <button id="nextMonth">&#8250;</button>
                        </div>
                        <div class="days">
                            <div class="day">CN</div>
                            <div class="day">T2</div>
                            <div class="day">T3</div>
                            <div class="day">T4</div>
                            <div class="day">T5</div>
                            <div class="day">T6</div>
                            <div class="day">T7</div>
                        </div>
                        <div id="dates" class="dates"></div>
                        <div id="selectedDate" class="selected-date"></div>
                    </div>

                    <!-- Form chọn giờ -->
                    <div class="time-selection bg-white p-4 rounded shadow-sml" id="timeSelection" style="display: none;">
                        <div class="info-title"><h2>Chọn Giờ</h2></div>
                        <hr class="divider">
                        <div class="morning">
                            <h4>Buổi Sáng</h4>
                            <div class="time-buttons" id="morningTimes"></div>
                        </div>
                        <div class="afternoon mt-3">
                            <h4>Buổi Chiều</h4>
                            <div class="time-buttons" id="afternoonTimes"></div>
                        </div>
                        <button id="backToCalendar" class="btn btn-secondary mt-3">Quay lại chọn ngày</button>
                    </div>

                    <!-- Chọn khoa khám -->
                    <div class="department-selection bg-white p-4 rounded shadow-sml" id="departmentSelection"  style="display: none;">
                        <h4>Chọn Khoa Khám</h4>
                        <hr class="divider">
                        <?php foreach ($departments as $department): ?>
                            <button 
                                class="btn btn-outline-primary m-1" 
                                onclick="selectDepartment('<?php echo htmlspecialchars($department); ?>', selectedDate.day, selectedDate.month, selectedDate.year)">
                                <?php echo htmlspecialchars($department); ?>
                            </button>
                        <?php endforeach; ?>

                        <br><button id="backTogio" class="btn btn-secondary mt-3">Quay lại chọn giờ</button>
                    </div>

                    <!-- Chọn bác sĩ -->
                    <div class="doctor-selection bg-white p-4 rounded shadow-sml" id="doctorSelection" style="display: none;">
                        <h4>Chọn Bác Sĩ</h4>
                        <hr class="divider">
                        <div id="doctorList"></div> <!-- Danh sách bác sĩ sẽ được thêm vào đây -->
                        <br><button id="backTokhoa" class="btn btn-secondary mt-3" onclick="goBackToDepartment()">Quay lại chọn khoa</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Thông tin đặt lịch -->
                    <div class="booking-info bg-white p-4 rounded shadow-sml">
                        <div class="info-title"><b>Thông tin đặt khám</b></div>
                        <hr class="divider">
                        <div class="info-details" id="infoDetails">
                            <p>Ngày đã chọn: <span id="infoDate">Chưa chọn ngày</span></p>
                            <p>Giờ đặt khám: <span id="infoTime">Chưa chọn giờ</span></p>
                            <p>Khoa khám: <span id="infoDepartment">Chưa chọn khoa</span></p>
                            <p>Bác sĩ: <span id="infoDoctor">Chưa chọn bác sĩ</span></p>
                        </div>
                        <button id="confirmButton" class="btn btn-primary mt-3" style="display: none;" onclick="confirmBooking()">Thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const monthYearElement = document.getElementById('monthYear');
    const datesElement = document.getElementById('dates');
    const selectedDateElement = document.getElementById('selectedDate');
    const infoDateElement = document.getElementById('infoDate');
    const infoTimeElement = document.getElementById('infoTime');
    const infoDepartmentElement = document.getElementById('infoDepartment');
    const infoDoctorElement = document.getElementById('infoDoctor');
    const timeSelectionElement = document.getElementById('timeSelection');
    const calendarContainer = document.getElementById('calendarContainer');
    const departmentSelectionElement = document.getElementById('departmentSelection');
    const doctorSelectionElement = document.getElementById('doctorSelection');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');
    const backToCalendarButton = document.getElementById('backToCalendar');
    const backTogioButton = document.getElementById('backTogio');
    const backTokhoaButton = document.getElementById('backTokhoa');

    let currentDate = new Date();
    let selectedTime = '';
    let selectedDepartment = '';
    let selectedDoctor = '';

    function renderCalendar() {
        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();
        monthYearElement.innerText = `${getMonthName(month)} ${year}`;

        const firstDay = new Date(year, month, 1);
        const lastDate = new Date(year, month + 1, 0).getDate();
        const startingDay = firstDay.getDay();

        const today = new Date();
        datesElement.innerHTML = '';

        // Thêm các ô trống cho những ngày trước của tháng
        for (let i = 0; i < startingDay; i++) {
            datesElement.innerHTML += `<div class="date"></div>`;
        }

        // Thêm các ngày trong tháng
        for (let date = 1; date <= lastDate; date++) {
            const isToday = date === today.getDate() && month === today.getMonth() && year === today.getFullYear();
            const className = isToday ? 'date today' : 'date';
            datesElement.innerHTML += `<div class="${className}" onclick="selectDate(${date})">${date}</div>`;
        }

        // Thêm các ô trống cho những ngày sau của tháng
        const endDay = new Date(year, month + 1, 0).getDay();
        for (let i = endDay + 1; i < 7; i++) {
            datesElement.innerHTML += `<div class="date"></div>`;
        }
    }

    function getMonthName(month) {
        const months = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", 
                        "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
        return months[month];
    }

    let selectedDate = {
    day: null,
    month: null,
    year: null
};

function selectDate(date) {
    const month = currentDate.getMonth() + 1;
    const year = currentDate.getFullYear();
    const selectedDateObject = new Date(year, month - 1, date);
    const today = new Date();

    if (selectedDateObject <= today) {
        Swal.fire({
            icon: "error",
            title: "Thất bại",
            text: "Ngày đặt lịch phải sau ngày hiện tại!",
            confirmButtonText: "Thử lại"
        });
        return;
    }

    const dayOfWeek = selectedDateObject.getDay();
    if (dayOfWeek === 0 || dayOfWeek === 6) {
        Swal.fire({
            icon: "error",
            title: "Thất bại",
            text: "Không thể chọn ngày thứ Bảy hoặc Chủ Nhật!",
            confirmButtonText: "Thử lại"
        });
        return;
    }

    // Lưu ngày đã chọn vào biến selectedDate
    selectedDate.day = date;
    selectedDate.month = month;
    selectedDate.year = year;

    selectedDateElement.innerText = `Ngày đã chọn: ${date}/${month}/${year}`;
    infoDateElement.innerText = `${date}/${month}/${year}`;

    calendarContainer.style.display = 'none';
    timeSelectionElement.style.display = 'block';
    renderTimeButtons();
}


    function renderTimeButtons() {
        const morningTimes = document.getElementById('morningTimes');
        const afternoonTimes = document.getElementById('afternoonTimes');

        morningTimes.innerHTML = '';
        afternoonTimes.innerHTML = '';

        for (let i = 8; i < 11; i++) {
            morningTimes.innerHTML += `<button class="btn btn-outline-secondary m-1" onclick="selectTime('${i}:00')">${i}:00</button>`;
            morningTimes.innerHTML += `<button class="btn btn-outline-secondary m-1" onclick="selectTime('${i}:30')">${i}:30</button>`;
        }

        for (let i = 13; i < 17; i++) {
            afternoonTimes.innerHTML += `<button class="btn btn-outline-secondary m-1" onclick="selectTime('${i}:00')">${i}:00</button>`;
            afternoonTimes.innerHTML += `<button class="btn btn-outline-secondary m-1" onclick="selectTime('${i}:30')">${i}:30</button>`;
        }
    }

    function selectTime(time) {
        selectedTime = time;
        infoTimeElement.innerText = ` ${time}`;

        timeSelectionElement.style.display = 'none';
        departmentSelectionElement.style.display = 'block';
    }
    function selectDepartment(tenKhoa, day, month, year) {
    selectedDepartment = tenKhoa;
    document.getElementById('infoDepartment').innerText = `${tenKhoa}`;
    console.log("Dữ liệu gửi đi:", {
    tenKhoa: tenKhoa,
    date: day,
    month: month,
    year: year,
    time: selectedTime
});
   fetch('../../ajax/DSBS.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `tenKhoa=${encodeURIComponent(tenKhoa)}&date=${encodeURIComponent(day)}&month=${encodeURIComponent(month)}&year=${encodeURIComponent(year)}&time=${encodeURIComponent(selectedTime)}`
})
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
})
.then(data => {
    departmentSelectionElement.style.display = 'none';
    doctorSelectionElement.style.display = 'block';

    const doctorList = document.getElementById('doctorList');
    doctorList.innerHTML = '';

    // Kiểm tra dữ liệu trả về có đúng cấu trúc không
    if (data && Array.isArray(data.doctors) && data.doctors.length > 0) {
        // Duyệt qua danh sách bác sĩ và tạo các button
        data.doctors.forEach(doctor => {
            const button = document.createElement('button');
            button.className = 'btn btn-outline-primary m-1';
            button.textContent = doctor;
            button.onclick = () => selectDoctor(doctor);
            doctorList.appendChild(button);
        });
    } else {
        const noDoctorMessage = document.createElement('p');
        noDoctorMessage.textContent = 'Không có bác sĩ nào trong khoa này.';
        doctorList.appendChild(noDoctorMessage);
    }
})
.catch(error => console.error('Error:', error));
    }

    function selectDoctor(doctorName) {
        selectedDoctor = doctorName;
        document.getElementById('infoDoctor').innerText = ` ${doctorName}`;

        // Hiển thị nút xác nhận
        document.getElementById('confirmButton').style.display = 'block';
    }

        function confirmBooking() {
        const amount = 100000; // Số tiền thanh toán
        const orderInfo = 'Thanh toán chi phí khám'; // Thông tin đơn hàng

        // Lấy các giá trị từ thông tin đặt lịch
        const selectedDate = document.getElementById("infoDate").textContent;
        const selectedTime = document.getElementById("infoTime").textContent;
        const department = document.getElementById("infoDepartment").textContent;
        const doctor = document.getElementById("infoDoctor").textContent;

        // Kiểm tra giá trị trước khi gửi
        console.log("Ngày:", selectedDate);
        console.log("Giờ:", selectedTime);
        console.log("Khoa:", department);
        console.log("Bác sĩ:", doctor);

        // Tạo đối tượng URLSearchParams để gửi tham số
        const data = new URLSearchParams();
        data.append('amount', amount);
        data.append('orderInfo', orderInfo);
        data.append('selectedDate', selectedDate);
        data.append('selectedTime', selectedTime);
        data.append('department', department);
        data.append('doctor', doctor);

        fetch('../../vnpay/create-payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: data.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Nếu yêu cầu thanh toán thành công, chuyển hướng đến VNPay
                window.location.href = data.paymentUrl;
            } else {
                alert('Có lỗi xảy ra trong quá trình tạo yêu cầu thanh toán.');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra, vui lòng thử lại.');
        });
    }


    // Chuyển tháng trước
    prevMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    // Chuyển tháng sau
    nextMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Quay lại chọn ngày
    backToCalendarButton.addEventListener('click', () => {
        timeSelectionElement.style.display = 'none';
        departmentSelectionElement.style.display = 'none';
        doctorSelectionElement.style.display = 'none';
        calendarContainer.style.display = 'block';
    });

    // Quay lại chọn giờ
    backTogioButton.addEventListener('click', () => {
        departmentSelectionElement.style.display = 'none';
        timeSelectionElement.style.display = 'block';
    });

    // Quay lại chọn khoa
    backTokhoaButton.addEventListener('click', () => {
        doctorSelectionElement.style.display = 'none';
        departmentSelectionElement.style.display = 'block';
    });


    // Khởi tạo lịch
    renderCalendar();
</script>

<?php include_once '../layout/footer.php' ?>
