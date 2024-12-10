<?php
ob_start();
?>

<?php
include_once(BACKEND_URL . 'model/mEmployee.php');
$con = new mEmployee;

if(isset($_POST['chon']) && $_POST['chon'] ==1){
    $dsYCNP = $con->SLLNNPGiam();
}else if(isset($_POST['chon']) && $_POST['chon'] ==3){
    $dsYCNP = $con->DDVATCYCNP();
}else if(isset($_POST['chon']) && $_POST['chon'] ==4){
    $dsYCNP = $con->SuaTTNP();
}else{
    $dsYCNP = $con->dsYCNP();
}
if(isset($_POST['chon']) && $_POST['chon'] == 3){
    echo '<div class="main-content" id="main-content">
<form action="" method="post">
    
</form>

<h3 align="center" style="margin-top:20px;"><b style="color:#D2691E;margin-top:50px;"><a href="index.php?page=DuyetYCNP" style="color:#D2691E;">DANH SÁCH YÊU CẦU NGHỈ PHÉP</a></b></h3>
    <form action="" method="post">
    <table id="hi" align="center">
        <tr>
            <td>
                <select name="chon" id="">
                    <option value="1">Yêu cầu gần hết hạn</option>
                    <option value="3">Đã duyệt/Từ chối</option>  
                    <option value="4">Sửa đổi yêu cầu Đã duyệt/Từ chối</option>  
                    
                </select></td>
            <td>
                <input type="submit" value="Áp dụng" name="btnAD">
            </td>
        </tr>
    </table>
        <table class="leave-request-table" align="center">
            <tr>
                <th>STT</th>
                <th>ID Nhân Viên</th>
                <th>Họ Tên Nhân Viên</th>
                <th>Phòng làm việc</th>
                <th>Ngày Nghỉ Phép</th>
                <th>Ca</th>
                <th>Lý Do</th>
                <th>Thời gian đăng ký</th>
                <th>Trạng thái</th>
            </tr>';
    if (!mysqli_num_rows($dsYCNP) > 0) {
        echo '
        <tr>
        <td colspan="9"> Chưa có yêu cầu nào</td>
        </tr>';
    }else{
        $tt = 1;
    foreach ($dsYCNP as $i) {
        echo '<tr>
                <td>' . $tt++ . '</td>
                <td>' . $i['MaNS'] . '</td>
                <td>' . $i['HoTen'] . '</td>
                <td>' . $i['Phong'] . '</td>
                <td>' . $i['NgayNghiPhep'] . '</td>
                <td>' . $i['CaLam'] . '</td>
                <td>' . $i['LyDo'] . '</td>
                <td>' . $i['ThoiGianDK'] . '</td>
                <td>';
                    if($i['TrangThai'] == 1){
                        echo 'Bạn đã duyệt';
                    }else{
                        echo "Bạn đã từ chối";
                    }
                echo '</td>
            </tr>';
    }
    
    }

    echo '</table>
          </form>
          </div>';
}else if(isset($_POST['chon']) && $_POST['chon'] ==4){
    echo '<div class="main-content" id="main-content">
<form action="" method="post">
    
</form>

<h3 align="center" style="margin-top:20px;"><b style="color:#D2691E;margin-top:50px;"><a href="index.php?page=DuyetYCNP" style="color:#D2691E;">DANH SÁCH YÊU CẦU NGHỈ PHÉP</a></b></h3>
    <form action="" method="post">

    <table id="hi" align="center">
        <tr>
            <td>
                <select name="chon" id="">
                    <option value="1">Yêu cầu gần hết hạn</option>

                    <option value="3">Đã duyệt/Từ chối</option>  
                    <option value="4">Sửa đổi yêu cầu Đã duyệt/Từ chối</option>  
                </select></td>
            <td>
                <input type="submit" value="Áp dụng" name="btnAD">
            </td>
        </tr>
    </table>
        <table class="leave-request-table" align="center">
        <caption>Lưu ý : Bạn đang chọn chức năng thay đổi cái yêu cầu nghỉ phép mà bạn đã duyệt hoặc từ chối. Bạn chỉ được thay đổi những yêu cầu có <b> Ngày nghỉ phép </b> sau hôm nay 1 ngày ! </caption>

        <thead>
            <tr>
                <th>STT</th>
                <th>ID Nhân Viên</th>
                <th>Họ Tên Nhân Viên</th>
                <th>Phòng làm việc</th>
                <th>Ngày Nghỉ Phép</th>
                <th>Ca</th>
                <th>Lý Do</th>
                <th>Thời gian đăng ký</th>
                <th>Trạng thái </th>
                <th>Thao Tác</th>
            </tr>
            </thead>';
    if (!mysqli_num_rows($dsYCNP) > 0) {
        echo '
        <tr>
        <td colspan="10"> Chưa có yêu cầu nào</td>
        </tr>';
        
    }else{
        $tt = 1;
    foreach ($dsYCNP as $i) {
        echo '<tr>
                <td>' . $tt++ . '</td>
                <td>' . $i['MaNS'] . '</td>
                <td>' . $i['HoTen'] . '</td>
                <td>' . $i['Phong'] . '</td>
                <td>' . $i['NgayNghiPhep'] . '</td>
                <td>' . $i['CaLam'] . '</td>
                <td>' . $i['LyDo'] . '</td>
                <td>' . $i['ThoiGianDK'] . '</td>
                <td>';
                    if($i['TrangThai'] == 1){
                        echo 'Bạn đã duyệt';
                    }else{
                        echo "Bạn đã từ chối";
                    }
                echo '</td>
                <td>';
                
                if($i['TrangThai'] == 2){
                    echo '<a href="index.php?page=DuyetYCNP&duyet=' . $i['MaLNP'] . '" onclick="return confirm(\'Bạn có chắc chắn muốn duyệt yêu cầu này không?\');" class="approve-link">Duyệt</a>';
                }else{
                    echo '<a href="#" onclick="showRejectForm(\'' . $i['MaLNP'] . '\', \'' . $i['HoTen'] . '\' ); return false;" class="reject-link">Từ Chối</a>';
                }
                
                
                    
                echo'</td>
            </tr>';
    }
    
    }

    echo '</table>
          </form>
          </div>';

}

