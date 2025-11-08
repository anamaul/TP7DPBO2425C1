<?php
// mangas.php (Diperbarui)

// Pastikan $author dan $manga sudah di-instantiate di index.php

// ------------------------------------
// 1. LOGIKA DELETE MANGA
// ------------------------------------
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
  $manga_id_to_delete = (int) $_GET['id'];

  // Panggil fungsi deleteManga
  $success = $manga->deleteManga($manga_id_to_delete);

  if ($success) {
    echo "<p style='color:green;'>Manga (ID: $manga_id_to_delete) berhasil dihapus!</p>";
    // Redirect kembali ke halaman manga tanpa parameter action/id
    echo '<meta http-equiv="refresh" content="0;url=index.php?page=mangas">';
    exit();
  } else {
    echo "<p style='color:red;'>Gagal menghapus manga.</p>";
  }
}


// ------------------------------------
// 2. LOGIKA UPDATE MANGA
// ------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_manga'])) {
  // Ambil data dari form update
  $manga_id_to_update = $_POST['manga_id'];
  $title = $_POST['manga_title'] ?? '';
  $genre = $_POST['genre'] ?? '';
  $year = $_POST['year'] ?? '';
  $author_id = $_POST['author_id'] ?? 0;

  if (!empty($title) && !empty($genre) && !empty($year) && !empty($author_id) && !empty($manga_id_to_update)) {
    // Panggil fungsi updateManga
    $success = $manga->updateManga($manga_id_to_update, $title, $author_id, $genre, $year);

    if ($success) {
      echo "<p style='color:green;'>Manga **$title** berhasil diperbarui!</p>";
      // Redirect untuk membersihkan URL dari parameter edit
      echo '<meta http-equiv="refresh" content="0;url=index.php?page=mangas">';
      exit();
    } else {
      echo "<p style='color:red;'>Gagal memperbarui manga.</p>";
    }
  } else {
    echo "<p style='color:red;'>Semua kolom harus diisi saat pembaruan!</p>";
  }
}


// ------------------------------------
// 3. LOGIKA CREATE (TAMBAH) MANGA (dari permintaan sebelumnya)
// ------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_manga'])) {
  // Ambil data dari form
  $title = $_POST['manga_title'] ?? '';
  $genre = $_POST['genre'] ?? '';
  $year = $_POST['year'] ?? '';
  $author_id = $_POST['author_id'] ?? 0;

  if (!empty($title) && !empty($genre) && !empty($year) && !empty($author_id)) {
    $success = $manga->createManga($title, $author_id, $genre, $year);
    if ($success) {
      echo "<p style='color:green;'>Manga **$title** berhasil ditambahkan!</p>";
    } else {
      echo "<p style='color:red;'>Gagal menambahkan manga.</p>";
    }
  } else {
    echo "<p style='color:red;'>Semua kolom harus diisi!</p>";
  }
}


// ------------------------------------
// 4. FORM TAMBAH MANGA
// ------------------------------------
?>
<h3>Tambah Manga Baru</h3>
<form method="POST">
  <label for="manga_title">Judul Manga:</label>
  <input type="text" id="manga_title" name="manga_title" required><br><br>

  <label for="genre">Genre:</label>
  <input type="text" id="genre" name="genre" required><br><br>

  <label for="year">Tahun:</label>
  <input type="number" id="year" name="year" required min="1900" max="<?= date('Y') ?>"><br><br>

  <label for="author_id">Author:</label>
  <select id="author_id" name="author_id" required>
    <option value="">-- Pilih Author --</option>
    <?php foreach ($author->getAllAuthors() as $a): ?>
      <option value="<?= $a['author_id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
    <?php endforeach; ?>
  </select><br><br>

  <button type="submit" name="add_manga">Tambah Manga</button>
</form>

<hr>

<?php
// File: mangas.php (Bagian 5. FORM UPDATE MANGA yang diperbaiki)

// ------------------------------------
// 5. FORM UPDATE MANGA (Hanya Tampil jika ada parameter 'edit')
// ------------------------------------

