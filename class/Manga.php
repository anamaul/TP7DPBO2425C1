<?php
require_once 'config/db.php';//memanggil file db.php untuk koneksi database

class Manga//membuat class Manga
{
  private $db;//membuat properti private $db untuk menyimpan koneksi database

  public function __construct()//membuat konstruktor untuk inisialisasi koneksi database
  {
    $this->db = (new Database())->conn;//menginisialisasi properti $db dengan koneksi database
  }

  public function getAllMangas()//membuat method untuk mengambil semua data manga dari database
  {
    $stmt = $this->db->query("SELECT 
    COALESCE(
        CASE WHEN ROW_NUMBER() OVER (PARTITION BY manga.manga_id ORDER BY chapter.chapter_number) = 1 
             THEN manga.title END, ''
    ) AS manga_title,
    COALESCE(
        CASE WHEN ROW_NUMBER() OVER (PARTITION BY manga.manga_id ORDER BY chapter.chapter_number) = 1 
             THEN manga.genre END, ''
    ) AS genre,
    COALESCE(
        CASE WHEN ROW_NUMBER() OVER (PARTITION BY manga.manga_id ORDER BY chapter.chapter_number) = 1 
             THEN manga.year END, ''
    ) AS year,
    COALESCE(
        CASE WHEN ROW_NUMBER() OVER (PARTITION BY manga.manga_id ORDER BY chapter.chapter_number) = 1 
             THEN author.name END, ''
    ) AS author_name,
    chapter.chapter_number AS chapter_number,
    chapter.title AS chapter_title,
    manga.manga_id AS manga_id
FROM manga
JOIN author ON manga.author_id = author.author_id
JOIN chapter ON manga.manga_id = chapter.manga_id
ORDER BY manga.manga_id, chapter.chapter_number;
");//menjalankan query untuk mengambil semua data dari tabel manga beserta informasi terkait
    return $stmt->fetchAll(PDO::FETCH_ASSOC);//mengembalikan hasil query sebagai array asosiatif
  }

  public function createManga($title, $author_id, $genre, $year)//membuat method untuk menambahkan data manga baru ke database
  {
    $stmt = $this->db->prepare("INSERT INTO manga (title, author_id, genre, year) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$title, $author_id, $genre, $year]);
  }

  public function updateManga($manga_id, $title, $author_id, $genre, $year)//membuat method untuk memperbarui data manga di database
  {
    $stmt = $this->db->prepare("UPDATE manga SET title = ?, author_id = ?, genre = ?, year = ? WHERE manga_id = ?");
    return $stmt->execute([$title, $author_id, $genre, $year, $manga_id]);
  }

  public function deleteManga($manga_id)//membuat method untuk menghapus data manga dari database
  {
    $stmt = $this->db->prepare("DELETE FROM manga WHERE manga_id = ?");
    return $stmt->execute([$manga_id]);
  }

  public function getUniqueMangas()//membuat method untuk mengambil semua data manga unik dari database
  {
    $stmt = $this->db->query("SELECT 
        manga.manga_id,
        manga.title AS manga_title,
        manga.genre,
        manga.year,
        author.name AS author_name,
        author.author_id
    FROM manga
    JOIN author ON manga.author_id = author.author_id
    ORDER BY manga.manga_id;
    ");//menjalankan query untuk mengambil semua data manga unik dari tabel manga beserta informasi author terkait
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function getMangaById($manga_id)//membuat method untuk mengambil data manga berdasarkan manga_id
  {
    $stmt = $this->db->prepare("SELECT 
        m.manga_id,
        m.title AS manga_title,
        m.genre,
        m.year,
        a.author_id,
        a.name AS author_name
    FROM manga m
    JOIN author a ON m.author_id = a.author_id
    WHERE m.manga_id = ?");//mempersiapkan query untuk mengambil data manga berdasarkan manga_id

    $stmt->execute([$manga_id]);//menjalankan query dengan parameter manga_id
    return $stmt->fetch(PDO::FETCH_ASSOC);//mengembalikan hasil query sebagai array asosiatif
  }
}