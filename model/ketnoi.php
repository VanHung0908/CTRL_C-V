<?php
    class clsKetNoi
    {
        public function moKetNoi()
        {
            return mysqli_connect('localhost','root','','benhvien');
        }
        public function dongKetNoi($con)
        {
            mysqli_close($con);
        }
    }
    define('BN_URL', 'http://localhost/QLBV/');
    define('BS_URL', 'http://localhost/QLBV/bacsi/');
    define('BACKEND_URL', $_SERVER['DOCUMENT_ROOT'] . '/QLBV/');
    date_default_timezone_set('Asia/Ho_Chi_Minh'); 
?>
