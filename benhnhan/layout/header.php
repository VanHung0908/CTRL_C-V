<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="/QLBV/assets/images/logo.png">
  <title>Bệnh viện Barry</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
    integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="/QLBV/assets/css/style.css">
  <link rel="stylesheet" href="/QLBV/assets/css/base.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<!-- Popper.js (cần thiết cho Bootstrap dropdown) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<?php
include(__DIR__ . '/../../model/ketnoi.php');

    session_start(); 
    if (isset($_SESSION['dangnhap']) && $_SESSION['dangnhap'] == 1 && isset($_SESSION['maBN'])) {
      include_once(BACKEND_URL . 'model/mBenhNhan.php');
      $model = new mBenhNhan();
      
      // Lấy maBN từ session
      $maBN = $_SESSION['maBN'];
      
      // Lấy HoTen từ model
      $hoTen = $model->getHoTenByMaBN($maBN);
  }
 ?>
<body>

  <!-- Pre Header -->

  <div class="pre-header">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="inner-wrap">
            <div class="inner-left">
              <div class="inner-dsc-top">
                Hotline khẩn cấp
              </div>
              <div class="inner-dsc-bottom">
                1900 999 999
              </div>
            </div>
            <div class="inner-main">
            <a href="/QLBV/index.php"><img src="/QLBV/assets/images/Barry.png" alt=""></a>
            </div>
            <div class="inner-right">
              <div class="inner-dsc-top">
                Tư vấn trực tuyến
              </div>
              <div class="inner-dsc-bottom">
                Barry@gmail.com
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Pre Header -->


  <!-- Header --> 

  <div class="header">
    <div class="row">
        <div class="col-xl-12">
            <ul class="inner-menu">
                <li>
                    <a href="/QLBV">TRANG CHỦ</a>
                </li>
                <li>
                    <a href="/QLBV/#gioi-thieu">GIỚI THIỆU</a>
                </li>
                <li>
                    <a href="/QLBV/#dich-vu">DỊCH VỤ</a>
                </li>
                <li>
                    <?php if (isset($_SESSION['dangnhap']) && $_SESSION['dangnhap'] == 1): ?>
                        <a href="/QLBV/benhnhan/page/datlich.php">ĐẶT LỊCH</a> <!-- Trang đặt lịch -->
                    <?php else: ?>
                        <a href="/QLBV/benhnhan/auth/login.php">ĐẶT LỊCH</a> <!-- Chuyển đến trang đăng nhập -->
                    <?php endif; ?>
                </li>
                <li class="nav-item dropdown">
                    <?php if (isset($_SESSION['dangnhap']) && $_SESSION['dangnhap'] == 1): ?>
                      <a href="#" id="navItem" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <?php echo htmlspecialchars(strtoupper($hoTen)); ?> <b class="caret"></b>
                      </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/QLBV/benhnhan/page/HSBA.php">Hồ sơ bệnh nhân</a>
                            <a class="dropdown-item" href="/QLBV/benhnhan/page/TTCN.php">Thông tin cá nhân</a>
                            <a class="dropdown-item" href="/QLBV/benhnhan/auth/logout.php">Đăng xuất</a>
                        </div>
                    <?php else: ?>
                        <a class="nav-link" href="/QLBV/benhnhan/auth/login.php">ĐĂNG NHẬP</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    // Độ cao tối thiểu để menu chuyển sang vị trí cố định
    const fixedHeaderHeight = 50; // có thể thay đổi theo nhu cầu

    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Kiểm tra nếu scroll >= fixedHeaderHeight thì thêm lớp fixed
        if (scrollTop >= fixedHeaderHeight) {
            header.classList.add('fixed');
        } else {
            header.classList.remove('fixed');
        }
    });
</script>
