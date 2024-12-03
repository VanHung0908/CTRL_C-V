<?php
$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
$MaDKK = isset($_GET['MaDKK']) ? $_GET['MaDKK'] : null;
$MaNS = $_SESSION['maNS'];
include_once(BACKEND_URL . 'model/mBenhNhan.php');

$con = new mBenhNhan(); 

$dsBenhNhan = $con->PhieuKhamBN($MaBN, $MaNS);
$benhNhan = $dsBenhNhan[0]; 
include_once(BACKEND_URL . 'model/mThuoc.php');
$conThuoc = new mThuoc();
$dsThuoc = $conThuoc->getAllThuoc(); 

?>

<div class="main-content" id="main-content">
    <div class="header-lpk">
        <h2>PHIẾU KẾT QUẢ KHÁM BỆNH</h2>
    </div>
    <table class="info">
        <tr>
            <td>Tên bệnh nhân: <span class="patient-info"><?php echo $benhNhan['HoTenBN']; ?></span></td>
            <td>Mã bệnh nhân: <span class="patient-info"><?php echo $benhNhan['MaBN']; ?></span></td>
            <td>BHYT: <span class="patient-info"><?php echo $benhNhan['BHYT']; ?></span></td>
        </tr>
        <tr>
            <td>Năm sinh: <span class="patient-info"><?php echo $benhNhan['NgaySinh']; ?></span></td>
            <td>Giới tính: <span class="patient-info"><?php echo $benhNhan['GioiTinh']; ?></span></td>
            <td>Địa chỉ: <span class="patient-info"><?php echo $benhNhan['DiaChi']; ?></span></td>
        </tr>
        <tr>
            <td>Khoa: <span class="patient-info"><?php echo $benhNhan['TenKhoa']; ?></span></td>
            <td>Bác sĩ khám bệnh: <span class="patient-info"><?php echo $benhNhan['BacSi']; ?></span></td>
            <td>Chẩn đoán:   <textarea class="diagnosis-textarea"></textarea></td>
        </tr>
        <tr>
            <td>Tình trạng hiện tại:   <textarea class="diagnosis-textarea"></textarea></td>
            <td>Ngày khám bệnh: <span><?php echo date('d-m-Y H:i:s'); ?></span></td>
            <td>Ngày tái khám: <input type="date" name="NgayTaiKham"></td>
        </tr>
    </table>

    <table class="results">
        <h4>TOA THUỐC</h4>
        <tr>
            <th>STT</th>
            <th>Tên thuốc</th>
            <th>Liều lượng</th>
            <th>Số lượng</th>
            <th>Cách dùng</th>
            <th>Thao tác</th>
        </tr>
        <tr>
            <td><input type="number" value="1" readonly></td>
            <td>
                <input type="text" name="tenThuoc" id="tenThuoc" placeholder="Nhập tên thuốc..." autocomplete="off">
                <select name="tenThuocOptions" id="tenThuocOptions">
                    <option value="">Chọn thuốc</option>
                </select>
            </td>
            <td>
                <select name="lieuLuong" id="lieuLuong">
                    <option value=""></option>
                    <option value="1 lần/ngày">1 lần/ngày</option>
                    <option value="2 lần/ngày">2 lần/ngày</option>
                    <option value="3 lần/ngày">3 lần/ngày</option>
                </select>
            </td>
            <td><input type="number" id="soLuong"></td>
            <td>
                <select name="cachDung" id="cachDung">
                    <option value=""></option>
                    <option value="Uống">Uống</option>
                    <option value="Tiêm">Tiêm</option>
                    <option value="Truyền dịch">Truyền dịch</option>
                </select>
            </td>
            <td><button class="lpk-button" id="addDrugButton">Thêm thuốc</button></td>
        </tr>
    </table>

    <p class="note">
        *Lưu ý: Dùng thuốc theo đơn, nếu nhận thấy có triệu chứng bất thường hãy đến khám ngay!
    </p>
    <button class="lpk-button save-prescription" id="savePrescriptionButton">Lưu đơn thuốc</button>

