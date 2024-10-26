
<div class="main-content" id="main-content">
<div class="actions">
        <h2>Danh sách nhân sự</h2>
        <div class="search-container">
            <div class="input-container">
                <input type="text" id="search-input" placeholder="Nhập mã, tên nhân viên" class="search-input">
                <span class="search-icon">&#128269;</span> <!-- Biểu tượng tìm kiếm -->
            </div>
            <button class="add-btn">Thêm Nhân Viên</button>
        </div>
    </div>


        <table class="employee-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Chức vụ</th>
                    <th>Bộ phận</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày vào làm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="employee-table-body">
                <tr>
                    <td>1</td>
                    <td>Lâm Văn Hưng</td>
                    <td>Quản lý</td>
                    <td>Kinh Doanh</td>
                    <td>nva@example.com</td>
                    <td>0123456789</td>
                    <td>01/01/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nguyễn Tấn Đạt</td>
                    <td>Quản lý nội trú</td>
                    <td>Marketing</td>
                    <td>ttb@example.com</td>
                    <td>0987654321</td>
                    <td>02/02/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Nguyễn Tấn Đạt</td>
                    <td>Quản lý ngoại trú</td>
                    <td>IT</td>
                    <td>lvc@example.com</td>
                    <td>0123987654</td>
                    <td>03/03/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Đoàn Thị Mai Linh</td>
                    <td>Nhân viên </td>
                    <td>IT</td>
                    <td>lvc@example.com</td>
                    <td>0123987654</td>
                    <td>03/03/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Châu Duy Khánh</td>
                    <td>Nhân Viên</td>
                    <td>IT</td>
                    <td>lvc@example.com</td>
                    <td>0123987654</td>
                    <td>03/03/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Trần Hoàng Gia Khánh</td>
                    <td>Nhân Viên</td>
                    <td>IT</td>
                    <td>lvc@example.com</td>
                    <td>0123987654</td>
                    <td>03/03/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Lê Văn Việt</td>
                    <td>Nhân Viên</td>
                    <td>IT</td>
                    <td>lvc@example.com</td>
                    <td>0123987654</td>
                    <td>03/03/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Lê Văn Sỹ</td>
                    <td>Nhân Viên</td>
                    <td>IT</td>
                    <td>lvs@example.com</td>
                    <td>0123987654</td>
                    <td>03/03/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>

                <!-- Thêm các nhân viên khác ở đây -->
            </tbody>
            
        </table>

        <div class="pagination" id="pagination">
            <!-- Nút chuyển trang sẽ được tạo động -->
        </div>
    </div>

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
    </script>
