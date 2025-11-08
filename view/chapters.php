<?php
// chapters.php

// Pastikan objek $chapter, $manga sudah di-instantiate di index.php

// ------------------------------------
// 1. LOGIKA DELETE CHAPTER
// ------------------------------------
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
  $chapter_id_to_delete = (int) $_GET['id'];

  $success = $chapter->deleteChapter($chapter_id_to_delete);

  if ($success) {
    echo "<p style='color:green;'>Chapter (ID: $chapter_id_to_delete) berhasil dihapus!</p>";
    echo '<meta http-equiv="refresh" content="0;url=index.php?page=chapters">';
    exit();
  } else {
    echo "<p style='color:red;'>Gagal menghapus chapter.</p>";
  }
}


// ------------------------------------
// 2. LOGIKA UPDATE CHAPTER
// ------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_chapter'])) {
  $chapter_id_to_update = $_POST['chapter_id'];
  $title = $_POST['title'] ?? '';
  $chapter_number = $_POST['chapter_number'] ?? 0;

  if (!empty($title) && !empty($chapter_id_to_update) && $chapter_number > 0) {
    $success = $chapter->updateChapter($chapter_id_to_update, $chapter_number, $title);

    if ($success) {
      echo "<p style='color:green;'>Chapter **$title** berhasil diperbarui!</p>";
      echo '<meta http-equiv="refresh" content="0;url=index.php?page=chapters">';
      exit();
    } else {
      echo "<p style='color:red;'>Gagal memperbarui chapter.</p>";
    }
  } else {
    echo "<p style='color:red;'>Semua kolom harus diisi saat pembaruan!</p>";
  }
}


// ------------------------------------
// 3. LOGIKA CREATE (TAMBAH) CHAPTER
// ------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_chapter'])) {
  $manga_id = $_POST['manga_id'] ?? 0;
  $chapter_number = $_POST['chapter_number'] ?? 0;
  $title = $_POST['title'] ?? '';

  if ($manga_id > 0 && $chapter_number > 0 && !empty($title)) {
    $success = $chapter->createChapter($manga_id, $chapter_number, $title);
    if ($success) {
      echo "<p style='color:green;'>Chapter **$title** berhasil ditambahkan!</p>";
    } else {
      echo "<p style='color:red;'>Gagal menambahkan chapter.</p>";
    }
  } else {
    echo "<p style='color:red;'>Semua kolom harus diisi dengan benar!</p>";
  }
}


// ------------------------------------
// 4. FORM TAMBAH CHAPTER
// ------------------------------------
?>
<h3>Tambah Chapter Baru</h3>
<form method="POST">
  <label for="manga_id">Pilih Manga:</label>
  <select id="manga_id" name="manga_id" required>
    <option value="">-- Pilih Manga --</option>
    <?php
    // NOTE: Kita perlu fungsi di Manga.php untuk mendapatkan list Manga unik (ID, Title)
    // Kita akan menggunakan getUniqueMangas() yang disarankan sebelumnya, atau asumsi $manga->getAllMangas() sudah di-filter secara unik
    $unique_mangas = $manga->getUniqueMangas() ?? []; // Ganti dengan fungsi yang benar
    foreach ($unique_mangas as $m):
      ?>
      <option value="<?= $m['manga_id'] ?>"><?= htmlspecialchars($m['manga_title']) ?></option>
    <?php endforeach; ?>
  </select><br><br>

  <label for="chapter_number">Nomor Chapter:</label>
  <input type="number" id="chapter_number" name="chapter_number" required min="1"><br><br>

  <label for="title">Judul Chapter:</label>
  <input type="text" id="title" name="title" required><br><br>

  <button type="submit" name="add_chapter">Tambah Chapter</button>
</form>

<hr>

<?php
// ------------------------------------
// 5. FORM UPDATE CHAPTER (Hanya Tampil jika ada parameter 'edit')
// ------------------------------------

if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
  $chapter_id_to_edit = (int) $_GET['id'];

  // Cari data chapter yang akan di-edit dari hasil getAllChapters()
  $chapter_data_to_edit = null;
  $all_chapters = $chapter->getAllChapters();

  foreach ($all_chapters as $c_row) {
    if ($c_row['ID_Chapter'] == $chapter_id_to_edit) {
      $chapter_data_to_edit = $c_row;
      break;
    }
  }

  if ($chapter_data_to_edit):
    ?>
    <h3 style="color: blue;">Edit Chapter: <?= htmlspecialchars($chapter_data_to_edit['Judul_Chapter']) ?>
      (<?= htmlspecialchars($chapter_data_to_edit['Judul_Manga']) ?>)</h3>
    <form method="POST">
      <input type="hidden" name="chapter_id" value="<?= $chapter_id_to_edit ?>">

      <label for="edit_chapter_number">Nomor Chapter:</label>
      <input type="number" id="edit_chapter_number" name="chapter_number"
        value="<?= htmlspecialchars($chapter_data_to_edit['Nomor_Chapter']) ?>" required min="1"><br><br>

      <label for="edit_title">Judul Chapter:</label>
      <input type="text" id="edit_title" name="title"
        value="<?= htmlspecialchars($chapter_data_to_edit['Judul_Chapter']) ?>" required><br><br>

      <button type="submit" name="update_chapter">Simpan Perubahan</button>
      <a href="index.php?page=chapters" style="margin-left: 10px;">Batal Edit</a>
    </form>
    <hr>
  <?php
  endif;
}

// ------------------------------------
// 6. TABEL DAFTAR CHAPTER
// ------------------------------------
?>
<h3>Daftar Chapter</h3>
<table border="1">
  <tr>
    <th>Judul Manga</th>
    <th>ID Chapter</th>
    <th>Nomor Chapter</th>
    <th>Judul Chapter</th>
    <th>Aksi</th>
  </tr>
  <?php
  $chapters_list = $chapter->getAllChapters();
  foreach ($chapters_list as $c):
    ?>
    <tr>
      <td><?= htmlspecialchars($c['Judul_Manga']) ?></td>
      <td><?= htmlspecialchars($c['ID_Chapter']) ?></td>
      <td><?= htmlspecialchars($c['Nomor_Chapter']) ?></td>
      <td><?= htmlspecialchars($c['Judul_Chapter']) ?></td>
      <td>
        <a href="index.php?page=chapters&action=edit&id=<?= $c['ID_Chapter'] ?>">Edit</a> |
        <a href="index.php?page=chapters&action=delete&id=<?= $c['ID_Chapter'] ?>"
          onclick="return confirm('Apakah Anda yakin ingin menghapus chapter: <?= htmlspecialchars($c['Judul_Chapter']) ?>?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>