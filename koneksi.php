<?php
$conn = new mysqli("localhost", "root", "", "penjualan_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