else{
echo '<div class="main-content" id="main-content">
<form action="" method="post">
    
</form>

<h3 align="center" style="margin-top:20px;"><b style="color:#D2691E;margin-top:50px;"><a href="index.php?page=DuyetYCNP" style="color:#D2691E;">DANH SÁCH YÊU CẦU NGHỈ PHÉP</a></b></h3>
    <form action="" method="post">
    <table id="hi" align="center">
        <tr>
            <td>
                <select name="chon" id="">
                    <option value="1">Yêu cầu gần hết hạn</option>
                    <option value="3">Đã duyệt/Từ chối</option>  
                    <option value="4">Sửa đổi yêu cầu Đã duyệt/Từ chối</option>  
                </select></td>
            <td>
                <input type="submit" value="Áp dụng" name="btnAD">
            </td>
        </tr>
    </table>
        <table class="leave-request-table" align="center">
            <tr>
                <th>STT</th>
                <th>ID Nhân Viên</th>
                <th>Họ Tên Nhân Viên</th>
                <th>Phòng làm việc</th>
                <th>Ngày Nghỉ Phép</th>
                <th>Ca</th>
                <th>Lý Do</th>
                <th>Thời gian đăng ký</th>
                <th>Thao Tác</th>
                <th>Thao Tác</th>
            </tr>';
    if (!mysqli_num_rows($dsYCNP) > 0) {
        echo '
        <tr>
        <td colspan="10"> Chưa có yêu cầu nào</td>
        </tr>';
        
    }else{
        $tt = 1;
    foreach ($dsYCNP as $i) {
        echo '<tr>
                <td>' . $tt++ . '</td>
                <td>' . $i['MaNS'] . '</td>
                <td>' . $i['HoTen'] . '</td>
                <td>' . $i['Phong'] . '</td>
                <td>' . $i['NgayNghiPhep'] . '</td>
                <td>' . $i['CaLam'] . '</td>
                <td>' . $i['LyDo'] . '</td>
                <td>' . $i['ThoiGianDK'] . '</td>
                <td>
                    <a href="index.php?page=DuyetYCNP&duyet=' . $i['MaLNP'] . '" onclick="return confirm(\'Bạn có chắc chắn muốn duyệt yêu cầu này không?\');" class="approve-link">Duyệt</a>
                </td>
                <td>
                    <a href="#" onclick="showRejectForm(\'' . $i['MaLNP'] . '\', \'' . $i['HoTen'] . '\'); return false;" class="reject-link">Từ Chối</a>
                </td>
            </tr>';
    }
    
    }

    echo '</table>
          </form>
          </div>';
}
?>

