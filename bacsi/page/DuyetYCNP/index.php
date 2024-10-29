<?php
ob_start();
?>
<style>
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* modal */
    #rejectModal {
        width: 50%;
        border-radius: 8px;
    }

    #rejectModal h3 {
        margin-top: 0;
    }

    #rejectModal textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        resize: vertical;
    }

    #rejectModal input[type="submit"] {
        background-color: #d9534f;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
    }

    #rejectModal input[type="submit"]:hover {
        background-color: #c9302c;
    }

    #rejectModal button {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
        margin-left: 10px;
    }

    #rejectModal button:hover {
        background-color: #5a6268;
    }

    /* CSS cho overlay */
    #overlay {
        background-color: rgba(0, 0, 0, 0.6);
    }
</style>
<td  ></td>
<?php
include_once(BACKEND_URL . 'model\mEmployee.php');
$con = new mEmployee;
$dsYCNP = $con->dsYCNP();


    echo '<div class="main-content" id="main-content">
    <form action="" method="post">
        <table border="1" align="center">
            <tr>
                <th>STT</th>
                <th>ID Nhân Viên</th>
                <th>Họ Tên Nhân Viên</th>
                <th>Ngày Nghỉ Phép</th>
                <th>Lý Do</th>
                <th>Thao Tác</th>
                <th>Thao Tác</th>
            </tr>';
    if (!mysqli_num_rows($dsYCNP) > 0) {
        echo '
        <tr>
        <td colspan="7"> Chưa có yêu cầu nào</td>
        </tr>';
        
    }else{
        $tt = 1;
    foreach ($dsYCNP as $i) {
        echo '<tr>
                <td>' . $tt++ . '</td>
                <td>' . $i['MaNS'] . '</td>
                <td>' . $i['hoTen'] . '</td>
                <td>' . $i['NgayNghiPhep'] . '</td>
                <td>' . $i['LyDo'] . '</td>
                <td>
                    <a href="?duyet=' . $i['maLNP'] . '" onclick="return confirm(\'Bạn có chắc chắn muốn duyệt yêu cầu này không?\');">Duyệt</a>
                </td>
                <td>
                    <a href="#" onclick="showRejectForm(\'' . $i['maLNP'] . '\', \'' . $i['hoTen'] . '\'); return false;">Từ Chối</a>
                </td>
            </tr>';
    }
    
    }

    echo '</table>
          </form>
          </div>';

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
if (isset($_GET['duyet'])) {
    $p = $con->duyetYCNP($_GET['duyet']);
    if ($p) {
        echo '<script>alert("Bạn đã chọn duyệt yêu cầu này!")</script>';
        header('refresh:0,url=duyetYCNP.php');
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
    } else {
        echo '<script>alert("Có lỗi xảy ra khi từ chối yêu cầu!")</script>';
    }
}
?>