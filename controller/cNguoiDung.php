<?php
    include_once('../../model/mNguoiDung.php');
    class cNguoiDung
    {
      public function get01NguoiDung($user, $pw)
      {
          $pw = md5($pw);
          $p = new mNguoiDung();
          $tbl = $p->select01NguoiDung($user, $pw);
      
          if (mysqli_num_rows($tbl) > 0) {
            foreach($tbl as $i){
              $_SESSION['dangnhap'] = 1;
              $_SESSION['dn'] = $i['tenTK'];    
          }
      
              // Kiểm tra nếu $user bắt đầu bằng "NS"
              if (substr($user, 0, 2) === "NS") {
                echo '<script>
                      Swal.fire({
                        icon: "success",
                        title: "Đăng nhập thành công",
                        confirmButtonText: "OK"
                      }).then((result) => {
                        if (result.isConfirmed) {
                         window.location.href = "' . BS_URL . '";
                        }
                      });
                    </script>';
              } else {
                  echo '<script>
                      Swal.fire({
                        icon: "success",
                        title: "Đăng nhập thành công",
                        confirmButtonText: "OK"
                      }).then((result) => {
                        if (result.isConfirmed) {
                          window.location.href = "' . BN_URL . '";
                        }
                      });
                    </script>';
              }
          } else {
              echo '<script>
                      Swal.fire({
                        icon: "error",
                        title: "Thất bại",
                        text: "Tài khoản hoặc mật khẩu không chính xác!",
                        confirmButtonText: "Thử lại"
                      });
                    </script>';
          }
      }
       
        
    }

?>