<div id="rejectModal" style="display:none; position:fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color:white; border:1px solid #000; padding:20px; z-index:1000;">
    <h3>Nhập lý do từ chối yêu cầu nghỉ phép</h3>
    <form action="" method="post">
        <input type="hidden" id="rejectId" name="rejectId" value="">
        <label for="rejectReason">Lý do:</label><br>
        <textarea id="rejectReason" name="rejectReason" rows="4" cols="50" required></textarea><br>
        <input type="submit" value="Gửi">
        <button type="button" onclick="hideRejectForm()">Hủy</button>
    </form>
</div>

<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.5); z-index:999;"></div>

<script>
    function showRejectForm(id, name) {
        document.getElementById('rejectId').value = id;
        document.getElementById('rejectModal').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function hideRejectForm() {
        document.getElementById('rejectModal').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>

<?php
if (isset($_REQUEST['duyet'])) {
    $p = $con->duyetYCNP($_GET['duyet']);
    if ($p) {
        echo '<script>alert("Bạn đã chọn duyệt yêu cầu này!")</script>';
        echo '<script>
                    window.location.href = "index.php?page=DuyetYCNP";
        </script>';
    } else {
        echo '<script>alert("Có lỗi xảy ra!")</script>';
    }
} else if (isset($_POST['rejectId']) && isset($_POST['rejectReason'])) {
    $rejectId = $_POST['rejectId'];
    $rejectReason = $_POST['rejectReason'];

    // Gọi phương thức từ chối yêu cầu, truyền ID nhân viên và lý do
    $result = $con->tuChoiYCNP($rejectId, $rejectReason);

    if ($result) {
        echo '<script>alert("Bạn đã từ chối yêu cầu thành công!")</script>';
        echo '<script>
                    window.location.href = "index.php?page=DuyetYCNP";
        </script>';
    } else {
        echo '<script>alert("Có lỗi xảy ra khi từ chối yêu cầu!")</script>';
    }
}
?>
<style>
    /* Định dạng cho bảng */
table {
    margin: 20px auto; /* Căn giữa bảng */
    border-collapse: collapse; /* Loại bỏ khoảng trống giữa các ô */
    font-family: Arial, sans-serif; /* Font chữ */
    text-align: center; /* Căn giữa nội dung */
}

/* Định dạng cho ô */
table td {
    padding: 10px 15px; /* Khoảng cách trong ô */
}

/* Định dạng cho select */
select {
    padding: 8px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px; /* Bo góc */
    background-color: #f9f9f9;
    outline: none;
    cursor: pointer;
    transition: all 0.3s ease; /* Hiệu ứng khi hover */
}

select:hover {
    border-color: #007BFF; /* Đổi màu viền khi hover */
    background-color: #e6f0ff; /* Đổi màu nền khi hover */
}
caption {
    display: table-caption; /* Ensure it behaves like a caption */
    caption-side: top; /* Forces the caption to be on top */
    text-align: center; /* Centers the caption */
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 10px; /* Adds space between caption and table */
}

/* Định dạng cho nút */
input[type="submit"] {
    padding: 8px 20px;
    font-size: 14px;
    font-weight: bold;
    color: #fff; /* Màu chữ */
    background-color: #007BFF; /* Màu nền */
    border: none;
    border-radius: 5px; /* Bo góc */
    cursor: pointer;
    transition: background-color 0.3s ease; /* Hiệu ứng khi hover */
}

input[type="submit"]:hover {
    background-color: #0056b3; /* Màu nền khi hover */
}

/* Định dạng cho toàn bảng khi di chuột vào */
table:hover {
    border: 1px solid #ddd; /* Đường viền nhẹ khi hover toàn bảng */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng */
}.approve-link {
    color: green;
}

.reject-link {
    color: red;
}


</style>