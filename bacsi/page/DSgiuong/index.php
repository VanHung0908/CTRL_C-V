<?php
    include_once(BACKEND_URL . 'controller/cNhanSu.php');
    include_once(BACKEND_URL . 'model/mGiuong.php'); 
    include_once(BACKEND_URL . 'model/mPhong.php'); 
    $MaKhoa=$_SESSION['maKhoa'];
    $con = new mPhong(); 
    $dsPhong = $con->getPhongsByKhoa($MaKhoa);

?>
  <div class="main-content" id="main-content">  
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <label for="roomSelect" class="form-label">Phòng:</label>
                <select id="roomSelect" class="form-select d-inline-block w-auto">
                        <option selected disabled>Chọn Phòng</option>
                        <?php foreach ($dsPhong as $khoa) { ?>
                            <option value="<?php echo $khoa['MaPhong']; ?>"><?php echo $khoa['TenPhong']; ?></option>
                        <?php } ?>
                </select>
            </div>
            <div>
                <button class="btn btn-outline-secondary"><i class="fas fa-calendar-alt"></i> Tháng</button>
                <button class="btn btn-outline-secondary"><i class="fas fa-filter"></i></button>
            </div>
        </div>
        <div class="row" id="giuongContainer">
    
    </div>
    <script>
  document.getElementById('roomSelect').addEventListener('change', function () {
    var MaPhong = this.value;
    var giuongContainer = document.getElementById('giuongContainer');

    if (!MaPhong) {
        giuongContainer.innerHTML = '<p>Chưa chọn phòng.</p>';
        return;
    }

    // Gửi yêu cầu AJAX để lấy danh sách giường
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/QLBV/ajax/getGiuong.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                var giuongs = JSON.parse(xhr.responseText);
                if (giuongs.length === 0) {
                    giuongContainer.innerHTML = '<p>Không có dữ liệu giường.</p>';
                    return;
                }

                // Xóa dữ liệu cũ
                giuongContainer.innerHTML = '';

                // Tạo giao diện giường
                giuongs.forEach(function (giuong) {
                    // Nếu TrangThaiGiuong là null, đặt thành "Trống"
                    var trangThai = giuong.TrangThaiGiuong || 'Trống';
                    var trangThaiClass = trangThai === 'Nhập viện' ? 'in-use' : 'empty';

                    var card = document.createElement('div');
                    card.className = 'col-md-4';
                    card.innerHTML = `
                        <div class="card p-3 ${trangThaiClass === 'in-use' ? 'card-in-use' : 'card-empty'}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="card-title">${giuong.TenGiuong}</span>
                                <span class="status">${trangThai}</span>
                            </div>
                            <div class="text-center my-3">
                                <i class="fas fa-bed bed-icon ${trangThaiClass}"></i>
                            </div>
                            <div class="card-text">
                                <p><strong>Bệnh nhân:</strong>${giuong.BenhNhan || 'Chưa có'}</p>
                                <p><strong>Ngày nhập viện:</strong> ${giuong.ThoiGianNV || 'N/A'}</p>
                                <p><strong>Ngày sinh:</strong> ${giuong.NgaySinh || 'N/A'}</p>
                                <p><strong>Giới tính:</strong> ${giuong.GioiTinh || 'N/A'}</p>
                            </div>
                        </div>
                    `;
                    giuongContainer.appendChild(card);
                });
            } catch (e) {
                console.error('Lỗi khi parse JSON:', e);
                giuongContainer.innerHTML = '<p>Có lỗi xảy ra khi xử lý dữ liệu.</p>';
            }
        } else {
            giuongContainer.innerHTML = '<p>Có lỗi khi lấy dữ liệu từ server.</p>';
        }
    };

    xhr.send('MaPhong=' + MaPhong);
});

</script>
