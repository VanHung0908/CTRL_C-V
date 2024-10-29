    <div class="sidebar" id="sidebar">
    <ul>
        <li>
            <span class="sidebar-icon"></span><span></span>
        </li>
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
            <a href="index.php?page=DSBN" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-hospital-user"></i></span>
                <span>Danh sách bệnh nhân</span>
            </a>
        </li>

        <li>
        <span class="sidebar-icon"><i class="fa-solid fa-calendar-alt"></i></span>
            <span class="menu-toggle">Lịch làm việc &nbsp; &nbsp;<i class="fa-solid fa-sort-down"></i></span>
            <ul class="submenu">
                <li>Đăng kí lịch</li>
                <li>Xem lịch</li>
                <li>Đăng kí nghỉ phép</li>
            </ul>
        </li>
        <li>
            <a href="index.php?page=QLPK" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-house-user"></i></span> 
                <span>Quản lý phòng khám</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=DSgiuong" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-bed"></i></i></span> 
                <span> Danh sách giường</span>
            </a>
        </li>
        
        <li>
            <a href="index.php?page=dangkykhambenh" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-calendar-check"></i></span> 
                <span>Đăng ký khám bệnh</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=phacdodieutri" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-clipboard-list"></i></span> 
                <span>Phác đồ điều trị</span>
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
            <a href="index.php?page=HoaDon" class="sidebar-link">
                <span class="sidebar-icon"><i class="fa-solid fa-file-invoice-dollar" ></i></span> 
                <span>Hóa đơn</span>
            </a>
        </li>
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