<?php

if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 1;
}
if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = [];
}

$step = $_SESSION['step'];
$data = $_SESSION['data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($step == 1) {
        if (!empty($_POST['phone'])) {
            $data['phone'] = $_POST['phone'];
            $step = 2;
        } else {
            $error = "Số điện thoại không được để trống.";
        }
    } if ($step == 2) {
        if (!empty($_POST['name']) && !empty($_POST['cccd']) && !empty($_POST['address'])) {
            $cccd = $_POST['cccd'];
            $bhytnumber = $_POST['bhytnumber'];
            $email = $_POST['email'];
    
            // Kiểm tra CCCD có đúng 12 chữ số
            if (!preg_match('/^\d{12}$/', $cccd)) {
                $error = "CCCD phải là 12 chữ số.";
            }
            // Kiểm tra BHYT có đúng 10 chữ số
            elseif (!empty($bhytnumber) && !preg_match('/^\d{10}$/', $bhytnumber)) {
                $error = "Mã BHYT phải là 10 chữ số.";
            }
            // Kiểm tra email phải có đuôi @gmail.com
            elseif (!empty($email) && !preg_match('/^[\w\-\.]+@gmail\.com$/', $email)) {
                $error = "Email phải có đuôi @gmail.com.";
            } else {
                $data['name'] = $_POST['name'];
                $data['bhytnumber'] = $bhytnumber;
                $data['cccd'] = $cccd;
                $data['email'] = $email;
                $data['address'] = $_POST['address'];
                $data['gender'] = $_POST['gender'];
                $step = 3; 
            }
        } else {
            $error = "Họ tên, CCCD và địa chỉ không được để trống.";
        }
    
    
    
    } elseif ($step == 3) {
        if (!empty($_POST['appointmentDate'])) {
            $appointmentDate = $_POST['appointmentDate'];
            $currentDate = date("Y-m-d");
    
            // Kiểm tra ngày khám phải sau ngày hiện tại
            if ($appointmentDate > $currentDate) {
                $data['appointmentDate'] = $appointmentDate;
                $step = 4; 
            } else {
                $error = "Ngày khám phải sau ngày hiện tại.";
            }
        } else {
            $error = "Ngày khám không được để trống.";
        }
    
    
    } elseif ($step == 4) {
        if (!empty($_POST['timeSlot'])) {
            $data['timeSlot'] = $_POST['timeSlot'];
            $step = 5; 
        } else {
            $error = "Khung giờ khám không được để trống.";
        }
    } elseif ($step == 5) {
        if (!empty($_POST['specialty'])) {
            $data['specialty'] = $_POST['specialty'];
            $step = 6;  
        } else {
            $error = "Chuyên khoa không được để trống.";
        }
    } elseif ($step == 6) {
        if (!empty($_POST['doctor'])) {
            $data['doctor'] = $_POST['doctor'];
            $message = "Đăng ký khám bệnh thành công.";
            $step = 7; 
        } else {
            $error = "Bác sĩ không được để trống.";
        }
    }

    $_SESSION['step'] = $step;
    $_SESSION['data'] = $data;
}

if ($step == 7) {
    session_unset();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Khám Bệnh</title>
    <style>
   
    h1 {
        text-align: center;
        color: #333;
    }

    label {
        display: block;
        margin: 10px 0 5px;
    }

    input,
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: #218838;
    }

    .message {
        margin: 20px 0;
        padding: 10px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 4px;
        text-align: center;
    }

    .error {
        margin: 20px 0;
        padding: 10px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
        text-align: center;
    }
    </style>
</head>

