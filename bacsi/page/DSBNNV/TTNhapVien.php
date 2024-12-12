<?php
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mNamVien.php');  // Giả sử bạn có model này để cập nhật bảng phiếu nằm viện

$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
if (!$MaBN) {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Không có dữ liệu bệnh nhân.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    exit; // Dừng tiếp tục xử lý khi không có MaBN
}
$con = new mBenhNhan();
$dsBenhNhan = $con->getTTBN($MaBN);
    if (empty($dsBenhNhan)) {
        echo '<script>
        Swal.fire({
        icon: "error",
        title: "Thất bại",
        text: "Không có dữ liệu bệnh nhân.",
        confirmButtonText: "Thử lại"
        });
        </script>';
        exit;
    }
    $benhNhan = $dsBenhNhan[0];
include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mKhoa.php');
$mKhoa = new mKhoa();
$departments = $mKhoa->getalDepartments($MaBN);
$department = $departments[0];
$MaNV=htmlspecialchars($department['MaNV']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy các thông tin từ form
    $hoten = isset($_POST['hoten_nguoinha']) ? $_POST['hoten_nguoinha'] : '';
    $gioitinh = isset($_POST['goitinh_nguoinha']) ? $_POST['goitinh_nguoinha'] : '';
    $sdt = isset($_POST['sdt_nguoinha']) ? $_POST['sdt_nguoinha'] : '';
    $diachi = isset($_POST['diachi_nguoinha']) ? $_POST['diachi_nguoinha'] : '';
    $quanhe = isset($_POST['quanhe_nguoinha']) ? $_POST['quanhe_nguoinha'] : '';
    $MaKhoa = isset($_POST['MaKhoa']) ? $_POST['MaKhoa'] : '';
    $MaPhong = isset($_POST['phong']) ? $_POST['phong'] : '';
    $MaGiuong = isset($_POST['giuong']) ? $_POST['giuong'] : '';
    $MaNS = isset($_POST['bacsi']) ? $_POST['bacsi'] : ''; // Mã bác sĩ
    $TamUng = isset($_POST['TamUng']) ? $_POST['TamUng'] : 0;

    // Kiểm tra xem có trường nào bị thiếu không
    if (empty($hoten) || empty($gioitinh) || empty($sdt) || empty($diachi) || empty($quanhe) || 
        empty($MaKhoa) || empty($MaPhong) || empty($MaGiuong) || empty($MaNS)) {
        
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin',
                text: 'Vui lòng nhập đầy đủ thông tin trước khi cập nhật!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
        exit; // Dừng thực thi nếu thiếu thông tin
    }

    // Giả sử bạn có phương thức cập nhật trong model NamVien
    $phieu = new NamVien();
   
    $result = $phieu->updatePhieuNamVien($MaBN, $MaKhoa, $MaPhong, $MaGiuong, $MaNS, $TamUng, $hoten, $gioitinh, $sdt, $diachi, $quanhe, $MaNV);
    
    if ($result) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Cập nhật phiếu nhập viện thành công!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/QLBV/bacsi/index.php?page=DSBNNV';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Thất bại',
                text: 'Cập nhật phiếu nhập viện thất bại!',
                confirmButtonText: 'Thử lại'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
    }
}

?>