</div>

<script>
    // Lắng nghe sự kiện khi người dùng nhập dữ liệu tìm kiếm thuốc
    document.getElementById('tenThuoc').addEventListener('input', function() {
        var searchTerm = this.value.trim();

        var xhr = new XMLHttpRequest();
        var url = searchTerm.length > 0 
            ? "/QLBV/ajax/searchThuoc.php?search=" + searchTerm 
            : "/QLBV/ajax/searchThuoc.php"; 

        xhr.open("GET", url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var results = JSON.parse(xhr.responseText);
                var selectElement = document.getElementById('tenThuocOptions');
                selectElement.innerHTML = '<option value="">Chọn thuốc</option>'; 

                if (results.length > 0) {
                    results.forEach(function(thuoc) {
                        var option = document.createElement('option');
                        option.value = thuoc.MaThuoc;
                        option.textContent = thuoc.TenThuoc;
                        selectElement.appendChild(option);
                    });
                } else {
                    var option = document.createElement('option');
                    option.textContent = "Không tìm thấy thuốc";
                    selectElement.appendChild(option);
                }
            }
        };
        xhr.send();
    });

    // Lắng nghe sự kiện khi chọn thuốc từ danh sách
    document.getElementById('tenThuocOptions').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedMaThuoc = selectedOption.value;
        var selectedTenThuoc = selectedOption.textContent;

        // Cập nhật ô input với mã thuốc và tên thuốc đã chọn
        document.getElementById('tenThuoc').value = selectedTenThuoc;
        document.getElementById('tenThuoc').setAttribute('data-ma-thuoc', selectedMaThuoc);
        
    });
    // Xử lý thêm thuốc vào bảng
// Lắng nghe sự kiện khi người dùng nhấn nút "Thêm thuốc"
document.getElementById('addDrugButton').addEventListener('click', function() {
    var maThuoc = document.getElementById('tenThuoc').getAttribute('data-ma-thuoc');
    var tenThuoc = document.getElementById('tenThuoc').value;
    var lieuLuong = document.getElementById('lieuLuong').value;
    var soLuong = document.getElementById('soLuong').value;
    var cachDung = document.getElementById('cachDung').value;

    if (maThuoc && tenThuoc && lieuLuong && soLuong && cachDung) {
        var table = document.querySelector('.results');
        
        // Tính số thứ tự mới, đếm các dòng dữ liệu trong bảng (bỏ qua dòng tiêu đề)
        var newSTT = table.querySelectorAll('tr[data-type="data"]').length + 1; 

        var newRow = table.insertRow(1);  // Insert new row at the top

        // Thêm thuộc tính data-type để dễ phân biệt dòng dữ liệu
        newRow.setAttribute('data-type', 'data'); 
        newRow.setAttribute('data-ma-thuoc', maThuoc); 
        // Thêm các ô dữ liệu vào dòng mới
        newRow.innerHTML = `
            <td>${newSTT}</td>
            <td>${tenThuoc}</td>
            <td>${lieuLuong}</td>
            <td>${soLuong}</td>
            <td>${cachDung}</td>
            <td>  <button class="icon-btn delete-btn"><i class="fas fa-trash-alt"></i></button></td>
        `;

        // Reset input fields after adding the drug
        document.getElementById('tenThuoc').value = '';
        document.getElementById('lieuLuong').value = '';
        document.getElementById('soLuong').value = '';
        document.getElementById('cachDung').value = '';

        // Thêm chức năng xóa thuốc
        newRow.querySelector('.delete-btn').addEventListener('click', function() {
            table.deleteRow(newRow.rowIndex);
            // Cập nhật lại STT sau khi xóa
            updateSTT();
        });

        // Cập nhật lại số thứ tự cho các dòng sau khi thêm
        updateSTT();
    } else {
        alert("Vui lòng nhập đầy đủ thông tin thuốc.");
    }
});

