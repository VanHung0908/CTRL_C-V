<?php
    include_once(BACKEND_URL . 'controller/cNhanSu.php');
    include_once(BACKEND_URL . 'model/mNhanSu.php'); 

    $p=new cNhanSu();
    $kq = $p->getAllNhanSu();

    if (isset($_GET['xoa'])) {
        $p = new mNhanSu;
        $tbl = $p->xoaNS($_GET['xoa']);
        if ($tbl) {
            echo '
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Thành công",
                    text: "Xóa nhân sự thành công!",
                    confirmButtonText: "OK",
                }).then(() => {
                    window.location.href = "/QLBV/bacsi/index.php?page=QuanLyNhanSu";
                });
            </script>
        ';
        } else {
            echo '
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Thất bại",
                        text: "Xóa nhân sự thất bại. Vui lòng thử lại.",
                        confirmButtonText: "Thử lại",
                    });
                </script>
            ';
        }
    }
?>
<div class="main-content" id="main-content">
        <div class="actions">
            <h3>Danh sách nhân sự</h3>
            <div class="search-container">
                <div class="input-container">
                    <input type="text" id="search-input" placeholder="Nhập tên nhân viên" class="search-input">
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
                    <th>SDT</th>
                    <th>Email</th>
                    <th>CCCD</th>
                    <th>Ngày vào làm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="employee-table-body">
                <?php
                  $stt = 1;
                 while($r=mysqli_fetch_assoc($kq))
                 {
                     echo '<tr>
                        <td align="center" valign="middle">' . $stt . '</td>
                         <td align="center" valign="middle">'.$r['HoTen'].'</td>
                         <td align="center" valign="middle">'.$r['TenCV'].'</td>
                         <td align="center" valign="middle">'.$r['TenKhoa'].'</td>
                         <td align="center" valign="middle">'.$r['SoDienThoai'].'</td>
                         <td align="center" valign="middle">'.$r['Email'].'</td>
                         <td align="center" valign="middle">'.$r['CCCD'].'</td>
                         <td align="center" valign="middle">'.$r['NgayBatDau'].'</td>
                         <td>
                          <button class="icon-btn edit-btn" id="editbtn">
                            <a href="?page=QuanLyNhanSu&sua='.$r["MaNS"].'" class="btn-link">
                                <i class="fas fa-edit"></i>
                            </a>
                        </button>
                            <button class="icon-btn delete-btn">
                                <a href="?page=QuanLyNhanSu&xoa='.$r["MaNS"].'" class="btn-link" onclick="return confirm(\'Bạn có chắc muốn xóa nhân sự này không?\');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </button>
                         </td>
                     </tr>';
                     $stt++;
                 }
                ?>
                    </td>
                </tr>
            </tbody>
        </table>
        </tbody>
        </table>
        <div class="pagination" id="pagination">
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
            <div class="modal-body" >
                <form id="addEmployeeForm" >
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="fullName" name="HoTen" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthDate" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="birthDate" name="NgaySinh" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select class="form-select" id="gender" name="GioiTinh" >
                            <option value="" disabled selected>Chọn giới tính</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="birthDate" class="form-label">Số điện thoại</label>
                        <input type="number" class="form-control" id="birthDate" name="SoDienThoai" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Địa chỉ email</label>
                        <input type="email" class="form-control" id="email" name="Email" required >
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ thường trú</label>
                        <input type="text" class="form-control" id="address" name="DiaChi" required >
                    </div>
                    <div class="mb-3">
                        <label for="idCard" class="form-label">Số căn cước công dân</label>
                        <input type="text" class="form-control" id="idCard" name="CCCD" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Chức vụ</label>
                        <?php
                            $kq=$p->getAllChucVu();
                            if($kq){
                                echo '<select class="form-control" name="ChucVu">';
                                while($r = mysqli_fetch_assoc($kq))
                                {
                                    echo '<option value="'.$r["MaCV"].'">'.$r["TenCV"].'</option>';
                                    
                                }
                                echo '</select>';
                            }   
                            else
                            {
                                echo 'Không có data';
                            }
                        ?>
                    </div>
                   
                    <div class="mb-3">
                        <label for="khoa" class="form-label">Khoa</label>
                            <?php
                            $kq=$p->getAllKhoa();
                            if($kq){
                                echo '<select class="form-control" name="Khoa">';
                                while($r = mysqli_fetch_assoc($kq))
                                {
                                    echo '<option value="'.$r["MaKhoa"].'">'.$r["TenKhoa"].'</option>';
                                    
                                }
                                echo '</select>';
                            }   
                            else
                            {
                                echo 'Không có data';
                            }
                            ?>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary" id="saveEmployeeBtn">Lưu </button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById("addEmployeeForm");
    if (form) {
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            
            // Kiểm tra dữ liệu formData
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            
            fetch("/QLBV/ajax/Themns.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Lấy phản hồi dưới dạng text thay vì JSON
            })
            .then((text) => {
                console.log("Response text:", text); // Log phản hồi để kiểm tra

                try {
                    // Thử phân tích phản hồi như JSON
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error('Phản hồi không phải là JSON');
                }
            })
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Thành công",
                        text: "Thêm nhân sự thành công!",
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.href = "/QLBV/bacsi/index.php?page=QuanLyNhanSu";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Thất bại",
                        text: "Thêm nhân sự thất bại. Vui lòng thử lại.",
                        confirmButtonText: "Thử lại",
                    });
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    icon: "error",
                    title: "Thất bại.",
                    text: "Vui lòng thử lại!",
                    confirmButtonText: "OK",
                });
            });
        });
    }
});

</script>
