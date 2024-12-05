    <?php
    session_start(); // Bắt buộc khởi động session

    // Kiểm tra nếu giá trị của $_SESSION['dangnhap'] khác 1
    if (!isset($_SESSION['dangnhap']) || $_SESSION['dangnhap'] != 2) {
        // Chuyển hướng về trang đăng nhập
        header('Location: http://localhost/QLBV/');
        exit(); // Dừng thực thi các đoạn mã phía sau sau khi chuyển hướng
    }
    //echo 'day la ' .$_SESSION['maKhoa'];
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
        
        // Nếu trang là xemchitiet, thì xử lý khác
        switch ($page) {
            #DSBN
            case 'xemchitiet':
                $pagePath = "./page/DSBN/xemchitiet.php"; 
                break;
            case 'lapphieukham':
                $pagePath = "./page/DSBN/lapphieukham.php";
                break;
            case 'laphoadon':
                $pagePath = "./page/DSBN/laphoadon.php";
                break;
            case 'nhapvien':
                $pagePath = "./page/DSBN/nhapvien.php";
                break;
            #hóa đơn
            case 'thanhtoan':
                $pagePath = "./page/HoaDon/hoadon.php";
                break;

            #NVQLNgoaiTru
            case 'capnhatthongtinNV':
                $pagePath = "./page/DSnhapvien/capnhatthongtin.php";
                break;
           
            default:
                $pagePath = "./page/{$page}/index.php"; 
                break;
        }
        if (file_exists($pagePath)) {
            include_once ('./layout/head.php'); 
            include_once ('./layout/sidebar.php'); 
            include_once $pagePath; 
        } else {
            include_once "./page/404.php"; 
        }
    } else {
        include_once ('./layout/head.php'); 
        include_once ('./layout/sidebar.php'); 
        include_once "./page/content.php"; 
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