// Hàm cập nhật lại STT sau khi thêm/xóa thuốc
function updateSTT() {
    var rows = document.querySelectorAll('.results tr[data-type="data"]');
    rows.forEach(function(row, index) {
        row.cells[0].textContent = index + 1;  // Cập nhật STT cho mỗi dòng
    });
}

    

document.getElementById('savePrescriptionButton').addEventListener('click', function () {
    var table = document.querySelector('.results');
    var rows = table.querySelectorAll('tr');

    // Thu thập dữ liệu các thuốc trong bảng
    var chiTietDonThuoc = [];
    var tongTien = 0;

    rows.forEach(function (row, index) {
        if (index === 0) return; // Bỏ qua tiêu đề

        var tenThuoc = row.cells[1].textContent;
        var lieuLuong = row.cells[2].textContent;
        var soLuong = parseInt(row.cells[3].textContent);
        var cachDung = row.cells[4].textContent;
        var maThuoc = row.getAttribute('data-ma-thuoc');

        if (maThuoc && soLuong) {
            // Tính tổng tiền dựa trên giá thuốc
            var giaThuoc = parseFloat(row.getAttribute('data-gia-thuoc')) || 0;
            tongTien += giaThuoc * soLuong;

            chiTietDonThuoc.push({
                MaThuoc: maThuoc,
                SoLuong: soLuong,
                LieuDung: lieuLuong,
                CachDung: cachDung
            });
        }
    });

    // Lấy dữ liệu từ các trường bổ sung
    var chuanDoan = encodeURIComponent(document.querySelector('.diagnosis-textarea').value.trim());
    var tinhTrang = encodeURIComponent(document.querySelectorAll('.diagnosis-textarea')[1].value.trim()); // Tình trạng hiện tại
    var ngayTaiKham = document.querySelector('input[name="NgayTaiKham"]').value;
    var maNS = <?php echo json_encode($_SESSION['maNS']); ?>;
    var loaiBHYT = <?php echo json_encode($benhNhan['LoaiBHYT']); ?>;
    var maDKK = <?php echo json_encode($MaDKK); ?>;
    if (!chuanDoan || !tinhTrang) {
        alert('Vui lòng nhập chẩn đoán và tình trạng hiện tại!');
        return;
    }

    // Gửi dữ liệu lên server để lưu
    if (chiTietDonThuoc.length > 0 || chuanDoan || tinhTrang || ngayTaiKham) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/QLBV/ajax/saveDonThuoc.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function () {  
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log("Server Response: ", xhr.responseText);
                try {
                    // Kiểm tra dữ liệu phản hồi và phân tích JSON
                    console.log("Server Response: ", xhr.responseText);  // Kiểm tra dữ liệu phản hồi
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Lập phiếu khám thành công!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '/QLBV/bacsi/index.php?page=DSBN';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Lỗi khi lưu đơn thuốc: ' + response.message,
                            confirmButtonText: 'Thử lại'
                        });
                    }

                } catch (e) {
                        console.error('Error parsing JSON:', e);

                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi không mong muốn',
                            text: 'Có lỗi xảy ra khi nhận dữ liệu từ server. Vui lòng kiểm tra phản hồi.',
                            // footer: '<pre>' + xhr.responseText + '</pre>', 
                            confirmButtonText: 'OK'
                        });
                    }
            }
        };

        // Gửi dữ liệu dưới dạng JSON
        var data = {
            MaBN: <?php echo json_encode($MaBN); ?>,
            NgayKeDon: new Date().toISOString().split('T')[0],
            TongTien: tongTien,
            ChuanDoan: chuanDoan,
            TinhTrang: tinhTrang,
            NgayTaiKham: ngayTaiKham,
            ChiTietDonThuoc: chiTietDonThuoc,
            MaNS: maNS,
            LoaiBHYT: loaiBHYT,
            MaDKK: maDKK
        };

        xhr.send(JSON.stringify(data));
    } else {
        alert('Không có dữ liệu để lưu.');
    }
});



</script>