<div class="main-content" id="main-content">
    <div class="col-md-12">
        <h3>Tiếp nhận bệnh án</h3>
        <hr class="divider">
        <div class="card-body">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-6">
                        <h5>Thông tin người nhà</h5>
                        <div class="form-group">
                            <label for="hoten_nguoinha">Họ tên</label>
                            <input name="hoten_nguoinha" type="text" class="form-control" id="hoten_nguoinha" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="goitinh_nguoinha">Giới tính</label>
                            <select name="goitinh_nguoinha" class="form-control">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sdt_nguoinha">SDT</label>
                            <input name="sdt_nguoinha" type="text" class="form-control" id="sdt_nguoinha" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="diachi_nguoinha">Địa chỉ</label>
                            <input name="diachi_nguoinha" type="text" class="form-control" id="diachi_nguoinha" placeholder="">
                        </div>
                        <div class="mb-3">
                        <label for="relativeRelation" class="form-label">Quan hệ</label>
                            <select class="form-select" name="quanhe_nguoinha" id="relativeRelation">
                                <option selected disabled>Chọn quan hệ</option>
                                <option value="Anh">Anh</option>
                                <option value="Em">Em</option>
                                <option value="Cha">Cha</option>
                                <option value="Mẹ">Mẹ</option>
                                <option value="Vợ">Vợ</option>
                                <option value="Chồng">Chồng</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Thông tin nhập viện</h5>
                        <div class="form-group">
                        <label for="khoa">Chọn vào khoa</label>
                            <select class="form-select" id="department" name="MaKhoa">
                                <option value="">Chọn khoa</option>
                                <?php
                                // Kiểm tra nếu danh sách departments không trống
                                if (!empty($departments)) {
                                    // Hiển thị danh sách khoa trong select
                                        echo '<option value="' . htmlspecialchars($department['MaKhoa']) . '">' . htmlspecialchars($department['TenKhoa']) . '</option>';
                                } else {
                                    echo '<option value="">Không có khoa nào</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phong">Chọn phòng</label>
                            <select name="phong" class="form-control" id="room">
                                <option value="">Chọn phòng</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="giuong">Chọn giường</label>
                            <select name="giuong" class="form-control" id="giuong">
                                <option value="">Chọn giường</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bacsi">Chọn bác sĩ</label>
                            <select name="bacsi" class="form-control" id="bacsi">
                                <option value="">Chọn bác sĩ</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="chuandoanbenh">Tạm ứng</label>
                            <input name="TamUng" type="number" class="form-control" id="TamUng" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <legend>Thông tin bệnh nhân</legend>
                        <div class="form-group">
                            <label for="patientName" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="patientName" value="<?php echo $benhNhan['HoTen']; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="patientGender" class="form-label">Giới tính</label>
                            <input type="text" class="form-control" id="patientGender" value="<?php echo $benhNhan['GioiTinh']; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="patientDOB" class="form-label">Ngày sinh</label>
                            <input type="text" class="form-control" id="patientDOB" value="<?php echo $benhNhan['NgaySinh']; ?>" >
                        </div>
                        <div class="mb-3">
                            <label for="patientCCCD" class="form-label">CCCD</label>
                            <input type="text" class="form-control" id="patientCCCD" value="<?php echo $benhNhan['CCCD']; ?>" >
                        </div>
                        <div class="mb-3">
                            <label for="patientBHYT" class="form-label">BHYT</label>
                            <input type="text" class="form-control" id="patientBHYT" value="<?php echo $benhNhan['BHYT']; ?>" >
                        </div>
                    </div>
                </div>

                <div class="form-row" style="margin-top: 20px;">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function (e) {
    const sdt = document.getElementById('sdt_nguoinha').value.trim();

    // Kiểm tra độ dài số điện thoại
    if (!/^\d{10}$/.test(sdt)) {
        e.preventDefault(); // Ngăn form gửi đi
        Swal.fire({
            icon: 'error',
            title: 'Lỗi dữ liệu',
            text: 'Số điện thoại phải đủ 10 số.',
            confirmButtonText: 'OK'
        });
    }
});

    document.getElementById('department').addEventListener('change', function() {
        var maKhoa = this.value; // Lấy mã khoa đã chọn
        var roomSelect = document.getElementById('room'); // Phần tử select phòng
        if (!maKhoa) {
            roomSelect.innerHTML = '<option value="">Chọn phòng</option>';
            return;
        }

        // Gửi yêu cầu AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/QLBV/ajax/getPhongsByKhoa.php', true); 
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Log dữ liệu trả về để kiểm tra
                console.log(xhr.responseText);

                // Kiểm tra nếu dữ liệu trả về không phải là chuỗi rỗng
                if (xhr.responseText.trim() === "") {
                    alert("Dữ liệu trả về từ server rỗng!");
                    return;
                }

                try {
                    var phongs = JSON.parse(xhr.responseText);
                    // Xóa các option cũ trong select phòng
                    roomSelect.innerHTML = '<option value="">Chọn phòng</option>';

                    phongs.forEach(function(phong) {
                        var option = document.createElement('option');
                        option.value = phong.MaPhong;
                        option.textContent = phong.TenPhong;
                        roomSelect.appendChild(option);
                    });
                } catch (e) {
                    console.error("Lỗi khi parse JSON:", e);
                    console.error(xhr.responseText);
                }
            } else {
                alert('Có lỗi khi lấy dữ liệu phòng.');
            }
        };
        xhr.send("MaKhoa=" + maKhoa);

    });
    // giường 
    document.getElementById('room').addEventListener('change', function() {
    var MaPhong = this.value; 
    var giuongSelect = document.getElementById('giuong');
    if (!MaPhong) {
            roomSelect.innerHTML = '<option value="">Chọn giường</option>';
            return;
        }

    if (MaPhong) {
        // Gửi yêu cầu AJAX để lấy giường theo MaPhong
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/QLBV/ajax/getGiuongByPhong.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
             if (xhr.responseText.trim() === "") {
                    alert("Dữ liệu trả về từ server rỗng!");
                    return;
                }
            try {
                var giuongs = JSON.parse(xhr.responseText);
                

                // Xóa các option cũ trong select giường
                giuongSelect.innerHTML = '<option value="">Chọn giường</option>';

                // Thêm các giường mới vào select
                giuongs.forEach(function(giuong) {
                    var option = document.createElement('option');
                    option.value = giuong.MaGiuong;
                    option.textContent = giuong.TenGiuong;
                    giuongSelect.appendChild(option);
                });
            } catch (e) {
                console.error("Lỗi khi parse JSON:", e);
            }
        } else {
            alert('Có lỗi khi lấy dữ liệu giường.');
        }
    };

        xhr.send('MaPhong=' + MaPhong);
    } else {
        // Nếu không có MaPhong, xóa các option trong select giường
        document.getElementById('giuong').innerHTML = '<option value="">Chọn giường</option>';
    }
});
//Bác sĩ

document.getElementById('department').addEventListener('change', function() {
    var maKhoa = this.value; 
    var bacSiSelect = document.getElementById('bacsi'); 

    bacSiSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';

    if (!maKhoa) {
        roomSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';
        return;
    }

    // Gửi yêu cầu AJAX để lấy bác sĩ theo MaKhoa
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/QLBV/ajax/getBacSiByKhoa.php', true); 
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            // Kiểm tra nếu dữ liệu trả về không phải là chuỗi rỗng
            if (xhr.responseText.trim() === "") {
                alert("Dữ liệu trả về từ server rỗng!");
                return;
            }

            try {
                var bacSiList = JSON.parse(xhr.responseText);
                bacSiSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';

                bacSiList.forEach(function(bacSi) {
                    var option = document.createElement('option');
                    option.value = bacSi.MaNS; 
                    option.textContent = bacSi.HoTen; 
                    bacSiSelect.appendChild(option);
                });
            } catch (e) {
                console.error("Lỗi khi parse JSON:", e);
            }
        } else {
            alert('Có lỗi khi lấy dữ liệu bác sĩ.');
        }
    };

    xhr.send('MaKhoa=' + maKhoa); 
});


</script>
