<div class="main-content" id="main-content">
    <h3>Lập thủ tục nhập viện</h3>
    <hr class="divider">
    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-section">
                        <h5>Thông tin bệnh nhân</h5>
                        <div class="mb-3">
                            <label for="patientName" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="patientName" value="Lâm Văn Hưng">
                        </div>
                        <div class="mb-3">
                            <label for="patientGender" class="form-label">Giới tính</label>
                            <input type="text" class="form-control" id="patientGender" value="Nam" >
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">SDT</label>
                            <input type="text" class="form-control" id="patientPhone" value="0353627994">
                        </div>
                    </div>
                
                <hr class="divider"> <!-- Thanh gạch ngang -->
                <div class="form-section">
                    <h5>Thông tin người nhà</h5>
                    <div class="mb-3">
                        <label for="relativeName" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="relativeName">
                    </div>
                    <div class="mb-3">
                        <label for="relativeBirthdate" class="form-label">Ngày sinh</label>
                        <input type="text" class="form-control" id="relativeBirthdate">
                    </div>
                    <div class="mb-3">
                        <label for="relativeGender" class="form-label">Giới tính</label>
                        <div>
                            <input type="radio" id="male" name="relativeGender" value="Nam" checked >
                            <label for="male" >Nam</label>
                            <input type="radio" id="female" name="relativeGender" value="Nữ">
                            <label for="female">Nữ</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="relativeRelation" class="form-label">Quan hệ</label>
                        <select class="form-select" id="relativeRelation">
                            <option selected disabled>Chọn quan hệ</option>
                            <option value="Anh">Anh</option>
                            <option value="Em">Em</option>
                            <option value="Cha">Cha</option>
                            <option value="Mẹ">Mẹ</option>
                            <option value="Vợ">Vợ</option>
                            <option value="Chồng">Chồng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="relativeTemporary" class="form-label">Tạm ứng</label>
                        <input type="number" class="form-control" id="relativeTemporary">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-section">
                    <h5>Thông tin nhập viện</h5>
                    <div class="mb-3">
                        <label for="department" class="form-label">Khoa</label>
                        <select class="form-select" id="department">
                            <option selected>Tim mạch</option>
                            <option >Thần kinh</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="doctor" class="form-label">Bác sĩ</label>
                        <select class="form-select" id="doctor">
                            <option selected>Lâm Văn Hưng</option>
                            <option >Nguyễn Tấn Đạt</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Bệnh chuẩn đoán</label>
                        <input type="text" class="form-control" id="diagnosis">
                    </div>
                    <div class="mb-3">
                        <label for="medicalHistory" class="form-label">Tiền sử bệnh</label>
                        <textarea class="form-control" id="medicalHistory" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="medications" class="form-label">Các loại thuốc đang sử dụng</label>
                        <textarea class="form-control" id="medications" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="admissionReason" class="form-label">Lý do nhập viện</label>
                        <textarea class="form-control" id="admissionReason" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-submit" style="background-color: #007bff; color: white;">Nhập viện</button>
        </div>
    </form>
</div>
