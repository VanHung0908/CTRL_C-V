<?php include_once '../layout/header.php'?>
  <!-- Header -->
  <div class="section-2-1">
  <div class="inner-wrap wow fadeInRight">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <!-- Optional content can go here -->
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <div class="form-container bg-white p-4 rounded shadow-sml">
          <form class="mt-3" method="POST" >
                <!-- Name input -->
                <div class="form-outline mb-4 mt-3">
                    <label class="form-label" for="formName">Họ và tên</label>
                    <input type="text" id="formName" name="hoTen" class="form-control form-control-lg" placeholder="Nhập họ và tên" onblur="validateName()" required />
                    <small id="nameError" class="form-text text-danger d-none">Họ và tên không hợp lệ.</small>
                </div>

                <!-- Phone input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="formPhone">Số điện thoại</label>
                    <input type="tel" id="formPhone" name="soDienThoai" class="form-control form-control-lg" placeholder="Nhập số điện thoại" onblur="validatePhone()"  required/>
                    <small id="phoneError" class="form-text text-danger d-none">Số điện thoại không hợp lệ. Phải là 10 số và bắt đầu bằng 0.</small>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="formPassword">Mật khẩu</label>
                    <input type="password" id="formPassword" name="matKhau" class="form-control form-control-lg" placeholder="Nhập mật khẩu" onblur="validatePassword()"  required/>
                    <small id="passwordError" class="form-text text-danger d-none">Mật khẩu không hợp lệ. Phải đủ 8 ký tự, có chữ in hoa và ký tự đặc biệt.</small>
                </div>

                <!-- Confirm Password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="formConfirmPassword">Xác nhận mật khẩu</label>
                    <input type="password" id="formConfirmPassword" name="confirmMatKhau" class="form-control form-control-lg" placeholder="Xác nhận mật khẩu" onblur="validateConfirmPassword()" required />
                    <small id="confirmPasswordError" class="form-text text-danger d-none">Mật khẩu xác nhận không trùng khớp.</small>
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                    <button type="submit" name="btn_DangKy" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng ký</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once '../layout/footer.php'?>


  <!-- Import WowJS -->
  <script>
  function validateName() {
    var nameInput = document.getElementById('formName').value;
    var nameError = document.getElementById('nameError');
    
    // Xóa khoảng trắng đầu và cuối, và kiểm tra khoảng trắng dư thừa
    var trimmedName = nameInput.trim().replace(/\s\s+/g, ' ');
    
    if (nameInput !== trimmedName) {
      nameError.textContent = 'Họ và tên không hợp lệ.';
      nameError.classList.remove('d-none');
    } else {
      nameError.classList.add('d-none');
    }
  }

  function validatePhone() {
    var phoneInput = document.getElementById('formPhone').value;
    var phoneError = document.getElementById('phoneError');
    
    // Kiểm tra số điện thoại có phải là 10 số và bắt đầu bằng 0 không
    var phonePattern = /^0\d{9}$/;
    
    if (phonePattern.test(phoneInput)) {
      phoneError.classList.add('d-none');
    } else {
      phoneError.classList.remove('d-none');
    }
  }

  function validatePassword() {
    var passwordInput = document.getElementById('formPassword').value;
    var passwordError = document.getElementById('passwordError');
    
    // Kiểm tra mật khẩu có ít nhất 8 ký tự, một chữ in hoa và một ký tự đặc biệt
    var passwordPattern = /^(?=.*[A-Z])(?=.*[\W_]).{8,}$/;
    
    if (passwordPattern.test(passwordInput)) {
      passwordError.classList.add('d-none');
    } else {
      passwordError.classList.remove('d-none');
    }
  }

  function validateConfirmPassword() {
    var passwordInput = document.getElementById('formPassword').value;
    var confirmPasswordInput = document.getElementById('formConfirmPassword').value;
    var confirmPasswordError = document.getElementById('confirmPasswordError');
    
    if (passwordInput === confirmPasswordInput) {
      confirmPasswordError.classList.add('d-none');
    } else {
      confirmPasswordError.classList.remove('d-none');
    }
  }
</script>


<?php
    if(isset($_POST['btn_DangKy'])){
        include_once('../../controller/cNguoiDung.php');
        $p = new cNguoiDung();
        $con = $p -> addTK($_REQUEST['hoTen'],$_REQUEST['soDienThoai'],$_REQUEST['matKhau']);
    }

?>