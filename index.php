<?php
include 'koneksi.php';
/** @var mysqli $conn */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .header-top {
            background-color: #2c3e50;
            color: white;
            padding: 15px 20px;
        }

        .header-icon {
            font-size: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 12px;
            border-radius: 8px;
            margin-right: 15px;
        }

        .sidebar {
            min-height: 100vh;
        }

        .sidebar-menu-box {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .nav-link {
            color: #555;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.3s;
            font-weight: 500;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .nav-link:hover {
            background-color: #f8f9fa;
        }

        .nav-link.active {
            background-color: #eafaf1;
            color: #27ae60;
            font-weight: bold;
            border-left: 4px solid #27ae60;
            border-radius: 4px;
        }

        .content-area {
            padding: 20px;
        }

        .card-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <div class="header-top d-flex align-items-center">
        <div class="header-icon"><i class="bi bi-window-stack"></i></div>
        <div>
            <h5 class="m-0 fw-bold">Sistem Manajemen Blog (CMS)</h5>
            <small class="text-white-50">Blog Sistem Manajemen</small>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-4">
                <div class="sidebar-menu-box">
                    <p class="text-muted small fw-bold mb-3 ms-2">MENU UTAMA</p>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="#" onclick="loadMenu('penulis', this)"><i class="bi bi-person"></i> Kelola Penulis</a>
                        <a class="nav-link" href="#" onclick="loadMenu('artikel', this)"><i class="bi bi-file-earmark-text"></i> Kelola Artikel</a>
                        <a class="nav-link" href="#" onclick="loadMenu('kategori', this)"><i class="bi bi-folder"></i> Kelola Kategori</a>
                    </nav>
                </div>
            </div>

            <div class="col-md-10 content-area">
                <div class="card-box" id="main-content">
                    <h4 class="text-muted">Selamat Datang!</h4>
                    <p>Silakan pilih menu di samping kiri untuk mengelola data.</p>
                </div>
            </div>

            <div id="modal-container"></div>

            <div class="modal fade" id="modalArtikel" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formArtikel" onsubmit="simpanArtikel(event)" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="judulModalArtikel">Tambah Artikel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id_artikel" name="id_artikel">
                                <div class="mb-3">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label>Penulis</label>
                                        <select class="form-select" id="id_penulis_artikel" name="id_penulis" required>
                                            <option value="">-- Pilih Penulis --</option>
                                            <?php
                                            $resP = mysqli_query($conn, "SELECT id, nama_depan, nama_belakang FROM penulis");
                                            while ($p = mysqli_fetch_assoc($resP)) {
                                                echo "<option value='" . $p['id'] . "'>" . $p['nama_depan'] . " " . $p['nama_belakang'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>Kategori</label>
                                        <select class="form-select" id="id_kategori_artikel" name="id_kategori" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php
                                            $resK = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori_artikel");
                                            while ($k = mysqli_fetch_assoc($resK)) {
                                                echo "<option value='" . $k['id'] . "'>" . $k['nama_kategori'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Isi Artikel</label>
                                    <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label id="label_gambar_artikel">Gambar</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalKategori" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formKategori" onsubmit="simpanKategori(event)">
                            <div class="modal-header">
                                <h5 class="modal-title" id="judulModalKategori">Tambah Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id_kategori" name="id_kategori">
                                <div class="mb-3">
                                    <label>Nama Kategori</label>
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                                </div>
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPenulis" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formPenulis" onsubmit="simpanPenulis(event)" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="judulModalPenulis">Tambah Penulis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id_penulis" name="id_penulis">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label>Nama Depan</label>
                                        <input type="text" class="form-control" id="nama_depan" name="nama_depan" required>
                                    </div>
                                    <div class="col">
                                        <label>Nama Belakang</label>
                                        <input type="text" class="form-control" id="nama_belakang" name="nama_belakang" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" required>
                                </div>
                                <div class="mb-3">
                                    <label id="label_password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label id="label_foto">Foto Profil</label>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalHapus" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content text-center p-3 border-0 rounded-4">
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 60px; height: 60px;">
                                    <i class="bi bi-trash fs-3"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold">Hapus data ini?</h5>
                            <p class="text-muted small mb-4">Data yang dihapus tidak dapat dikembalikan.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-secondary px-4 fw-bold border-0" style="background-color: #95a5a6;" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-danger px-4 fw-bold border-0" style="background-color: #f44336;" id="btnKonfirmasiHapus">Ya, Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function loadMenu(menu, element) {
                    document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
                    element.classList.add('active');

                    const contentDiv = document.getElementById('main-content');

                    if (menu === 'kategori') {
                        contentDiv.innerHTML = "<h5>Memuat Data Kategori...</h5>";
                        fetch('ambil_kategori.php').then(response => response.text()).then(data => {
                            contentDiv.innerHTML = data;
                        });
                    } else if (menu === 'penulis') {
                        contentDiv.innerHTML = "<h5>Memuat Data Penulis...</h5>";
                        fetch('ambil_penulis.php').then(response => response.text()).then(data => {
                            contentDiv.innerHTML = data;
                        });
                    } else if (menu === 'artikel') {
                        contentDiv.innerHTML = "<h5>Memuat Data Artikel...</h5>";
                        fetch('ambil_artikel.php').then(response => response.text()).then(data => {
                            contentDiv.innerHTML = data;
                        });
                    }
                }

                function updateDropdownArtikel() {
                    fetch('ambil_dropdown.php')
                        .then(response => response.json())
                        .then(data => {
                            let selectPenulis = document.getElementById('id_penulis_artikel');
                            selectPenulis.innerHTML = '<option value="">-- Pilih Penulis --</option>';
                            data.penulis.forEach(p => {
                                selectPenulis.innerHTML += `<option value="${p.id}">${p.nama_depan} ${p.nama_belakang}</option>`;
                            });

                            let selectKategori = document.getElementById('id_kategori_artikel');
                            selectKategori.innerHTML = '<option value="">-- Pilih Kategori --</option>';
                            data.kategori.forEach(k => {
                                selectKategori.innerHTML += `<option value="${k.id}">${k.nama_kategori}</option>`;
                            });
                        });
                }

                function showModalTambahKategori() {
                    document.getElementById('formKategori').reset();
                    document.getElementById('id_kategori').value = '';
                    document.getElementById('judulModalKategori').innerText = 'Tambah Kategori';
                    var myModal = new bootstrap.Modal(document.getElementById('modalKategori'));
                    myModal.show();
                }

                function editKategori(id) {
                    fetch('ambil_satu_kategori.php?id=' + id)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('id_kategori').value = data.id;
                            document.getElementById('nama_kategori').value = data.nama_kategori;
                            document.getElementById('keterangan').value = data.keterangan;
                            document.getElementById('judulModalKategori').innerText = 'Edit Kategori';
                            var myModal = new bootstrap.Modal(document.getElementById('modalKategori'));
                            myModal.show();
                        });
                }

                function simpanKategori(event) {
                    event.preventDefault();
                    const formData = new FormData(document.getElementById('formKategori'));
                    const idKategori = document.getElementById('id_kategori').value;
                    const urlTujuan = (idKategori === '' || idKategori === null) ? 'simpan_kategori.php' : 'update_kategori.php';

                    fetch(urlTujuan, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === 'sukses') {
                                bootstrap.Modal.getInstance(document.getElementById('modalKategori')).hide();
                                document.querySelector('.nav-link.active').click();
                                updateDropdownArtikel(); // FUNGSI DIPANGGIL DI SINI
                            } else {
                                alert('Gagal menyimpan kategori! Pesan: ' + data.trim());
                            }
                        });
                }

                function showModalTambahPenulis() {
                    document.getElementById('formPenulis').reset();
                    document.getElementById('id_penulis').value = '';
                    document.getElementById('password').setAttribute('required', 'true');
                    document.getElementById('label_password').innerText = 'Password';
                    document.getElementById('label_foto').innerText = 'Foto Profil';
                    document.getElementById('judulModalPenulis').innerText = 'Tambah Penulis';
                    var myModal = new bootstrap.Modal(document.getElementById('modalPenulis'));
                    myModal.show();
                }

                function editPenulis(id) {
                    fetch('ambil_satu_penulis.php?id=' + id)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('id_penulis').value = data.id;
                            document.getElementById('nama_depan').value = data.nama_depan;
                            document.getElementById('nama_belakang').value = data.nama_belakang;
                            document.getElementById('user_name').value = data.user_name;

                            document.getElementById('password').value = '';
                            document.getElementById('password').removeAttribute('required');
                            document.getElementById('label_password').innerText = 'Password Baru (kosongkan jika tidak diganti)';
                            document.getElementById('label_foto').innerText = 'Foto Profil (kosongkan jika tidak diganti)';

                            document.getElementById('judulModalPenulis').innerText = 'Edit Penulis';
                            var myModal = new bootstrap.Modal(document.getElementById('modalPenulis'));
                            myModal.show();
                        });
                }

                function simpanPenulis(event) {
                    event.preventDefault();
                    const formData = new FormData(document.getElementById('formPenulis'));
                    const idPenulis = document.getElementById('id_penulis').value;
                    const urlTujuan = (idPenulis === '' || idPenulis === null) ? 'simpan_penulis.php' : 'update_penulis.php';

                    fetch(urlTujuan, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === 'sukses') {
                                bootstrap.Modal.getInstance(document.getElementById('modalPenulis')).hide();
                                document.querySelector('.nav-link.active').click();
                                updateDropdownArtikel(); // FUNGSI DIPANGGIL DI SINI
                            } else if (data.trim() === 'ukuran_besar') {
                                alert('Gagal! Ukuran foto maksimal 2MB.');
                            } else if (data.trim() === 'tipe_salah') {
                                alert('Gagal! File yang diunggah harus berupa gambar.');
                            } else {
                                alert('Gagal menyimpan penulis! Pesan: ' + data.trim());
                            }
                        });
                }

                function showModalTambahArtikel() {
                    document.getElementById('formArtikel').reset();
                    document.getElementById('id_artikel').value = '';
                    document.getElementById('gambar').setAttribute('required', 'true');
                    document.getElementById('label_gambar_artikel').innerText = 'Gambar';
                    document.getElementById('judulModalArtikel').innerText = 'Tambah Artikel';
                    var myModal = new bootstrap.Modal(document.getElementById('modalArtikel'));
                    myModal.show();
                }

                function editArtikel(id) {
                    fetch('ambil_satu_artikel.php?id=' + id)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('id_artikel').value = data.id;
                            document.getElementById('judul').value = data.judul;
                            document.getElementById('id_penulis_artikel').value = data.id_penulis;
                            document.getElementById('id_kategori_artikel').value = data.id_kategori;
                            document.getElementById('isi').value = data.isi;

                            document.getElementById('gambar').removeAttribute('required');
                            document.getElementById('label_gambar_artikel').innerText = 'Gambar (kosongkan jika tidak diganti)';

                            document.getElementById('judulModalArtikel').innerText = 'Edit Artikel';
                            var myModal = new bootstrap.Modal(document.getElementById('modalArtikel'));
                            myModal.show();
                        });
                }

                function simpanArtikel(event) {
                    event.preventDefault();
                    const formData = new FormData(document.getElementById('formArtikel'));
                    const idArtikel = document.getElementById('id_artikel').value;
                    const urlTujuan = (idArtikel === '' || idArtikel === null) ? 'simpan_artikel.php' : 'update_artikel.php';

                    fetch(urlTujuan, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === 'sukses') {
                                bootstrap.Modal.getInstance(document.getElementById('modalArtikel')).hide();
                                document.querySelector('.nav-link.active').click();
                            } else {
                                alert('Gagal menyimpan artikel! Pesan: ' + data.trim());
                            }
                        });
                }

                let deleteId = null;
                let deleteType = '';

                function hapusKategori(id) {
                    deleteId = id;
                    deleteType = 'kategori';
                    new bootstrap.Modal(document.getElementById('modalHapus')).show();
                }

                function hapusPenulis(id) {
                    deleteId = id;
                    deleteType = 'penulis';
                    new bootstrap.Modal(document.getElementById('modalHapus')).show();
                }

                function hapusArtikel(id) {
                    deleteId = id;
                    deleteType = 'artikel';
                    new bootstrap.Modal(document.getElementById('modalHapus')).show();
                }

                document.getElementById('btnKonfirmasiHapus').addEventListener('click', function() {
                    let url = 'hapus_' + deleteType + '.php';
                    let formData = new FormData();
                    formData.append('id', deleteId);

                    fetch(url, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            bootstrap.Modal.getInstance(document.getElementById('modalHapus')).hide();
                            if (data.trim() === 'sukses') {
                                document.querySelector('.nav-link.active').click(); // Refresh tabel
                                updateDropdownArtikel(); // FUNGSI DIPANGGIL DI SINI
                            } else if (data.trim() === 'terikat') {
                                alert('Gagal! Data ini tidak bisa dihapus karena masih digunakan.');
                            } else {
                                alert('Gagal menghapus data.');
                            }
                        });
                });
            </script>
</body>

</html>