<?php 
$MaBN = isset($_GET['MaBN']) ? $_GET['MaBN'] : null;
include_once(BACKEND_URL . 'model/mBenhNhan.php');
include_once(BACKEND_URL . 'model/mPhieuDKKham.php');
include_once(BACKEND_URL . 'model/mPhieuChamSoc.php');

$con = new mBenhNhan(); 

$result = $con->getTTNVBenhNhan($MaBN);
if ($result && mysqli_num_rows($result) > 0) {
    $benhNhan = mysqli_fetch_assoc($result); 
} else {
    $benhNhan = []; 
    echo "Không tìm thấy bệnh nhân.";
}


$con = new mPhieuDKKham(); 
$resultKQK = $con->getPhacDo($MaBN);
$mPhieuChamSoc = new mPhieuChamSoc(); 
$PCS = $mPhieuChamSoc->getPhieuChamSoc($MaBN);
?>
<style>
    
</style>
<!-- Header -->
<div class="main-content" id="main-content">
    <div class="inner-wrap wow fadeInRight">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10">
                    <!-- Thông tin cá nhân bệnh nhân -->
                    <div class="ttcnbn-info-section">
                        <div class="ttcnbn-card">
                         <form action="" method="post">    
                            <div class="ttcnbn-card-header">
                                <h4 class="mb-0">Thông Tin Cá Nhân</h4>
                            </div>
                            <div class="ttcnbn-card-body">
                            <div class="row">
                                    <div class="col-md-6">
                                    <p><strong>Họ tên:</strong>
                                        <input type="text" class="form-control" id="patientName" name="HoTen" value="<?php echo isset($benhNhan['HoTen']) ? $benhNhan['HoTen'] : ''; ?>">
                                    <p><strong>Ngày sinh:</strong>
                                        <input type="date" class="form-control" name ="NgaySinh" value="<?php echo isset($benhNhan['NgaySinh']) ? $benhNhan['NgaySinh'] : ''; ?>" />
                                    <p><strong>Giới tính:</strong> 
                                        <select class="form-control" id="GioiTinh" name="GioiTinh">
                                            <option value="Nam" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                            <option value="Nữ" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                            <option value="Khác" <?php echo (isset($benhNhan['GioiTinh']) && $benhNhan['GioiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                        </select>
                                        <p><strong>Chẩn đoán ban đầu:</strong>
                                        <input type="text" class="form-control" name ="ChuanDoanBn" value="<?php echo isset($benhNhan['ChuanDoanBD']) ? $benhNhan['ChuanDoanBD'] : ''; ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Địa chỉ:</strong> 
                                            <input type="text" class="form-control" placeholder="Nhập địa chỉ"  name="DiaChi" value="<?php echo isset($benhNhan['DiaChi'])?$benhNhan['DiaChi']:''; ?>">
                                       
                                        <p><strong>Số điện thoại:</strong> 
                                            <input type="text" class="form-control" placeholder="Nhập số SDT" name="SDT" value="<?php echo isset($benhNhan['SDT'])?$benhNhan['SDT']:''; ?>">
                                        
                                        <p><strong>CCCD:</strong> 
                                            <input type="text" class="form-control" placeholder="Nhập số CCCD" name="CCCD" value="<?php echo isset($benhNhan['CCCD'])?$benhNhan['CCCD']:''; ?>">
                                        <p><strong>Tiền sử bệnh:</strong> 
                                            <input type="text" class="form-control"  name="TienSuBenh" value="<?php echo isset($benhNhan['TienSuBenh'])?$benhNhan['TienSuBenh']:''; ?>">
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>


                    <div class="mt-4">
                        <div class="ttcnbn-card">
                            <div class="ttcnbn-card-header bg-success">
                                <h4 class="mb-0">Phác đồ bệnh nhân</h4>
                            </div>
                            <div class="ttcnbn-card-body">
                                <table class="ttcnbn-table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ngày lập</th>
                                            <th>Chẩn đoán</th>
                                            <th>Kế hoạch</th>
                                            <th>Chế độ dinh dưỡng</th>
                                            <th>Lưu ý</th>
                                            <th>Đơn thuốc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                     if (!empty($resultKQK)) {
                                        foreach ($resultKQK as $row) {
                                            echo '<tr>';
                                            echo '<td>' . (isset($row['NgayLap']) ? date('d/m/Y', strtotime($row['NgayLap'])) : '') . '</td>';
                                            echo '<td>' . (isset($row['ChanDoan']) ? $row['ChanDoan'] : '') . '</td>';
                                            echo '<td>' . (isset($row['KeHoach']) ? $row['KeHoach'] : '') . '</td>';
                                            echo '<td>' . (isset($row['CheDoDD']) ? $row['CheDoDD'] : '') . '</td>';
                                            echo '<td>' . (isset($row['GhiChu']) ? $row['GhiChu'] : '') . '</td>';
                                            ?>
                                            <td>
                                                    <?php if (isset($row['MaDonThuoc'])): ?>
                                                        <a href="#" data-toggle="modal" data-target="#modalChiTietDonThuoc" onclick="loadChiTietDonThuoc('<?php echo $row['MaDonThuoc']; ?>')">
                                                            Chi tiết đơn thuốc
                                                        </a>
                                                    <?php else: ?>
                                                        Không có đơn thuốc
                                                    <?php endif; ?>
                                                </td>

                                            <?php
                                            echo '</tr>';
                                        }
                                    } else {
                                        // Nếu không có dữ liệu, hiển thị một dòng trống hoặc thông báo
                                        echo '<tr><td colspan="5">Không có dữ liệu để hiển thị.</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Phiếu chăm sóc -->
                    <div class="mt-4">
                        <div class="ttcnbn-card">
                            <div class="ttcnbn-card-header bg-secondary">
                                <h4 class="mb-0">Phiếu chăm sóc</h4>
                            </div>
                            <div class="ttcnbn-card-body">
                                <table class="ttcnbn-table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ngày thực hiện</th>
                                            <th>Tình trạng</th>
                                            <th>Điều dưỡng</th>
                                            <th>Nhịp tim</th>
                                            <th>Nhịp thở</th>
                                            <th>Huyết áp</th>
                                            <th>Nhiệt độ cơ thể</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                     if (!empty($PCS)) {
                                        foreach ($PCS as $row) {
                                            echo '<tr>';
                                            echo '<td>' . (isset($row['NgayThuchien']) ? date('d/m/Y', strtotime($row['NgayThuchien'])) : '')                                            . '</td>';
                                            echo '<td>' . (isset($row['TinhTrang']) ? $row['TinhTrang'] : '') . '</td>';
                                            echo '<td>' . (isset($row['TenNhanSu']) ? $row['TenNhanSu'] : '') . '</td>';
                                            echo '<td>' . (isset($row['NhipTim']) ? $row['NhipTim'] : '') . '</td>';
                                            echo '<td>' . (isset($row['NhipTho']) ? $row['NhipTho'] : '') . '</td>';
                                            echo '<td>' . (isset($row['HuyetAp']) ? $row['HuyetAp'] : '') . '</td>';
                                            echo '<td>' . (isset($row['NhietDoCoThe']) ? $row['NhietDoCoThe'] : '') . '</td>';
                                            echo '<td>' . (isset($row['GhiChu']) ? $row['GhiChu'] : '') . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        // Nếu không có dữ liệu, hiển thị một dòng trống hoặc thông báo
                                        echo '<tr><td colspan="5">Không có dữ liệu để hiển thị.</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<?php
    $HoTen = isset($_POST['HoTen'])? $_POST['HoTen'] : null;
    $NgaySinh = isset($_POST['NgaySinh']) ? $_POST['NgaySinh'] : null;
    $GioiTinh = isset($_POST['GioiTinh']) ? $_POST['GioiTinh'] : null;
    $DiaChi = isset($_POST['DiaChi']) ? $_POST['DiaChi'] : null;
    $SDT = isset($_POST['SDT']) ? $_POST['SDT'] : null;
    $CCCD = isset($_POST['CCCD']) ? $_POST['CCCD'] : null;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $benhnhan = new mBenhNhan();
    if (empty($NgaySinh) || empty($GioiTinh)  || empty($MaBN) || empty($DiaChi)|| empty($SDT)|| empty($CCCD)) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin',
                text: 'Vui lòng nhập đầy đủ thông tin trước khi lưu!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
        exit; 
    }

    $result = $benhnhan->updateTT($HoTen, $NgaySinh, $GioiTinh, $DiaChi,$SDT, $CCCD,$MaBN);
    
    // Hiển thị thông báo và chuyển hướng
    if ($result) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Cập nhật thông tin thành công!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/QLBV/bacsi/index.php?page=DSBN';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Thất bại',
                text: 'Cập nhật thông tin thất bại!',
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
   <div class="modal fade" id="modalChiTietDonThuoc" tabindex="-1" aria-labelledby="modalChiTietDonThuocLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalChiTietDonThuocLabel">Chi tiết đơn thuốc</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Nội dung sẽ được tải động -->
                <table class="table table-striped table-bordered table-hover table-costt">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Số lượng</th>
                            <th>Liệu dùng</th>
                            <th>Cách dùng</th>
                        </tr>
                    </thead>
                    <tbody id="chiTietDonThuocBody">
                        <!-- Dữ liệu sẽ được thêm ở đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function loadChiTietDonThuoc(maDonThuoc) {
    
    fetch(`./page/DSBN/getChiTietDonThuoc.php?maDonThuoc=${maDonThuoc}`)

    .then(response => {
        if (!response.ok) {
            throw new Error('Server trả về lỗi: ' + response.status);
        }
        return response.text(); // Lấy dữ liệu dưới dạng text thay vì json
    })
    .then(data => {
        console.log('Dữ liệu từ server:', data); // In ra phản hồi thô từ server
        try {
            const jsonData = JSON.parse(data); // Chuyển đổi dữ liệu sang JSON
            console.log(jsonData); // Kiểm tra dữ liệu JSON
            const tbody = document.getElementById('chiTietDonThuocBody');
            tbody.innerHTML = ''; // Xóa nội dung cũ

            let totalCost = 0;
            jsonData.forEach(thuoc => {
                const soLuong = parseFloat(thuoc.SoLuong);

                const row = `
                    <tr>
                        <td>${thuoc.TenThuoc}</td>
                        <td>${soLuong} ${thuoc.DonViTinh}</td>
                        <td>${thuoc.LieuDung} </td>
                        <td>${thuoc.CachDung} </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            // Thêm tổng tiền
            const totalRow = `
                
            `;
            tbody.insertAdjacentHTML('beforeend', totalRow);
        } catch (error) {
            console.error('Lỗi khi chuyển đổi dữ liệu sang JSON:', error);
        }
    })
    .catch(error => {
        console.error('Lỗi khi tải chi tiết đơn thuốc:', error);
    });

}


</script>