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
              $_SESSION['dangnhap'] = 1;
      
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
      public function getBenhNhanInfo()
      {
          if (isset($_SESSION['dangnhap']) && $_SESSION['dangnhap'] == 1) {
              // Lấy mã nhân viên hoặc mã bệnh nhân từ session
              $maNS = isset($_SESSION['maNS']) ? $_SESSION['maNS'] : null;
              $maBN = isset($_SESSION['maBN']) ? $_SESSION['maBN'] : null;

              $NguoiDungModel = new mNguoiDung();
              
              if ($maNS) {
                  $result = $NguoiDungModel->selectTTND($maNS);
              } elseif ($maBN) {
                  $result = $NguoiDungModel->selectTTND($maBN);
              }

              // Xử lý kết quả và trả về
              if ($result) {
                  // Ví dụ, trả lại kết quả cho view hoặc làm gì đó với dữ liệu
                  return $result;
              } else {
                  echo "Không tìm thấy thông tin.";
              }
          } else {
              echo "Bạn cần phải đăng nhập!";
          }
      }
      public function addTK($hoTen, $soDienThoai, $matKhau)
        {
            // Mã hóa mật khẩu
            $matKhau = md5($matKhau);

            // Khởi tạo đối tượng model để thực hiện thao tác với CSDL
            $p = new mNguoiDung();

            $result = $p->insertNguoiDung($hoTen, $soDienThoai, $matKhau);

            // Kiểm tra nếu kết quả trả về là thành công hay thất bại
            if ($result) {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Đăng ký thành công",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                 window.location.href = "/QLBV/benhnhan/auth/login.php"; 
                            }
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Thất bại",
                            text: "Đã có lỗi xảy ra khi đăng ký!",
                            confirmButtonText: "Thử lại"
                        });
                    </script>';
            }
        }

        
    }

?>

