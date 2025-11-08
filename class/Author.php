<?php
require_once 'config/db.php';//memanggil file db.php untuk koneksi database

class Author//membuat class Author
{
  private $db;//membuat properti private $db untuk menyimpan koneksi database

  public function __construct()//membuat konstruktor untuk inisialisasi koneksi database
  {
    $this->db = (new Database())->conn;
  }

  public function getAllAuthors()//membuat method untuk mengambil semua data author dari database
  {
    $stmt = $this->db->query("SELECT * FROM author");//menjalankan query untuk mengambil semua data dari tabel author
    return $stmt->fetchAll(PDO::FETCH_ASSOC);//mengembalikan hasil query sebagai array asosiatif
  }

  public function createAuthor($name, $bio)//membuat method untuk menambahkan data author baru ke database
  {
    $stmt = $this->db->prepare("INSERT INTO author (name, bio) VALUES (?, ?)");//mempersiapkan query untuk memasukkan data baru ke tabel author
    return $stmt->execute([$name, $bio]);//menjalankan query dengan parameter nama dan bio
  }

  public function updateAuthor($author_id, $name, $bio)//membuat method untuk memperbarui data author di database
  {
    $stmt = $this->db->prepare("UPDATE author SET name = ?, bio = ? WHERE author_id = ?");//mempersiapkan query untuk memperbarui data di tabel author berdasarkan author_id
    return $stmt->execute([$name, $bio, $author_id]);//menjalankan query dengan parameter nama, bio, dan author_id
  }

  public function deleteAuthor($author_id)//membuat method untuk menghapus data author dari database
  {
    $stmt = $this->db->prepare("DELETE FROM author WHERE author_id = ?");//mempersiapkan query untuk menghapus data dari tabel author berdasarkan author_id
    return $stmt->execute([$author_id]);//menjalankan query dengan parameter author_id
  }

  public function getAuthorById($author_id)
  {
    $stmt = $this->db->prepare("SELECT * FROM author WHERE author_id = ?");
    $stmt->execute([$author_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil satu baris data author
  }
}