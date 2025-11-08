<?php
require_once 'config/db.php';//memanggil file db.php untuk koneksi database

class Chapter//membuat class Chapter
{
  private $db;//membuat properti private $db untuk menyimpan koneksi database

  public function __construct()//membuat konstruktor untuk inisialisasi koneksi database
  {
    $this->db = (new Database())->conn;//menginisialisasi properti $db dengan koneksi database
  }

  public function getAllChapters()//membuat method untuk mengambil semua data chapter dari database
  {
    $stmt = $this->db->query("SELECT 
    CASE 
        WHEN ROW_NUMBER() OVER (PARTITION BY m.manga_id ORDER BY c.chapter_number) = 1 
        THEN m.title 
        ELSE '' 
    END AS Judul_Manga,
    c.chapter_id AS ID_Chapter,
    c.chapter_number AS Nomor_Chapter,
    c.title AS Judul_Chapter
FROM manga m
JOIN author a ON m.author_id = a.author_id
JOIN chapter c ON m.manga_id = c.manga_id
ORDER BY m.manga_id, c.chapter_number;
");//menjalankan query untuk mengambil semua data dari tabel chapter beserta judul manga dan nomor chapter
    return $stmt->fetchAll(PDO::FETCH_ASSOC);//mengembalikan hasil query sebagai array asosiatif
  }

  public function createChapter($manga_id, $chapter_number, $title)//membuat method untuk menambahkan data chapter baru ke database
  {
    $stmt = $this->db->prepare("INSERT INTO chapter (manga_id, chapter_number, title) VALUES (?, ?, ?)");//mempersiapkan query untuk memasukkan data baru ke tabel chapter
    return $stmt->execute([$manga_id, $chapter_number, $title]);//menjalankan query dengan parameter manga_id, chapter_number, dan title
  }

  public function updateChapter($chapter_id, $chapter_number, $title)//membuat method untuk memperbarui data chapter di database
  {
    $stmt = $this->db->prepare("UPDATE chapter SET title = ?, chapter_number = ? WHERE chapter_id = ?");//mempersiapkan query untuk memperbarui data di tabel chapter berdasarkan chapter_id
    return $stmt->execute([$title, $chapter_number, $chapter_id]);//menjalankan query dengan parameter title, chapter_number, dan chapter_id
  }

  public function deleteChapter($chapter_id)//membuat method untuk menghapus data chapter dari database
  {
    $stmt = $this->db->prepare("DELETE FROM chapter WHERE chapter_id = ?");//mempersiapkan query untuk menghapus data dari tabel chapter berdasarkan chapter_id
    return $stmt->execute([$chapter_id]);//menjalankan query dengan parameter chapter_id
  }
}