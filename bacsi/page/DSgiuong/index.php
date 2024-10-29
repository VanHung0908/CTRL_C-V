    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 1rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 0.9rem;
        }
        .status {
            font-size: 0.9rem;
            font-weight: bold;
        }
        .bed-icon {
            font-size: 3rem;
        }
        .in-use {
            color: red;
        }
        .reserved {
            color: orange;
        }
        .empty {
            color: blue;
        }
    </style>
    <div class="main-content" id="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <label for="roomSelect" class="form-label">Phòng:</label>
                <select id="roomSelect" class="form-select d-inline-block w-auto">
                    <option selected>Phòng hồi sức</option>
                    <!-- Thêm các phòng khác nếu cần -->
                </select>
            </div>
            <div>
                <button class="btn btn-outline-secondary"><i class="fas fa-calendar-alt"></i> Tháng</button>
                <button class="btn btn-outline-secondary"><i class="fas fa-filter"></i></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">GIƯỜNG 1</span>
                        <span class="status in-use">Đang sử dụng</span>
                    </div>
                    <div class="text-center my-3">
                        <i class="fas fa-bed bed-icon in-use"></i>
                    </div>
                    <div class="card-text">
                        <p>Bệnh nhân: Nguyễn Tấn Đạt</p>
                        <p>Ngày nhập viện: 09/12/2019</p>
                        <p>Tuổi: 21</p>
                        <p>Giới tính: Nam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">GIƯỜNG 2</span>
                        <span class="status in-use">Đang sử dụng</span>
                    </div>
                    <div class="text-center my-3">
                        <i class="fas fa-bed bed-icon in-use"></i>
                    </div>
                    <div class="card-text">
                        <p>Bệnh nhân: Đoàn Thị Mai Linh</p>
                        <p>Ngày nhập viện: 27/12/2019</p>
                        <p>Tuổi: 21</p>
                        <p>Giới tính: Nữ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">GIƯỜNG 3</span>
                        <span class="status in-use">Đang sử dụng</span>
                    </div>
                    <div class="text-center my-3">
                        <i class="fas fa-bed bed-icon in-use"></i>
                    </div>
                    <div class="card-text">
                        <p>Bệnh nhân: Lâm Văn Hưng</p>
                        <p>Ngày nhập viện: 12/12/2019</p>
                        <p>Tuổi: 21</p>
                        <p>Giới tính: Nam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">GIƯỜNG 4</span>
                        <span class="status in-use">Đang sử dụng</span>
                    </div>
                    <div class="text-center my-3">
                        <i class="fas fa-bed bed-icon in-use"></i>
                    </div>
                    <div class="card-text">
                        <p>Bệnh nhân: Trần Hoàng Gia Khánh</p>
                        <p>Ngày nhập viện: 12/11/2019</p>
                        <p>Tuổi: 21</p>
                        <p>Giới tính: Nam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">GIƯỜNG 5</span>
                        <span class="status in-use">Đang sử dụng</span>
                    </div>
                    <div class="text-center my-3">
                        <i class="fas fa-bed bed-icon in-use"></i>
                    </div>
                    <div class="card-text">
                        <p>Bệnh nhân: Châu Duy Khánh</p>
                        <p>Ngày nhập viện: 12/01/2020</p>
                        <p>Tuổi: 21</p>
                        <p>Giới tính: Nam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title">GIƯỜNG 6</span>
                        <span class="status empty">Trống</span>
                    </div>
                    <div class="text-center my-3">
                        <i class="fas fa-bed bed-icon empty"></i>
                    </div>
                    <div class="card-text">
                        <p>Bệnh nhân:</p>
                        <p>Ngày nhập viện:</p>
                        <p>Tuổi:<p>
                        <p>Giới tính:</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
