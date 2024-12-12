<style>
    .custom-button {
        width: 200px;
        background-color: #66FF00;
        color: #FFFFFF;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .custom-button:hover {
        background-color: #55CC00;
        transform: scale(1.05);
    }

    .custom-button:active {
        background-color: #4DB200;
        transform: scale(0.95);
    }

    .table-wrapper {
        margin: 20px auto;
        text-align: center;
        width: 80%;
    }

    .leave-request-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .leave-request-table th,
    .leave-request-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .leave-request-table th {
        /* background-color: #f4f4f4; */
        font-weight: bold;
    }

    .action-links a {
        text-decoration: none;
        color: #007BFF;
        margin: 0 5px;
    }

    .action-links a:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    .add-new-link {
        margin: 20px 0;
        display: inline-block;
        background-color: #FFCC00;
        color: #000;
        padding: 5px 10px;
        border: 1px solid #ccc;
        text-decoration: none;
        font-weight: bold;
    }

    .add-new-link:hover {
        background-color: #FFB300;
        color: #FFF;
    }
</style>

<?php
ob_start();
include_once(BACKEND_URL . 'model/mKhoa.php');
$con = new mKhoa;
$dsYCNP = $con->dsKhoa();

// Xóa khoa
if (isset($_GET['xoa'])) {
    $p = new mKhoa;
    $tbl = $p->xoaKhoa($_GET['xoa']);
    if ($tbl) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Thành công",
                text: "Xóa khoa thành công!",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "/QLBV/bacsi/index.php?page=QuanLyKhoa";
            });
        </script>';
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Xóa khoa thất bại. Vui lòng thử lại.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    }
}

// Thêm khoa
if (isset($_POST['btn'])) {
    $result = $con->themkhoa($_POST['tenkhoa'], $_POST['khuvuc'], $_POST['mota']);
    if ($result) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Thành công",
                text: "Thêm khoa thành công!",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "/QLBV/bacsi/index.php?page=QuanLyKhoa";
            });
        </script>';
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Thêm khoa thất bại. Vui lòng thử lại.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    }
}

// Sửa khoa
if (isset($_POST['btnSua'])) {
    $result = $con->updateKhoa($_POST['tenkhoa'], $_POST['khuvuc'], $_POST['mota'], $_GET['sua']);
    if ($result) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Thành công",
                text: "Sửa khoa thành công!",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "/QLBV/bacsi/index.php?page=QuanLyKhoa";
            });
        </script>';
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Thất bại",
                text: "Sửa khoa thất bại. Vui lòng thử lại.",
                confirmButtonText: "Thử lại"
            });
        </script>';
    }
}
?>
<div class="main-content" id="main-content">
    <h3 align="center"><a href="index.php?page=QuanLyKhoa" style="color : #4682B4;"><b>QUẢN LÝ KHOA</b></a></h3>

    <?php
    if (isset($_GET['themKhoa'])) {
        echo '<form action="" method="post">
        <table class="leave-request-table" align="center">
            <tr>
                <td>Tên Khoa</td>
                <td><input type="text" name="tenkhoa" style="width:500px;" required></td>
            </tr>
            <tr>
                <td>Khu vực</td>
                <td><input type="text" name="khuvuc" style="width:500px;" required></td>
            </tr>
            <tr>
                <td>Mô tả</td>
                <td><textarea name="mota" id="mota" cols="30" rows="10" style="width:500px;" required></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="btn" class="custom-button"></td>
            </tr>
        </table>
        </form>';
    } else if (isset($_GET['sua'])) {
        $layTT = $con->dsKhoaByID($_GET['sua']);
        foreach ($layTT as $i) {
            $ten = $i['TenKhoa'];
            $kv = $i['KhuVuc'];
            $mt = $i['MoTa'];
        }
        echo '<form action="" method="post">
        <table class="leave-request-table" align="center">
            <tr>
                <td>Tên Khoa</td>
                <td><input type="text" name="tenkhoa" value="' . $ten . '" style="width:500px;" required></td>
            </tr>
            <tr>
                <td>Khu vực</td>
                <td><input type="text" name="khuvuc" value="' . $kv . '" style="width:500px;" required></td>
            </tr>
            <tr>
                <td>Mô tả</td>
                <td><textarea name="mota" id="mota" cols="30" rows="10" style="width:500px;" required>' . $mt . '</textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="btnSua" class="custom-button"></td>
            </tr>
        </table>
        </form>';
    } else {
        echo '<div align="center">
                <b><a style="color : #FFCC00 ; border:solid 1px; padding:3px;" href="?page=QuanLyKhoa&themKhoa">+ Thêm khoa</a></b>
              </div>';
        echo '<table class="leave-request-table" align="center">
                <tr>
                    <th>STT</th>
                    <th>Tên Khoa</th>
                    <th>Khu vực</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>';
        if (!mysqli_num_rows($dsYCNP) > 0) {
            echo '<tr><td colspan="5">Chưa có Khoa nào!</td></tr>';
        } else {
            $tt = 1;
            foreach ($dsYCNP as $i) {
                echo '<tr>
                        <td>' . $tt++ . '</td>
                        <td>' . $i['TenKhoa'] . '</td>
                        <td>' . $i['KhuVuc'] . '</td>
                        <td>' . $i['MoTa'] . '</td>
                        <td>
                         <button class="icon-btn edit-btn" id="editbtn">
                            <a href="?page=QuanLyKhoa&sua=' . $i['MaKhoa'] . '"  class="btn-link"> <i class="fas fa-edit"></i></a> 
                        </button>
                        <button class="icon-btn delete-btn">
                           <a href="?page=QuanLyKhoa&xoa=' . $i['MaKhoa'] . '" class="btn-link" onclick="return confirm(\'Bạn có chắc muốn xóa Khoa này không?\')">
                             <i class="fas fa-trash-alt"></i></a>
                        </button>
                        </td>
                    </tr>';
            }
        }
        echo '</table>';
    }
    ?>
</div>
