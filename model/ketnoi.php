<?php
    class clsKetNoi
    {
        public function moKetNoi()
        {
            return mysqli_connect('localhost','root','','QLBV');
        }
        public function dongKetNoi($con)
        {
            mysqli_close($con);
        }
    }
    define('BN_URL', 'http://localhost/QLBV/');
    define('BS_URL', 'http://localhost/QLBV/bacsi/');
    define('BACKEND_URL', 'C:\wamp64\www\QLBV\\');
?>
