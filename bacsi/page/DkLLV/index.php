<?php
ob_start();
?>

<div class="main-content" id="main-content">
    <h3>Đăng ký lịch làm việc theo tuần</h3>
    <form action="" method="post" class="dkl-form">
        <table class="dkl-table">
            <tr>
                <th></th>
                <th>Thứ hai</th>
                <th>Thứ ba</th>
                <th>Thứ tư</th>
                <th>Thứ năm</th>
                <th>Thứ sáu</th>
                <th>Thứ bảy</th>
                <th>Chủ nhật</th>
            </tr>
            <tr>
                <td>Ca sáng</td>
                <?php for ($i = 0; $i <= 6; $i++): ?>
                    <td><input type="radio" name="shift[<?= $i ?>]" value="1"></td>
                <?php endfor; ?>
            </tr>
            <tr>
                <td>Ca chiều</td>
                <?php for ($i = 0; $i <= 6; $i++): ?>
                    <td><input type="radio" name="shift[<?= $i ?>]" value="2"></td>
                <?php endfor; ?>
            </tr>
            <tr>
                <td>Ca tối</td>
                <?php for ($i = 0; $i <= 6; $i++): ?>
                    <td><input type="radio" name="shift[<?= $i ?>]" value="3"></td>
                <?php endfor; ?>
            </tr>
        </table>
        <button type="submit" name="btn" class="dkl-button">Lưu</button>
    </form>
</div>

<script>
    function showAlert(message) {
        Swal.fire({
            title: message.title,
            text: message.text,
            icon: message.icon,
            confirmButtonText: 'OK'
        });
    }
</script>

<?php
if (isset($_POST['btn'])) {
    if (isset($_POST['shift'])) {
        $allSaved = true;
        foreach ($_POST['shift'] as $day_index => $shift_type) {
            $ca = $shift_type;
            $ngay = $day_index;
            include_once(BACKEND_URL . 'model\mEmployee.php');
            $con = new mEmployee;
            $kq = $con->insertWork_schedule($_SESSION['dn'], $ngay, $ca);
            if (!$kq) {
                $allSaved = false;
            }
        }

        if ($allSaved) {
            echo "<script>showAlert({title: 'Đăng ký thành công!', text: 'Tất cả ca làm việc đã được lưu.', icon: 'success'});</script>";
        } else {
            echo "<script>showAlert({title: 'Lỗi!', text: 'Có lỗi xảy ra khi đăng ký.', icon: 'error'});</script>";
        }
    } else {
        echo "<script>showAlert({title: 'Đăng ký thất bại !', text: 'Bạn chưa chọn ca làm việc.', icon: 'success'});</script>";
    }
}
?>
