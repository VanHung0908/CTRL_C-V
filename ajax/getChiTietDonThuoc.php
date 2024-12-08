<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/model/ketnoi.php');
include($_SERVER['DOCUMENT_ROOT'] . '/QLBV/model/mPKQK.php');  

if (isset($_GET['maDonThuoc'])) {
    $maDonThuoc = $_GET['maDonThuoc'];
    $mDonThuoc = new mPKQK();

    $kqk = $mDonThuoc->getTTThuoc($maDonThuoc);

    header('Content-Type: application/json');
    echo json_encode($kqk);
} else {
    echo json_encode([]);
}
