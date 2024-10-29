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
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">Khoa điều trị</label>
                            <input type="text" class="form-control" id="patientPhone" value="Khoa Nội tim mạch">
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">Bác sĩ điều trị</label>
                            <input type="text" class="form-control" id="patientPhone" value="Lâm Văn H">
                        </div>
                    </div>
                
                
            </div>
            <div class="col-md-6">
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
                    <br>
                    <hr class="divider">

                    <h5>Thông tin phòng bệnh</h5>
                    <div class="mb-3">
                        <label for="relativeRelation" class="form-label">Phòng</label>
                        <select class="form-select" id="relativeRelation">
                            <option selected disabled>Chọn phòng bệnh</option>
                            <option value="P01">P01</option>
                            <option value="P02">P02</option>
                            <option value="P03">P03</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="relativeRelation" class="form-label">Giường</label>
                        <select class="form-select" id="relativeRelation">
                            <option selected disabled>Chọn giường bệnh</option>
                            <option value="G01">G01</option>
                            <option value="G02">G02</option>
                            <option value="G03">G03</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-submit" style="background-color: #007bff; color: white;">Lưu</button>
        </div>
    </form>
</div>
