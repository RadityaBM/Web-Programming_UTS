<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis WHERE id = $id");
echo json_encode(mysqli_fetch_assoc($result));
?>