<body>
<div class="main-content" id="main-content">
        <h1>Đăng Ký Khám Bệnh</h1>

        <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <?php if ($step == 1): ?>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" required>
            <button type="submit">Tiếp tục</button>

            <?php elseif ($step == 2): ?>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" required>
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>"
                required>
            <label for="bhytnumber">Mã BHYT:</label>
            <input type="text" id="bhytnumber" name="bhytnumber"
                value="<?php echo isset($data['bhytnumber']) ? $data['bhytnumber'] : ''; ?>">
            <label for="cccd">CCCD:</label>
            <input type="text" id="cccd" name="cccd" value="<?php echo isset($data['cccd']) ? $data['cccd'] : ''; ?>"
                required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address"
                value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>" required>
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender" required>
                <option value="nam"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="nữ"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nữ') ? 'selected' : ''; ?>>Nữ
                </option>
            </select>
            <button type="submit">Tiếp tục</button>

            <?php elseif ($step == 3): ?>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" required>
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>"
                required>
            <label for="bhytnumber">Mã BHYT:</label>
            <input type="text" id="bhytnumber" name="bhytnumber"
                value="<?php echo isset($data['bhytnumber']) ? $data['bhytnumber'] : ''; ?>">
            <label for="cccd">CCCD:</label>
            <input type="text" id="cccd" name="cccd" value="<?php echo isset($data['cccd']) ? $data['cccd'] : ''; ?>"
                required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address"
                value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>" required>
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender" required>
                <option value="nam"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="nữ"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nữ') ? 'selected' : ''; ?>>Nữ
                </option>
            </select>
            <label for="appointmentDate">Ngày khám:</label>
            <input type="date" id="appointmentDate" name="appointmentDate" required>
            <button type="submit">Tiếp tục</button>

            <?php elseif ($step == 4): ?>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" required>
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>"
                required>
            <label for="bhytnumber">Mã BHYT:</label>
            <input type="text" id="bhytnumber" name="bhytnumber"
                value="<?php echo isset($data['bhytnumber']) ? $data['bhytnumber'] : ''; ?>">
            <label for="cccd">CCCD:</label>
            <input type="text" id="cccd" name="cccd" value="<?php echo isset($data['cccd']) ? $data['cccd'] : ''; ?>"
                required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address"
                value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>" required>
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender" required>
                <option value="nam"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="nữ"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nữ') ? 'selected' : ''; ?>>Nữ
                </option>
            </select>
            <label for="appointmentDate">Ngày khám:</label>
            <input type="date" id="appointmentDate" name="appointmentDate"
                value="<?php echo isset($data['appointmentDate']) ? $data['appointmentDate'] : ''; ?>" required>
            <label for="timeSlot">Khung giờ khám:</label>
            <select id="timeSlot" name="timeSlot" required>
                <option value="sáng">Sáng</option>
                <option value="chiều">Chiều</option>
            </select>
            <button type="submit">Tiếp tục</button>

            <?php elseif ($step == 5): ?>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" required>
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>"
                required>
            <label for="bhytnumber">Mã BHYT:</label>
            <input type="text" id="bhytnumber" name="bhytnumber"
                value="<?php echo isset($data['bhytnumber']) ? $data['bhytnumber'] : ''; ?>">
            <label for="cccd">CCCD:</label>
            <input type="text" id="cccd" name="cccd" value="<?php echo isset($data['cccd']) ? $data['cccd'] : ''; ?>"
                required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address"
                value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>" required>
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender" required>
                <option value="nam"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="nữ"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nữ') ? 'selected' : ''; ?>>Nữ
                </option>
            </select>
            <label for="appointmentDate">Ngày khám:</label>
            <input type="date" id="appointmentDate" name="appointmentDate"
                value="<?php echo isset($data['appointmentDate']) ? $data['appointmentDate'] : ''; ?>" required>
            <label for="timeSlot">Khung giờ khám:</label>
            <select id="timeSlot" name="timeSlot" required>
                <option value="sáng">Sáng</option>
                <option value="chiều">Chiều</option>
            </select>
            <label for="specialty">Chuyên khoa:</label>
            <select id="specialty" name="specialty" required>
                <option value="nội khoa">Nội khoa</option>
                <option value="ngoại khoa">Ngoại khoa</option>
                <option value="răng hàm mặt">Răng hàm mặt</option>
            </select>
            <button type="submit">Tiếp tục</button>

            <?php elseif ($step == 6): ?>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" required>
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>"
                required>
            <label for="bhytnumber">Mã BHYT:</label>
            <input type="text" id="bhytnumber" name="bhytnumber"
                value="<?php echo isset($data['bhytnumber']) ? $data['bhytnumber'] : ''; ?>">
            <label for="cccd">CCCD:</label>
            <input type="text" id="cccd" name="cccd" value="<?php echo isset($data['cccd']) ? $data['cccd'] : ''; ?>"
                required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address"
                value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>" required>
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender" required>
                <option value="nam"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="nữ"
                    <?php echo (isset($data['gender']) && $data['gender'] === 'nữ') ? 'selected' : ''; ?>>Nữ
                </option>
            </select>
            <label for="appointmentDate">Ngày khám:</label>
            <input type="date" id="appointmentDate" name="appointmentDate"
                value="<?php echo isset($data['appointmentDate']) ? $data['appointmentDate'] : ''; ?>" required>
            <label for="timeSlot">Khung giờ khám:</label>
            <select id="timeSlot" name="timeSlot" required>
                <option value="sáng">Sáng</option>
                <option value="chiều">Chiều</option>
            </select>
            <label for="specialty">Chuyên khoa:</label>
            <select id="specialty" name="specialty" required>
                <option value="nội khoa">Nội khoa</option>
                <option value="ngoại khoa">Ngoại khoa</option>
                <option value="răng hàm mặt">Răng hàm mặt</option>
            </select>
            <label for="doctor">Bác sĩ:</label>
            <select id="doctor" name="doctor" required>
                <option value="bs1">Bác sĩ 1</option>
                <option value="bs2">Bác sĩ 2</option>
                <option value="bs3">Bác sĩ 3</option>
            </select>
            <button type="submit">Tiếp tục</button>

            <?php endif; ?>
        </form>
    </div>
</body>

</html>