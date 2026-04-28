<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM kategori_artikel WHERE id = $id");
echo json_encode(mysqli_fetch_assoc($result));
?>