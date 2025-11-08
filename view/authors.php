<?php
// authors.php

// Pastikan objek $author sudah di-instantiate di index.php

// ------------------------------------
// 1. LOGIKA DELETE AUTHOR
// ------------------------------------
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
  $author_id_to_delete = (int) $_GET['id'];

  // Panggil fungsi deleteAuthor
  $success = $author->deleteAuthor($author_id_to_delete);

  if ($success) {
    echo "<p style='color:green;'>Author (ID: $author_id_to_delete) berhasil dihapus!</p>";
    echo '<meta http-equiv="refresh" content="0;url=index.php?page=authors">';
    exit();
  } else {
    echo "<p style='color:red;'>Gagal menghapus author.</p>";
  }
}


// ------------------------------------
// 2. LOGIKA UPDATE AUTHOR
// ------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_author'])) {
  $author_id_to_update = $_POST['author_id'];
  $name = $_POST['author_name'] ?? '';
  $bio = $_POST['bio'] ?? '';

  if (!empty($name) && !empty($author_id_to_update)) {
    $success = $author->updateAuthor($author_id_to_update, $name, $bio);

    if ($success) {
      echo "<p style='color:green;'>Author **$name** berhasil diperbarui!</p>";
      echo '<meta http-equiv="refresh" content="0;url=index.php?page=authors">';
      exit();
    } else {
      echo "<p style='color:red;'>Gagal memperbarui author.</p>";
    }
  } else {
    echo "<p style='color:red;'>Nama Author harus diisi saat pembaruan!</p>";
  }
}


// ------------------------------------
// 3. LOGIKA CREATE (TAMBAH) AUTHOR
// ------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_author'])) {
  $name = $_POST['author_name'] ?? '';
  $bio = $_POST['bio'] ?? '';

  if (!empty($name)) {
    $success = $author->createAuthor($name, $bio);
    if ($success) {
      echo "<p style='color:green;'>Author **$name** berhasil ditambahkan!</p>";
    } else {
      echo "<p style='color:red;'>Gagal menambahkan author.</p>";
    }
  } else {
    echo "<p style='color:red;'>Nama Author harus diisi!</p>";
  }
}


// ------------------------------------
// 4. FORM TAMBAH AUTHOR
// ------------------------------------
?>
<h3>Tambah Author Baru</h3>
<form method="POST">
  <label for="author_name">Nama Author:</label>
  <input type="text" id="author_name" name="author_name" required><br><br>

  <label for="bio">Biografi:</label>
  <textarea id="bio" name="bio"></textarea><br><br>

  <button type="submit" name="add_author">Tambah Author</button>
</form>

<hr>

<?php
// ------------------------------------
// 5. FORM UPDATE AUTHOR (Hanya Tampil jika ada parameter 'edit')
// ------------------------------------

if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
  $author_id_to_edit = (int) $_GET['id'];

  $author_data_to_edit = $author->getAuthorById($author_id_to_edit);

  if ($author_data_to_edit):
    ?>
    <h3 style="color: blue;">Edit Author: <?= htmlspecialchars($author_data_to_edit['name']) ?></h3>
    <form method="POST">
      <input type="hidden" name="author_id" value="<?= $author_id_to_edit ?>">

      <label for="edit_author_name">Nama Author:</label>
      <input type="text" id="edit_author_name" name="author_name"
        value="<?= htmlspecialchars($author_data_to_edit['name']) ?>" required><br><br>

      <label for="edit_bio">Biografi:</label>
      <textarea id="edit_bio" name="bio"><?= htmlspecialchars($author_data_to_edit['bio']) ?></textarea><br><br>

      <button type="submit" name="update_author">Simpan Perubahan</button>
      <a href="index.php?page=authors" style="margin-left: 10px;">Batal Edit</a>
    </form>
    <hr>
    <?php
  endif;
}

// ------------------------------------
// 6. TABEL DAFTAR AUTHOR
// ------------------------------------
?>
<h3>Daftar Author</h3>
<table border="1">
  <tr>
    <th>ID Author</th>
    <th>Nama Author</th>
    <th>Biografi</th>
    <th>Aksi</th>
  </tr>
  <?php
  $authors_list = $author->getAllAuthors();
  foreach ($authors_list as $a):
    ?>
    <tr>
      <td><?= $a['author_id'] ?></td>
      <td><?= htmlspecialchars($a['name']) ?></td>
      <td><?= htmlspecialchars($a['bio']) ?></td>
      <td>
        <a href="index.php?page=authors&action=edit&id=<?= $a['author_id'] ?>">Edit</a> |
        <a href="index.php?page=authors&action=delete&id=<?= $a['author_id'] ?>"
          onclick="return confirm('Apakah Anda yakin ingin menghapus author: <?= htmlspecialchars($a['name']) ?>? (Ini akan menghapus semua manga terkait!)')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>