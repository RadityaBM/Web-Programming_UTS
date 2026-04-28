<?php
include 'koneksi.php';
/** @var mysqli $conn */

$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
$password_plain = $_POST['password'];

$password_hash = password_hash($password_plain, PASSWORD_BCRYPT);

$foto_nama = "";

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['foto']['tmp_name'];
    $ukuran = $_FILES['foto']['size'];

    if ($ukuran > 2097152) {
        die("ukuran_besar");
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $tmp_name);
    finfo_close($finfo);

    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($mime_type, $allowed_types)) {
        die("tipe_salah");
    }

    $foto_nama = time() . "_" . basename($_FILES['foto']['name']);
    $tujuan = "uploads_penulis/" . $foto_nama;

    move_uploaded_file($tmp_name, $tujuan);
}

$stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $password_hash, $foto_nama);

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$conn->close();
?>