<?php include_once '../layout/header.php'?>

  <!-- Header -->
  <div class="section-2-1">
  <div class="inner-wrap wow fadeInRight">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <!-- Optional content can go here -->
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 ">
          <div class="form-container bg-white p-4 rounded shadow-sml">
            <form class="mt-3"  method="POST">
              <!-- SDT input -->
              <div class="form-outline mb-4 mt-3">
                <label class="form-label" for="form3Example3">Tên đăng nhập / Số điện thoại</label>
                <input type="text"  name="txtTND" class="form-control form-control-lg" placeholder="Nhập tên đăng nhập"  onblur="validatePhoneNumber()"  />
                <small id="phoneError" class="form-text text-danger d-none">Số điện thoại không hợp lệ. Phải là 10 số và bắt đầu bằng 0.</small>
              </div>

              <!-- Password input -->
              <div class="form-outline mb-3">
                <label class="form-label" for="form3Example4">Mật khẩu</label>
                <input type="password" name="txtMK" id="formPassword" class="form-control form-control-lg" placeholder="Nhập mật khẩu"  onblur="validatePassword()"/>
                <small id="passwordError" class="form-text text-danger d-none">Mật khẩu không hợp lệ. Phải đủ 8 ký tự, có chữ in hoa và ký tự đặc biệt.</small>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <!-- Checkbox -->
                <div class="form-check mb-0">
                  <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                  <label class="form-check-label" for="form2Example3">
                    Ghi nhớ mật khẩu
                  </label>
                </div>
                <a href="#!" class="text-body">Quên mật khẩu?</a>
              </div>

              <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" name="btn_DangNhap" id="submitButton"  class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">Chưa có tài khoản?
                  <a href="./signup.php" class="link-danger" style="text-decoration: underline;">Đăng ký ngay</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once '../layout/footer.php'?>
   
<script>
  function validatePhoneNumber() {
    var phoneInput = document.getElementById('phoneInput').value;
    var phoneError = document.getElementById('phoneError');

    // Kiểm tra số điện thoại có phải là 10 số và bắt đầu bằng 0 không
    var phonePattern = /^0\d{9}$/;

    if (phonePattern.test(phoneInput)) {
      // Số điện thoại hợp lệ
      phoneError.classList.add('d-none');
    } else {
      // Số điện thoại không hợp lệ
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

</script>
<?php
    if(isset($_POST['btn_DangNhap'])){
        include_once('../../controller/cNguoiDung.php');
        $p = new cNguoiDung();
        $con = $p -> get01NguoiDung($_REQUEST['txtTND'],$_REQUEST['txtMK']);
    }

?>