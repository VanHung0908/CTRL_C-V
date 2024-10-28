        <div class="main-content" id="main-content">
        <div class="actions">
            <h3>Danh sách nhân sự</h3>
            <div class="search-container">
                <div class="input-container">
                    <input type="text" id="search-input" placeholder="Nhập mã, tên nhân viên" class="search-input">
                    <span class="search-icon">&#128269;</span>
                </div>
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Thêm Nhân Viên</button>
            </div>
        </div>
        <table class="employee-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Chức vụ</th>
                    <th>Khoa</th>
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
                    <td>Quản lý nội trú</td>
                    <td>Khoa Nội</td>
                    <td>LVH@example.com</td>
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
                    <td>Quản lý ngoại trú</td>
                    <td>Khoa Ngoại</td>
                    <td>NTD@example.com</td>
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
                    <td>Nhân viên quản lý nội trú</td>
                    <td>Khoa Nội</td>
                    <td>NTAn@example.com</td>
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
                    <td>Bác sĩ nội trú</td>
                    <td>Khoa Nội</td>
                    <td>DTML@example.com</td>
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
                    <td>Điều dưỡng</td>
                    <td>Khoa Nội</td>
                    <td>CDK@example.com</td>
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
                    <td>Bác sĩ ngoại trú</td>
                    <td>Khoa Ngoại</td>
                    <td>THGK@example.com</td>
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
                    <td>Nhân viên quản lý ngoại trú</td>
                    <td>Khoa Ngoại</td>
                    <td>lvV@example.com</td>
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
                    <td>Admin</td>
                    <td>Khoa Hành Chính</td>
                    <td>lvs@example.com</td>
                    <td>0123987654</td>
                    <td>03/03/2022</td>
                    <td>
                        <button class="icon-btn edit-btn"><i class="fas fa-edit"></i></button>
                        <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>

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
<!-- Modal Thêm Nhân Sự -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Thêm Nhân Viên Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthDate" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="birthDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select class="form-select" id="gender" required>
                            <option value="" disabled selected>Chọn giới tính</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Địa chỉ email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ thường trú</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="idCard" class="form-label">Số căn cước công dân</label>
                        <input type="text" class="form-control" id="idCard" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Chức vụ</label>
                        <input type="text" class="form-control" id="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="profilePicture" class="form-label">Ảnh chân dung</label>
                        <input type="file" class="form-control" id="profilePicture" accept="image/*" required>
                    </div>
                   
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="startDate" required>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="saveEmployeeBtn">Lưu </button>
            </div>
        </div>
    </div>
</div>
