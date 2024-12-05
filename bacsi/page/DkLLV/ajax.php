<style>
    .schedule-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    }
    .schedule-table th, .schedule-table td {
    border: 1px solid #ddd;
    text-align: center;
    padding: 8px;
    height: 40px; 
    overflow: hidden; 
    white-space: nowrap;
    text-overflow: ellipsis; 
    
}

    .schedule-table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    }

    .details-table{
        margin-top:20px;

    }

    .color{
        color:#D2691E;
    }
    
    
    .register-btn {
    margin-top : 20px;
    display: flex; 
    padding: 10px 20px; 
    font-size: 16px; 
    font-weight: bold; 
    color: white; 
    background-color: #FFA500;
    border: none; 
    border-radius: 5px; 
    cursor: pointer; 
    text-align: center; 
    transition: all 0.3s ease; 
    
    }

    .register-btn:hover {
    background-color: #FFA500;
    transform: scale(1.05); 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
    }

    .register-btn:active {
    background-color: #FF4500; 
    transform: scale(0.98); 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
    }

</style>
<?php
    include_once('../../../model/mEmployee.php');
    $con = new mEmployee();
    $result = $con->chitietphongbyID($_POST['value']);
?>
<div class="schedule-list">
    <h5 align="center"><b class="color">DANH SÁCH CA LÀM VIỆC</b></h5>
    <table class="schedule-table">
        <thead>
            <tr>
                <th></th>
                <th>STT</th>
                <th>Tên ca làm</th>
                <th>Đã đăng ký</th>
                <th>Đăng ký tối đa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) == 0) {
                echo '<tr>';
                echo '<td colspan="5">';
                echo 'Phòng này đang lên kế hoạch !';
                echo '</td>';
                echo '</tr>';
            }else{
                $dem = 1;
                foreach ($result as $i) {
                    echo '<tr>';
                    echo '<td><input type="radio" name="shift" onclick="getExtraInfo(' . $i['MaCTPhongKham'] . ')"></td>';
                    echo '<td>' . $dem++ . '</td>';
                    echo '<td>' . htmlspecialchars($i['TenCa']) . '</td>';
                    echo '<td>' . $i['DaDangKy'] . '</td>';
                    echo '<td>' . $i['DangKyToiDa'] . '</td>';
                    echo '</tr>';
                }
            }
            
            ?>
        </tbody>
    </table>
</div>



