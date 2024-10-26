<?php
session_start(); // Bắt buộc khởi động session

// Kiểm tra nếu giá trị của $_SESSION['dangnhap'] khác 1
if (!isset($_SESSION['dangnhap']) || $_SESSION['dangnhap'] != 1) {
    // Chuyển hướng về trang đăng nhập
    header('Location: http://localhost/QLBV/benhnhan/auth/login.php');
    exit(); // Dừng thực thi các đoạn mã phía sau sau khi chuyển hướng
}

include_once ('./layout/head.php');
include_once ('./layout/sidebar.php');
include_once ('./layout/content.php');
?>


    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const menuToggle = document.getElementById('menu-toggle');

        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('shrink');
            if (sidebar.classList.contains('open')) {
                sidebar.style.marginLeft = '0'; // Đẩy sidebar vào
                mainContent.style.marginLeft = '250px'; // Đẩy nội dung vào
            } else {
                sidebar.style.marginLeft = '-250px'; // Ẩn sidebar
                mainContent.style.marginLeft = '0'; // Đẩy nội dung ra
            }
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.querySelector(".menu-toggle");
        const submenu = menuToggle.nextElementSibling; // Lấy menu con kế tiếp

        menuToggle.addEventListener("click", function () {
            submenu.classList.toggle("active"); // Chuyển đổi lớp active
        });
    });
</script>

