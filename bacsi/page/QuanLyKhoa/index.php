<style>
    .custom-button {
        width: 200px;
        background-color: #66FF00;
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .custom-button:hover {
        background-color: #55cc00;
        transform: scale(1.05);
    }

    .custom-button:active {
        background-color: #4db200;
        transform: scale(0.95);
    }
</style>

<?php
ob_start();
include_once(BACKEND_URL . 'model/mKhoa.php');
$con = new mKhoa;
$dsYCNP = $con->dsKhoa();

$successMessage = '';
//Sua Khoa
$arr = [];
foreach($dsYCNP as $i){
    $arr[] = $i['TenKhoa'];
}

// Xóa khoa
if (isset($_GET['xoa'])) {
    $p = new mKhoa;
    $tbl = $p->xoaKhoa($_GET['xoa']);
    if ($tbl) {
        echo '<script>alert("Xóa khoa thành công !")</script>';
        echo '<script>
            window.location.href = "index.php?page=QuanLyKhoa";
        </script>';
        
    } else {
        $successMessage = 'Xóa khoa thất bại!';
    }
} else if (isset($_POST['btn'])) {
    if(in_array($_POST['tenkhoa'],$arr)){
        echo '<script>alert("Tên khoa đã tồn tại !")</script>';
    }else{
        $tbll = $con->themkhoa($_POST['tenkhoa'], $_POST['khuvuc'], $_POST['mota']);
        if ($tbll) {
            $successMessage = 'Đã thêm khoa thành công!';

        } else {
            $successMessage = 'Thêm khoa thất bại!';
        }
    }
    
    
} else if (isset($_POST['btnSua'])) {
    $layTT = $con->updateKhoa($_POST['tenkhoa'], $_POST['khuvuc'], $_POST['mota'], $_GET['sua']);
    if ($layTT) {
        $successMessage = 'Đã sửa khoa thành công!';

    } else {
        $successMessage = 'Sửa khoa thất bại!';
    }
}
?>
<div class="main-content" id="main-content">
    <h3 align="center" ><a href="index.php?page=QuanLyKhoa" style="color : #4682B4;"><b>QUẢN LÝ KHOA</b></a></h3>


    <?php
    if (isset($_GET['themKhoa'])) {
        echo '<form action="" method="post">
        <table class="leave-request-table" align="center">
            <tr>
                <td>Tên Khoa</td>
                <td><input type="text" name="tenkhoa" style="width:500px; ';if(isset($_POST['tenkhoa'])) echo 'value="'.$_POST['tenkhoa'].'"'; echo'" required></td>
            </tr>
            <tr>
                    <td>Khu vực</td>
                    <td><input type="text" name="khuvuc" style="width:500px;" value="" required></td>
            </tr>
            <tr>
                <td>Mô tả</td>
                <td><textarea name="mota" id="mota" cols="30" rows="10" style="width:500px;" required></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="btn" class="custom-button" ></td>
            </tr>
        </table>
    </form>';
        if ($successMessage) {
            echo '<div id="notificationModal" class="modal" style="display: block;">
                    <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                        <p style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: center;">' . $successMessage . '</p>
                        <button id="closeModal" style="margin-top: 20px; padding: 10px 20px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">Đóng</button>
                    </div>
                  </div>';
        }
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
                <td><textarea name="mota" id="mota" cols="30" rows="10"  style="width:500px;" required>' . $mt . '</textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="btnSua" class="custom-button"></td>
            </tr>
        </table>
    </form>';
        if ($successMessage) {
            echo '<div id="notificationModal" class="modal" style="display: block;">
                    <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                        <p style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: center;">' . $successMessage . '</p>
                        <button id="closeModal" style="margin-top: 20px; padding: 10px 20px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">Đóng</button>
                    </div>
                  </div>';
        }
    } else {
        echo '<form action="" method="post">
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
            echo '<div align="center">
                    <b><a style="color : #FFCC00 ; border:solid 1px; padding:3px;" href="?page=QuanLyKhoa&themKhoa">+ Thêm
                    khoa</a></b>
                </div>';
            $tt = 1;
            foreach ($dsYCNP as $i) {
                echo '<tr>
                            <td>' . $tt++ . '</td>
                            <td>' . $i['TenKhoa'] . '</td>
                            <td>' . $i['KhuVuc'] . '</td>
                            <td>' . $i['MoTa'] . '</td>
                            <td>
                                <a href="?page=QuanLyKhoa&sua=' . $i['MaKhoa'] . '" onclick="openEditModal(' . $i['MaKhoa'] . ')">Sửa</a>
                                <a href="?page=QuanLyKhoa&xoa=' . $i['MaKhoa'] . '" onclick="return confirm(\'Bạn có chắc muốn xóa Khoa này không ?\')">Xóa</a>
                            </td>
                        </tr>';
            }
        }
        // Thong bao 
        if ($successMessage) {
            echo '<div id="notificationModal" class="modal" style="display: block;">
                        <div class="modal-content" style="border-radius: 10px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 100px auto;">
                            <p style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: center;">' . $successMessage . '</p>
                            <button id="closeModal" style="margin-top: 20px; padding: 10px 20px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">Đóng</button>
                        </div>
                      </div>';
        }
    }
    ?>

    </table>


    </form>
</div>
</style>
<script>
    var modal = document.getElementById("notificationModal");
    var notificationCloseModal = document.getElementById("closeModal");

    notificationCloseModal.onclick = function () {
        window.location.href = 'http://localhost/QLBV/bacsi/index.php?page=QuanLyKhoa'; // Quay lại trang khi nhấn nút Đóng
    };

</script>