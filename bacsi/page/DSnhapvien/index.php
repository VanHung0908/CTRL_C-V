<?php
ob_start(); 

include_once(BACKEND_URL . 'model/mBenhNhan.php');

// Tạo đối tượng từ lớp mBenhNhan
$con = new mBenhNhan(); 

// Lấy giá trị MaCV và MaNS từ session
$MaCV = $_SESSION['maCV'];
$MaNS = $_SESSION['maNS'];

// Lấy danh sách bệnh nhân và truyền các giá trị session vào phương thức
$dsBenhNhan = $con->dsBenhNhanNTRu($MaCV, $MaNS);

// Hiển thị danh sách bệnh nhân trong bảng
?>


<div class="main-content" id="main-content">
    <div class="actions">
        <h3>Danh sách bệnh nhân</h3>
        <div class="search-container">
            <div class="input-container">
                <input type="text" id="search-input" placeholder="Nhập mã, tên bệnh nhân" class="search-input">
                <span class="search-icon">&#128269;</span>
            </div>
        </div>

    </div>
    <table class="employee-table">
        <thead>
            <tr>
            <th>STT</th>
                <th>Họ và tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Tên phòng</th>
                <th>Tên giường</th>
                <th>Thời gian nhập viện</th>
                <th>Bác sĩ điều trị</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody id="employee-table-body">
    <?php
    // Duyệt qua danh sách bệnh nhân và hiển thị từng dòng
    $stt = 1;
    foreach ($dsBenhNhan as $benhNhan) {
        echo "<tr>";
        echo "<td>" . $stt++ . "</td>";
        echo "<td>" . $benhNhan['HoTen'] . "</td>";
        echo "<td>" . $benhNhan['NgaySinh'] . "</td>";
        echo "<td>" . $benhNhan['GioiTinh'] . "</td>";
        echo "<td>" . $benhNhan['TenPhong'] . "</td>";
        echo "<td>" . $benhNhan['TenGiuong'] . "</td>";
        echo "<td>" . $benhNhan['ThoiGianNV'] . "</td>";
        echo "<td>" . $benhNhan['TenNhanSu'] . "</td>";
        echo "<td>" . $benhNhan['TrangThai'] . "</td>";
        echo "<td>
                <div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle' type='button' id='actionMenu1' data-bs-toggle='dropdown' aria-expanded='false'>
                        <i class='fas fa-tasks'></i> Thao tác
                    </button>
                    <ul class='dropdown-menu' aria-labelledby='actionMenu1'>
                        <li><a class='dropdown-item' href='index.php?page=xemchitiet&MaBN=" . $benhNhan['MaBN'] . "'>Xem chi tiết</a></li>
                        <li><a class='dropdown-item' href='index.php?page=capnhatthongtinNV&MaBN=" . $benhNhan['MaBN'] . "'>Cập nhật thông tin</a></li>
                    </ul>
                </div>
            </td>";
        echo "</tr>";
    }
    ?>
</tbody>

    </table>

    <div class="pagination" id="pagination">
    </div>
</div>

<?php
ob_end_flush(); 
?>
 <script>
        const rowsPerPage = 7;
        let currentPage = 1;

        function displayPage(page) {
            const rows = document.querySelectorAll("#employee-table-body tr");
            const totalRows = rows.length;
            const pageCount = Math.ceil(totalRows / rowsPerPage);
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = index >= start && index < end ? "" : "none";
            });

            setupPagination(pageCount);
        }

        function setupPagination(pageCount) {
            const pagination = document.getElementById("pagination");
            pagination.innerHTML = "";

            const prevBtn = document.createElement("button");
            prevBtn.innerText = "<<";
            prevBtn.classList.add("page-btn");
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener("click", function () {
                currentPage--;
                displayPage(currentPage);
            });
            pagination.appendChild(prevBtn);

            for (let i = 1; i <= pageCount; i++) {
                const btn = document.createElement("button");
                btn.classList.add("page-btn");
                if (i === currentPage) btn.classList.add("active");
                btn.innerText = i;

                btn.addEventListener("click", function () {
                    currentPage = i;
                    displayPage(currentPage);
                });

                pagination.appendChild(btn);
            }

            const nextBtn = document.createElement("button");
            nextBtn.innerText = ">>";
            nextBtn.classList.add("page-btn");
            nextBtn.disabled = currentPage === pageCount;
            nextBtn.addEventListener("click", function () {
                currentPage++;
                displayPage(currentPage);
            });
            pagination.appendChild(nextBtn);
        }

        displayPage(currentPage);
    document.getElementById("search-input").addEventListener("input", function () {
        const query = this.value.toLowerCase();
        filterPatients(query);
    });

    function filterPatients(query) {
        const rows = document.querySelectorAll("#employee-table-body tr");
        rows.forEach((row) => {
            const patientName = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
            if (patientName.includes(query)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    document.getElementById("search-input").addEventListener("input", function () {
        const query = this.value;
        fetchPatients(query);
    });

    function fetchPatients(query) {
        fetch("path/to/your/php/script.php", {
            method: "POST",
            body: JSON.stringify({ searchTerm: query }),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            displayPatients(data);  // Hiển thị lại bệnh nhân sau khi lọc
        });
    }

function displayPatients(patients) {
    const tableBody = document.getElementById("employee-table-body");
    tableBody.innerHTML = "";  // Xóa dữ liệu cũ

    patients.forEach((patient, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${patient.HoTen}</td>
            <td>${patient.NgaySinh}</td>
            <td>${patient.GioiTinh}</td>
            <td>${patient.DiaChi}</td>
            <td>${patient.SDT}</td>
            <td>${patient.TrangThai}</td>
            <td>
                <div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle' type='button' id='actionMenu1' data-bs-toggle='dropdown' aria-expanded='false'>
                        <i class='fas fa-tasks'></i> Thao tác
                    </button>
                    <ul class='dropdown-menu' aria-labelledby='actionMenu1'>
                        <li><a class='dropdown-item' href='index.php?page=xemchitiet&MaBN=${patient.MaBN}'>Xem chi tiết</a></li>
                        <li><a class='dropdown-item' href='index.php?page=capnhatthongtinNV&MaBN=${patient.MaBN}'>Cập nhật thông tin</a></li>
                    </ul>
                </div>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

    </script>
