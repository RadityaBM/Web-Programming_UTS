<?php
include 'koneksi.php';
/** @var mysqli $conn */

$data = ['penulis' => [], 'kategori' => []];

$resP = mysqli_query($conn, "SELECT id, nama_depan, nama_belakang FROM penulis");
while($r = mysqli_fetch_assoc($resP)) {
    $data['penulis'][] = $r;
}

$resK = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori_artikel");
while($r = mysqli_fetch_assoc($resK)) {
    $data['kategori'][] = $r;
}

echo json_encode($data);
?>