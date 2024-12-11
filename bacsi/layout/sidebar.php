<?php
$maCV = $_SESSION['maCV'];  
?>
<div class="sidebar" id="sidebar">
    <ul>
        <li>
            <span class="sidebar-icon"></span><span></span>
        </li>
        <?php if ($maCV == 1): ?>
            <li>
                <a href="index.php?page=QuanLyNhanSu" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-users"></i></span> 
                    <span>Quản lý nhân sự</span>
                </a>
            </li>
            <li>
                <a href="index.php?page=QuanLyKhoa" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-hospital"></i></span> 
                    <span>Quản lý khoa</span>
                </a>
            </li>
            <li>
                <a href="index.php?page=HTDSBN" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-hospital-user"></i></span>
                    <span>Danh sách bệnh nhân</span>
                </a>
            </li>
        <?php elseif ($maCV == 2): ?>
            <li>
                <a href="index.php?page=QLP" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-house"></i></span>
                    <span>Quản lý Phòng</span>
                </a>
            </li>
           
            <li>
                <a href="index.php?page=DuyetYCNP" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-house-user"></i></span> 
                    <span>Duyệt nghỉ phép</span>
                </a>
            </li>
        <?php elseif ($maCV == 3): ?>

            <li>
                <a href="index.php?page=QLPK" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-house-user"></i></span> 
                    <span>Quản lý ca trực</span>
                </a>
            </li>
            <li>
                <a href="index.php?page=DuyetYCNP" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-house-user"></i></span> 
                    <span>Duyệt nghỉ phép</span>
                </a>
            </li>
            <li>
                <a href="index.php?page=DSXV" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-clipboard-list"></i></span> 
                    <span>Danh sách xuất viện</span>
                </a>
            </li>
        <?php elseif ($maCV == 4): ?>
            <li>
                <a href="index.php?page=DSBN" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-hospital-user"></i></span>
                    <span>Danh sách bệnh nhân</span>
                </a>
            </li>
            <li>
                <span class="sidebar-icon"><i class="fa-solid fa-calendar-alt"></i></span>
                <span class="menu-toggle">Lịch làm việc &nbsp; &nbsp;<i class="fa-solid fa-sort-down"></i></span>
                <ul class="submenu">
                    <li><a href="index.php?page=DKLLV">Đăng kí lịch</a></li>
                    <li><a href="index.php?page=XemLich">Xem lịch</a> </li>
                    <li><a href="index.php?page=NghiPhep">Nghỉ phép</a></li>
                </ul>
            </li>
        <?php elseif ($maCV == 5): ?>
            <li>
                <a href="index.php?page=DSBNNT" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-hospital-user"></i></span>
                    <span>Danh sách bệnh nhân</span>
                </a>
            </li>
            <li>
                <span class="sidebar-icon"><i class="fa-solid fa-calendar-alt"></i></span>
                <span class="menu-toggle">Lịch làm việc &nbsp; &nbsp;<i class="fa-solid fa-sort-down"></i></span>
                <ul class="submenu">
                <li><a href="index.php?page=DKLLV">Đăng kí lịch</a></li>
                    <li><a href="index.php?page=XemLich">Xem lịch</a> </li>
                    <li><a href="index.php?page=NghiPhep">Nghỉ phép</a></li>
                </ul>
            </li>
         
        <?php elseif ($maCV == 6 ): ?>
          
            <li>
                <a href="index.php?page=DSBN" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-hospital-user"></i></span>
                    <span>Danh sách bệnh nhân</span>
                </a>
            </li>
            <li>
                <a href="index.php?page=dangkykhambenh" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-calendar-check"></i></span> 
                    <span>Đăng ký khám bệnh</span>
                </a>
            </li>
           
          
            <li>
                <span class="sidebar-icon"><i class="fa-solid fa-calendar-alt"></i></span>
                <span class="menu-toggle">Lịch làm việc &nbsp; &nbsp;<i class="fa-solid fa-sort-down"></i></span>
                <ul class="submenu">
                    <li><a href="index.php?page=DKLLV">Đăng kí lịch</a></li>
                    <li><a href="index.php?page=XemLich">Xem lịch</a> </li>
                    <li><a href="index.php?page=NghiPhep">Nghỉ phép</a></li>
                </ul>
            </li>
            
           
        <?php elseif ( $maCV == 7): ?>
            <li>
                <a href="index.php?page=DSgiuong" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-bed"></i></i></span> 
                    <span> Danh sách giường</span>
                </a>
            </li>
            <li>
                <a href="index.php?page=DSBNNV" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-hospital-user"></i></span>
                    <span>Tiếp nhận bệnh án</span>
                </a>
            </li>
           
            <li>
                <span class="sidebar-icon"><i class="fa-solid fa-bed-pulse"></i></span>
                <span class="menu-toggle">Nội trú &nbsp; &nbsp;<i class="fa-solid fa-sort-down"></i></span>
                <ul class="submenu">
                    <li>
                        <a href="index.php?page=DSnhapvien">
                            Danh sách nhập viện
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=DSxuatvien">
                            Danh sách xuất viện
                        </a>
                    </li>
                </ul>
            </li>
          
            <li>
                <span class="sidebar-icon"><i class="fa-solid fa-calendar-alt"></i></span>
                <span class="menu-toggle">Lịch làm việc &nbsp; &nbsp;<i class="fa-solid fa-sort-down"></i></span>
                <ul class="submenu">
                    <li><a href="index.php?page=DKLLV">Đăng kí lịch</a></li>
                    <li><a href="index.php?page=XemLich">Xem lịch</a> </li>
                    <li><a href="index.php?page=NghiPhep">Nghỉ phép</a></li>
                </ul>
            </li>
            <?php elseif ( $maCV == 8): ?>
            <li>
                <a href="index.php?page=DSgiuong" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-bed"></i></i></span> 
                    <span> Danh sách giường</span>
                </a>
            </li>
            <li>
                <a href="index.php?page=DSBNNT" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fa-solid fa-hospital-user"></i></span>
                    <span>Danh sách bệnh nhân</span>
                </a>
            </li>
            
          
            <li>
                <span class="sidebar-icon"><i class="fa-solid fa-calendar-alt"></i></span>
                <span class="menu-toggle">Lịch làm việc &nbsp; &nbsp;<i class="fa-solid fa-sort-down"></i></span>
                <ul class="submenu">
                    <li><a href="index.php?page=DKLLV">Đăng kí lịch</a></li>
                    <li><a href="index.php?page=XemLich">Xem lịch</a> </li>
                    <li><a href="index.php?page=NghiPhep">Nghỉ phép</a></li>
                </ul>
            </li>
           
        <?php endif; ?>   
        
        <li>
            <a href="index.php?page=CaNhan" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                <span>Cá nhân</span>
            </a>
        </li>
        <li>
            <a href="/QLBV/benhnhan/auth/logout.php" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                <span>Đăng xuất</span>
            </a>
        </li>
    </ul>
</div>
<script>
    document.querySelectorAll('.menu-toggle').forEach(item => {
    item.addEventListener('click', function () {
        const submenu = this.nextElementSibling;
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
    });
});

</script>