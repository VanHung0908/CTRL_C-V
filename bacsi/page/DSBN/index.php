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
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="employee-table-body">
                <tr>
                    <td>1</td>
                    <td>Lâm Văn Hưng</td>
                    <td>09/08/2003</td>
                    <td>Nam</td>
                    <td>TP. Hồ Chí Minh</td>
                    <td>0123456789</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tasks"></i> Thao tác
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionMenu1">
                                <li><a class="dropdown-item" href="index.php?page=xemchitiet">Xem chi tiết</a></li>
                                <li><a class="dropdown-item" href="index.php?page=lapphieukham">Lập phiếu khám</a></li>
                                <li><a class="dropdown-item" href="index.php?page=nhapvien">Nhập viện</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nguyễn Tấn Đạt</td>
                    <td>09/08/2003</td>
                    <td>Nam</td>
                    <td>Hồ Chí Minh</td>
                    <td>0987654321</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tasks"></i> Thao tác
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionMenu2">
                                <li><a class="dropdown-item" href="index.php?page=xemchitiet">Xem chi tiết</a></li>
                                <li><a class="dropdown-item" href="index.php?page=lapphieukham">Lập phiếu khám</a></li>
                                <li><a class="dropdown-item" href="index.php?page=nhapvien">Nhập viện</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
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
