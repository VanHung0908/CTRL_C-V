<?php
    include_once('../../model/mNguoiDung.php');
    class cNguoiDung
    {
      public function get01NguoiDung($user, $pw)
      {
          $pw = md5($pw);  // Mã hóa mật khẩu
          $p = new mNguoiDung();
          $tbl = $p->select01NguoiDung($user, $pw);

          // Kiểm tra nếu có kết quả trả về
          if (mysqli_num_rows($tbl) > 0) {
              foreach ($tbl as $i) {
                  $_SESSION['dangnhap'] = 1;
                  $_SESSION['dn'] = $i['tenTK'];    
                  $_SESSION['maNS'] = isset($i['MaNS']) ? $i['MaNS'] : null;  
                  $_SESSION['maBN'] = isset($i['MaBN']) ? $i['MaBN'] : null;  
                  // Lấy MaCV và MaBN từ kết quả truy vấn
                  $maNS = isset($i['MaNS']) ? $i['MaNS'] : null;
                  $maBN = isset($i['MaBN']) ? $i['MaBN'] : null;

                  // Kiểm tra nếu MaCV tồn tại
                  if ($maNS) {
                      echo '<script>
                            Swal.fire({
                              icon: "success",
                              title: "Đăng nhập thành công",
                              confirmButtonText: "OK"
                            }).then((result) => {
                              if (result.isConfirmed) {
                              window.location.href = "' . BS_URL . '";  // Chuyển hướng đến trang nhân sự
                              }
                            });
                          </script>';
                  } elseif ($maBN) {
                      echo '<script>
                            Swal.fire({
                              icon: "success",
                              title: "Đăng nhập thành công",
                              confirmButtonText: "OK"
                            }).then((result) => {
                              if (result.isConfirmed) {
                                window.location.href = "' . BN_URL . '";  // Chuyển hướng đến trang bệnh nhân
                              }
                            });
                          </script>';
                  }
              }
          } else {
              // Nếu không có kết quả
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
       
        
    }

?>

