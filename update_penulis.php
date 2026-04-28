<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = isset($_POST['id_penulis']) ? (int)$_POST['id_penulis'] : 0; 
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
$password_baru = $_POST['password'];

if ($id > 0) {
    $res = mysqli_query($conn, "SELECT foto FROM penulis WHERE id = $id");
    $row = mysqli_fetch_assoc($res);
    $foto_lama = $row['foto'];
    $foto_update = $foto_lama;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_update = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads_penulis/" . $foto_update);
        
        if (!empty($foto_lama) && file_exists("uploads_penulis/" . $foto_lama) && $foto_lama != "default.png") {
            unlink("uploads_penulis/" . $foto_lama);
        }
    }

    if (!empty($password_baru)) {
        $pass_hash = password_hash($password_baru, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
        $stmt->bind_param("sssssi", $nama_depan, $nama_belakang, $user_name, $pass_hash, $foto_update, $id);
    } else {
        $stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama_depan, $nama_belakang, $user_name, $foto_update, $id);
    }

    if ($stmt->execute()) {
        echo "sukses";
    } else {
        echo "gagal: " . mysqli_error($conn);
    }
} else {
    echo "gagal: ID tidak valid";
}
?>