if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
  $manga_id_to_edit = (int) $_GET['id'];

  // LANGKAH PERBAIKAN: Panggil fungsi getMangaById() yang baru
  // Ini memastikan data diambil secara langsung, TIDAK tergantung pada adanya chapter.
  $manga_data_to_edit = $manga->getMangaById($manga_id_to_edit);

  // Variabel $all_mangas dan foreach loop TIDAK DIPERLUKAN lagi

  if ($manga_data_to_edit):
    ?>
    <h3 style="color: blue;">Edit Manga: <?= htmlspecialchars($manga_data_to_edit['manga_title']) ?></h3>
    <form method="POST">
      <input type="hidden" name="manga_id" value="<?= $manga_id_to_edit ?>">

      <label for="edit_manga_title">Judul Manga:</label>
      <input type="text" id="edit_manga_title" name="manga_title"
        value="<?= htmlspecialchars($manga_data_to_edit['manga_title']) ?>" required><br><br>

      <label for="edit_genre">Genre:</label>
      <input type="text" id="edit_genre" name="genre" value="<?= htmlspecialchars($manga_data_to_edit['genre']) ?>"
        required><br><br>

      <label for="edit_year">Tahun:</label>
      <input type="number" id="edit_year" name="year" value="<?= htmlspecialchars($manga_data_to_edit['year']) ?>" required
        min="1900" max="<?= date('Y') ?>"><br><br>

      <label for="edit_author_id">Author:</label>
      <select id="edit_author_id" name="author_id" required>
        <?php foreach ($author->getAllAuthors() as $a):
          // Perhatikan: Menggunakan 'author_id' dari hasil query getMangaById()
          $selected = ($a['author_id'] == $manga_data_to_edit['author_id']) ? 'selected' : '';
          ?>
          <option value="<?= $a['author_id'] ?>" <?= $selected ?>><?= htmlspecialchars($a['name']) ?></option>
        <?php endforeach; ?>
      </select><br><br>

      <button type="submit" name="update_manga">Simpan Perubahan</button>
      <a href="index.php?page=mangas" style="margin-left: 10px;">Batal Edit</a>
    </form>
    <hr>
    <?php
  else: // Tambahkan else block untuk penanganan error
    echo "<p style='color:red;'>Error: Data Manga dengan ID $manga_id_to_edit tidak ditemukan.</p>";
  endif;
}
// ------------------------------------
// 6. TABEL DAFTAR MANGA
// ------------------------------------
?>
<h3>Daftar Manga</h3>
<table border="1">
  <tr>
    <th>ID</th>
    <th>Judul Manga</th>
    <th>Genre</th>
    <th>Tahun</th>
    <th>Author</th>
    <th>Aksi</th>
  </tr>
  <?php
  // GANTI: Panggil getUniqueMangas() untuk mendapatkan data yang unik dan lengkap
  // CATATAN: Fungsi getUniqueMangas() harus diimplementasikan di Manga.php
  $mangas_list = $manga->getUniqueMangas();

  // VARIABEL $list = $manga->getAllMangas(); DIBUANG
  // Array $displayed_manga_ids DIBUANG
  
  foreach ($mangas_list as $m): // Loop HANYA pada array unik ($mangas_list)
    ?>
    <tr>
      <td><?= $m['manga_id'] ?></td>
      <td><?= htmlspecialchars($m['manga_title']) ?></td>
      <td><?= htmlspecialchars($m['genre']) ?></td>
      <td><?= htmlspecialchars($m['year']) ?></td>
      <td><?= htmlspecialchars($m['author_name']) ?></td>
      <td>
        <a href="index.php?page=mangas&action=edit&id=<?= $m['manga_id'] ?>">Edit</a> |
        <a href="index.php?page=mangas&action=delete&id=<?= $m['manga_id'] ?>"
          onclick="return confirm('Apakah Anda yakin ingin menghapus manga: <?= htmlspecialchars($m['manga_title']) ?>?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>