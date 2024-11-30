<?php
ob_start();
include_once(BACKEND_URL . 'model/mKhoa.php');
$con = new mKhoa;
$dsYCNP = $con->dsKhoa();

$successMessage = '';

if (isset($_GET['xoa'])) {
    $p = new mKhoa;
    $tbl = $p->xoaKhoa($_GET['xoa']);
    if ($tbl) {
        $successMessage = 'Đã xóa khoa thành công!';
    } else {
        $successMessage = 'Xóa khoa thất bại!';
    }
}

echo '<div class="main-content" id="main-content">
    <form action="" method="post">
        <table class="leave-request-table" align="center">
            <tr>
                <th>STT</th>
                <th>Tên Khoa</th>
                <th>Khu vực</th>
                <th>Mô tả</th>
                <th>Thao tác</th>
            </tr>';

if (!mysqli_num_rows($dsYCNP) > 0) {
    echo '
    <tr>
    <td colspan="5"> Chưa có Khoa nào !</td>
    </tr>';
} else {
    $tt = 1;
    foreach ($dsYCNP as $i) {
        echo '<tr>
                <td>' . $tt++ . '</td>
                <td>' . $i['TenKhoa'] . '</td>
                <td>' . $i['KhuVuc'] . '</td>
                <td>' . $i['MoTa'] . '</td>
                <td><a href="?page=QuanLyKhoa&xoa=' . $i['MaKhoa'] . '" onclick="return confirm(\'Bạn có chắc muốn xóa Khoa này không ?\')">Xóa</a></td>
            </tr>';
    }
}

echo '</table>
      </form>
      </div>';

if ($successMessage) {
    echo '<div id="notificationModal" class="modal" style="display: block;">
            <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                <p style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: center;">' . $successMessage . '</p>
                <button id="closeModal" style="margin-top: 20px; padding: 10px 20px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">Đóng</button>
            </div>
          </div>';
}
?>



<script>
var modal = document.getElementById("notificationModal");
var closeModal = document.getElementById("closeModal");

closeModal.onclick = function() {
    window.location.href = 'http://localhost/QLBV/bacsi/index.php?page=QuanLyKhoa'; // Quay lại trang khi nhấn nút Đóng
};

// Tự động chuyển hướng về trang QuanLyKhoa sau 2 giây nếu xóa thành công
<?php if ($successMessage) : ?>
    setTimeout(function() {
        window.location.href = 'http://localhost/QLBV/bacsi/index.php?page=QuanLyKhoa';
    }, 2000);
<?php endif; ?>
</script>