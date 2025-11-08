<?php

require_once 'class/Author.php';//membutuhkan file class Author.php
require_once 'class/Manga.php';//membutuhkan file class Manga.php
require_once 'class/Chapter.php';//membutuhkan file class Chapter.php

$author = new Author();//membuat instance dari class Author
$manga = new Manga();//membuat instance dari class Manga
$chapter = new Chapter();//membuat instance dari class Chapter

// Tentukan halaman yang akan dimuat (default: home)
$page = $_GET['page'] ?? 'home';

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manga Database CRUD</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- include file header.php yang ada di folder view -->
  <?php include 'view/header.php'; ?>


  <main>
    <?php
    // Logika untuk memuat konten utama
    switch ($page) {
      case 'authors':
        include 'view/authors.php';
        break;
      case 'mangas':
        include 'view/mangas.php';
        break;
      case 'chapters':
        include 'view/chapters.php';
        break;
      case 'home':
      default:
        echo "<h2>Selamat Datang di Manga Database!</h2>";
        echo "<p>Gunakan navigasi di atas untuk melihat daftar Author, Manga, atau Chapter.</p>";
        break;
    }
    ?>
  </main>

  <?php include 'view/footer.php'; ?>
  <!-- include file footer.php yang ada di folder view -->
</body>

</html>