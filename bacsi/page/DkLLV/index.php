<?php
include_once(BACKEND_URL . 'model/mEmployee.php');
include_once(BACKEND_URL . 'model/mKhoa.php');
$con = new mEmployee();
$ktra = $con->ktraDaDKL($_SESSION['maNS']);
$conn = new mKhoa;
$tenkhoa = $conn -> dsKhoaByID($_SESSION['maKhoa']);
foreach($tenkhoa as $i){
    $tenn = $i['TenKhoa'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Đăng ký lịch làm việc</title>
    <style>
        .trangDKLICH {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        select {
            width: 22%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            font-size: 16px;
        }
        .blu {
            color: #4682B4;
        }
        .tb{
            color : red;
            font-size:13px;
        }
        .tbDKR{
            color : red;
            font-size:13px;
        }
        .custom-popup {
        max-height: 600px; /* Đặt chiều cao tối đa */
        overflow-y: auto;  /* Cho phép cuộn khi nội dung quá dài */
    }
    </style>
</head>
<body>
    <div class="main-content" id="main-content">
        <div class="trangDKLICH">
            <h3 align="center" class="blu"><b>ĐĂNG KÝ LỊCH KHÁM </b></h3>
            <h5 align="center" class="blu"><b>Khoa <?=$tenn?> </b></h5>
            <?php
            if(mysqli_num_rows($ktra)){
                echo "<h3 align='center'><b class='tbDKR'>Bạn đã đăng ký lịch làm việc!</b></h3>";
            }else{
                echo '<form action="" method="post">
                    <caption><b>* Danh sách phòng có thể thể đăng ký </b></caption> <br> 
                    <select name="selection" id="selection" onchange="getSchedule(this.value)">
                        <option value="" disabled selected>Chọn phòng khám</option>';
                        
                        
                        $phongkham = $con->phongkham($_SESSION['maKhoa']);
                        foreach ($phongkham as $i) {
                            echo '<option value="' . $i['MaPhong'] . '">' . $i['TenPhong'] . '</option>';
                        }
                        
                    echo'</select>
                </form>';
                echo '<div align="right"><a href="#" id="showNotice"><b class="tb">*Lưu ý khi đăng ký lịch làm việc. Xem tại đây !</b></a></div>';
                echo '<div id="div"></div>';
                echo '<div id="lich"></div>';
                echo '<div id="extra-info"></div>';
                
                }
            
            
            ?>
        </div>
    </div>

    <script>
        // Hàm hiển thị thông báo lưu ý khi người dùng nhấn vào liên kết
        $('#showNotice').on('click', function(e) {
    e.preventDefault(); // Ngừng hành động mặc định của liên kết

    // Hiển thị SweetAlert với nội dung thông báo dài
    Swal.fire({
        title: 'Lưu ý khi đăng ký lịch làm việc',
        html: `
            <p><b>1. Nhân viên mới cần đăng ký lịch làm việc sau khi được cấp tài khoản và đăng nhập vào hệ thống quản lý bệnh viện.</b></p>
            <p><b>2. Đăng ký bằng cách : chọn Phòng -> Ca -> Chi tiết ca. Tại đây, anh/ chị có thể xem lịch làm việc theo tuần của ca/ phòng làm việc này.</b></p>
            <p><b>3. Anh/ chị có thể chọn lịch làm việc phù hợp với cá nhân. Có thể chọn phòng và ca làm việc khác để xem chi tiết.</b></p>
            <p><b>4. Anh/ chị cần xem xét kỹ trước khi đăng ký lịch làm việc !</b></p>
        `,
        icon: 'info',
        confirmButtonText: 'Đóng',
        width: '500px', // Điều chỉnh kích thước nếu cần
        customClass: {
            popup: 'custom-popup' // Thêm lớp tùy chỉnh cho SweetAlert
        }
    });
});

        // Hàm lấy lịch làm việc khi chọn phòng khám
        function getSchedule(value) {
            
            $('#extra-info').html('');
            $('#lich').html(''); // Xóa thông tin lịch ca cũ
            $.ajax({
            url: "page/DkLLV/ajax.php", // Thêm timestamp
            type: 'POST',
            data: { value: value },
            success: function(result) {
                $('#div').html(result);
                
            }
        });

        }

        // Hàm lấy thông tin chi tiết ca làm việc
        function getExtraInfo(caID) {
            $('#extra-info').html('');
            $('#lich').html(''); // Xóa thông tin lịch ca cũ
            $.ajax({
                url: "page/DkLLV/extra_ajax.php",
                type: 'POST',
                data: { caID: caID },
                success: function(result) {
                    $('#extra-info').html(result);
                    
                },
                error: function() {
                    alert("Đã xảy ra lỗi khi lấy thông tin chi tiết!");
                }
            });
        }
        function getLich(caID) {
    console.log('CaID:', caID); // Kiểm tra xem caID có đúng không
    
    // Làm sạch lịch cũ trước khi vẽ lại lịch mới
    $('#lich').html('');
    
    $.ajax({
        url: "page/DkLLV/lich.php",
        type: 'POST',
        data: { caID: caID },
        success: function(result) {
            console.log('Kết quả trả về từ server:', result); // Kiểm tra kết quả từ server
            $('#lich').html(result); // Cập nhật lại lịch
            
        },
        error: function() {
            alert("Đã xảy ra lỗi khi lấy thông tin chi tiết!");
        }
    });
}

        // Hàm xử lý đăng ký lịch làm việc
        function registerShift(caID) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn đăng ký lịch làm việc này không?',
                text: "Lịch này sẽ áp dụng suốt thời gian bạn làm việc!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đăng ký',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "page/DkLLV/register.php",
                        type: "POST",
                        data: { caID: caID },
                        success: function(response) {
                            if (response.indexOf('đạt số lượng đăng ký tối đa') !== -1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: response
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đăng ký thành công!',
                                    text: response
                                }).then(() => {
                                    location.reload(); // Tải lại trang
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra khi đăng ký.'
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
