<?php
include 'koneksi.php';
/** @var mysqli $conn */

$query = "SELECT * FROM penulis ORDER BY id DESC";
$result = mysqli_query($conn, $query);

echo '<div class="d-flex justify-content-between align-items-center mb-3">';
echo '<h4>Data Penulis</h4>';
echo '<button class="btn btn-success" onclick="showModalTambahPenulis()">+ Tambah Penulis</button>';
echo '</div>';

echo '<table class="table table-bordered table-hover bg-white text-center align-middle">';
echo '<thead class="table-light"><tr><th>FOTO</th><th>NAMA</th><th>USERNAME</th><th>PASSWORD</th><th>AKSI</th></tr></thead>';
echo '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $foto = !empty($row['foto']) ? 'uploads_penulis/' . htmlspecialchars($row['foto']) : 'uploads_penulis/default.png';
    
    $nama_lengkap = htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']);
    
    echo '<tr>';
    echo '<td><img src="' . $foto . '" alt="Foto" width="50" height="50" class="rounded"></td>';
    echo '<td>' . $nama_lengkap . '</td>';
    echo '<td><span class="text-primary">' . htmlspecialchars($row['user_name']) . '</span></td>';
    echo '<td><small class="text-muted">' . substr($row['password'], 0, 15) . '...</small></td>';
    echo '<td>
            <button class="btn btn-primary btn-sm" onclick="editPenulis('.$row['id'].')">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusPenulis('.$row['id'].')">Hapus</button>
          </td>';
    echo '</tr>';
}
echo '</tbody></table>';
?>