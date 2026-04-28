<?php
include 'koneksi.php';
/** @var mysqli $conn */

$query = "SELECT a.*, p.nama_depan, p.nama_belakang, k.nama_kategori 
          FROM artikel a 
          JOIN penulis p ON a.id_penulis = p.id 
          JOIN kategori_artikel k ON a.id_kategori = k.id 
          ORDER BY a.id DESC";
$result = mysqli_query($conn, $query);

echo '<div class="d-flex justify-content-between align-items-center mb-3">';
echo '<h4>Data Artikel</h4>';
echo '<button class="btn btn-success" onclick="showModalTambahArtikel()">+ Tambah Artikel</button>';
echo '</div>';

echo '<table class="table table-bordered table-hover bg-white text-center align-middle">';
echo '<thead class="table-light"><tr><th>GAMBAR</th><th>JUDUL</th><th>KATEGORI</th><th>PENULIS</th><th>TANGGAL</th><th>AKSI</th></tr></thead>';
echo '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td><img src="uploads_artikel/' . htmlspecialchars($row['gambar']) . '" width="60" class="rounded"></td>';
    echo '<td>' . htmlspecialchars($row['judul']) . '</td>';
    echo '<td><span class="badge bg-info text-dark">' . htmlspecialchars($row['nama_kategori']) . '</span></td>';
    echo '<td>' . htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) . '</td>';
    echo '<td><small class="text-muted">' . htmlspecialchars($row['hari_tanggal']) . '</small></td>';
    echo '<td>
            <button class="btn btn-primary btn-sm" onclick="editArtikel('.$row['id'].')">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusArtikel('.$row['id'].')">Hapus</button>
          </td>';
    echo '</tr>';
}
echo '</tbody></table>';
?>