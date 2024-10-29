<?php
    session_start();
    include_once('../model/mEmployee.php');
    class cEmployee{
        
        public function clogin($name,$pw){
            $con = new mEmployee;
            $pw = MD5($pw);
            $result = $con -> mlogin($name,$pw);
            if(mysqli_num_rows($result)){
                foreach($result as $i){
                    $_SESSION['dn'] = $i['ID_NhanVien'];    
                }
                echo 'se'.$_SESSION['dn'];
                echo '<script>alert("Đăng nhập thành công !")</script>';
                header('refresh:0,url=../index.php');
            }else{
                echo '<script>alert("Tài khoản hoặc mật khẩu không chính xác !")</script>';
            }
        }
    }


?>
