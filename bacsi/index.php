    <?php
    session_start(); // Bắt buộc khởi động session

    // Kiểm tra nếu giá trị của $_SESSION['dangnhap'] khác 1
    if (!isset($_SESSION['dangnhap']) || $_SESSION['dangnhap'] != 1) {
        // Chuyển hướng về trang đăng nhập
        header('Location: http://localhost/QLBV/benhnhan/auth/login.php');
        exit(); // Dừng thực thi các đoạn mã phía sau sau khi chuyển hướng
    }

    // Kiểm tra xem có trang nào được yêu cầu không
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
        // Chú ý tên thư mục, bạn có thể cần sửa thành "QLNS"
        $pagePath = "./page/{$page}/index.php"; // Đường dẫn đến file index.php trong thư mục
        
        // Kiểm tra xem file có tồn tại không
        if (file_exists($pagePath)) {
            include_once ('./layout/head.php'); // Bao gồm header nếu file tồn tại
            include_once ('./layout/sidebar.php'); // Bao gồm sidebar nếu file tồn tại
            include_once $pagePath; // Bao gồm file nếu tồn tại
        } else {
            // Nếu không tìm thấy trang, hiển thị trang 404 mà không có header và sidebar
            include_once "./page/404.php"; // Hiển thị trang lỗi nếu không tìm thấy
        }
    } else {
        include_once ('./layout/head.php'); // Bao gồm header cho trang mặc định
        include_once ('./layout/sidebar.php'); // Bao gồm sidebar cho trang mặc định
        include_once "./page/content.php"; // Hiển thị trang mặc định nếu không có page nào được chỉ định
    }
    
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

