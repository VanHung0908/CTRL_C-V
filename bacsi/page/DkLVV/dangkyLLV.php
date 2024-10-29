<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Work Schedule Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h3 {
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            margin-top: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 90%;
            width: 100px;
        }

        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>

<body>

    
    <h3>Đăng ký lịch làm việc theo tuần</h3>
    <form action="" method="post">
        <table>
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
        <button type="submit" name="btn">Lưu</button>
    </form>

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
                include_once('../../../model/mEmployee.php');
                $con = new mEmployee;
                $kq = $con->insertWork_schedule($_SESSION['dn'], $ngay, $ca);
                if (!$kq) {
                    $allSaved = false;
                }
            }

            if ($allSaved) {
                echo "<script>showAlert({title: 'Đăng ký thành công!', text: 'Tất cả ca làm việc đã được lưu.', icon: 'success'});</script>";
                header('refresh:3,url=../../../bacsi');
            } else {
                echo "<script>showAlert({title: 'Lỗi!', text: 'Có lỗi xảy ra khi đăng ký.', icon: 'error'});</script>";
            }
        }else {
            echo "<script>showAlert({title: 'Đăng ký thất bại !', text: 'Bạn chưa chọn ca làm việc.', icon: 'success'});</script>";
        }
    } 
    ?>

</body>

</html>