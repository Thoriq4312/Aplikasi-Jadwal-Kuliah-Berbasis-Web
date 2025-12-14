<?php
$host = "localhost:3307";
$user = "root";
$pass = "";
$db   = "jadwal";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal");
}
?>
