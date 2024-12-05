<?php
    include_once('../../model/mNguoiDung.php');
    class cNguoiDung
    {
    
      public function get01NguoiDung($user, $pw)
      {
          $pw = md5($pw); // Mã hóa mật khẩu
          $p = new mNguoiDung();
          $tbl = $p->select01NguoiDung($user, $pw);
  
          // Kiểm tra nếu truy vấn không thành công hoặc không có dữ liệu
          if (!$tbl || mysqli_num_rows($tbl) == 0) {
              echo '<script>
                      Swal.fire({
                          icon: "error",
                          title: "Thất bại",
                          text: "Tài khoản hoặc mật khẩu không chính xác!",
                          confirmButtonText: "Thử lại"
                      });
                    </script>';
              return;
          }
  
          // Kiểm tra nếu có kết quả trả về
          foreach ($tbl as $i) {
              $_SESSION['dangnhap'] = 0;
              $_SESSION['dn'] = $i['tenTK'];
              $_SESSION['maNS'] = isset($i['MaNS']) ? $i['MaNS'] : null;
              $_SESSION['maBN'] = isset($i['MaBN']) ? $i['MaBN'] : null;
              $_SESSION['maCV'] = isset($i['MaCV']) ? $i['MaCV'] : null;
              $_SESSION['maKhoa'] = isset($i['MaKhoa']) ? $i['MaKhoa'] : null;
  
              $maNS = $_SESSION['maNS'];
              $maBN = $_SESSION['maBN'];
              $maCV = $_SESSION['maCV'];
  
              if ($maNS) {
                $_SESSION['dangnhap'] = 2;
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
              } elseif ($maBN) {
                $_SESSION['dangnhap'] = 1;
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
                                 window.location.href = "' . BS_URL . '"; 
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

