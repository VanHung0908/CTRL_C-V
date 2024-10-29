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
                            <label for="patientName" class="form-label">Ngày sinh</label>
                            <input type="text" class="form-control" id="patientName" value="09/08/2003">
                        </div>
                        <div class="mb-3">
                            <label for="patientGender" class="form-label">Giới tính</label>
                            <input type="text" class="form-control" id="patientGender" value="Nam" >
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">SDT</label>
                            <input type="text" class="form-control" id="patientPhone" value="0353627994">
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">CCCD</label>
                            <input type="text" class="form-control" id="patientPhone" value="1122334455">
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">BHYT</label>
                            <input type="text" class="form-control" id="patientPhone" value="SV111222333444">
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">Địa chỉ thường trú</label>
                            <input type="text" class="form-control" id="patientPhone" value="Q.Gò Vấp, TP Hồ Chí Minh">
                        </div>
                    </div>
                
            </div>
            <div class="col-md-6">
                <div class="form-section">
                    <h5>Thông tin nhập viện</h5>
                    <div class="mb-3">
                        <label for="department" class="form-label">Khoa</label>
                        <select class="form-select" id="department">
                            <option selected >Chọn khoa</option>
                            <option >Tim mạch</option>
                            <option >Thần kinh</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="doctor" class="form-label">Bác sĩ</label>
                        <select class="form-select" id="doctor">
                            <option selected disabled>Chọn bác sĩ</option>
                            <option >Lâm Văn Hưng</option>
                            <option >Nguyễn Tấn Đạt</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Bệnh chuẩn đoán</label>
                        <input type="text" class="form-control" id="diagnosis">
                    </div>
                    <div class="mb-3">
                        <label for="medicalHistory" class="form-label">Tiền sử bệnh</label>
                        <textarea class="form-control" id="medicalHistory" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="medications" class="form-label">Các loại thuốc đang sử dụng</label>
                        <textarea class="form-control" id="medications" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="admissionReason" class="form-label">Lý do nhập viện</label>
                        <textarea class="form-control" id="admissionReason" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-submit" style="background-color: #007bff; color: white;">Nhập viện</button>
        </div>
    </form>
</div>
