    <?php
    session_start(); 

    if (!isset($_SESSION['dangnhap']) || $_SESSION['dangnhap'] != 2) {
        // Chuyển hướng về trang đăng nhập
        header('Location: http://localhost/QLBV/');
        exit(); // Dừng thực thi các đoạn mã phía sau sau khi chuyển hướng
    }

    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
        
        // Nếu trang là xemchitiet, thì xử lý khác
        switch ($page) {
            #QLNS
            case 'QuanLyNhanSu':
                if (isset($_REQUEST['sua'])) {
                    $pagePath = "./page/QuanLyNhanSu/suaNhanSu.php";
                } else {
                    $pagePath = "./page/QuanLyNhanSu/index.php";
                }
                break;
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
            case 'capnhattt':
                $pagePath = "./page/DSBN/capnhattt.php";
                break;
            #Nhập viện
            case 'TTNhapVien':
                $pagePath = "./page/DSBNNV/TTNhapVien.php";
                break;
             #Xuất viện
             case 'laphoadonXV':
                $pagePath = "./page/DSXuatVien/laphoadon.php";
                break;
            #hóa đơn
            case 'thanhtoan':
                $pagePath = "./page/HoaDon/hoadon.php";
                break;
            #nội trú
            case 'lapphacdo':
                $pagePath = "./page/DSBNNT/lapphacdo.php";
                break;
            case 'xuatvien':
                $pagePath = "./page/DSBNNT/xuatvien.php";
                break;
            case 'xembenhan':
                $pagePath = "./page/DSBNNT/xembenhan.php";
                break;
            case 'phieuchamsoc':
                $pagePath = "./page/DSBNNT/phieuchamsoc.php";
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
        include_once "./page/CaNhan/index.php"; 
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

