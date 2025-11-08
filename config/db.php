<?php
class Database
{
  private $host = "localhost";//ganti sesuai host database
  private $username = "root";//ganti sesuai username database
  private $password = "";//ganti sesuai password database
  private $dbname = "db_manga";//ganti sesuai nama database

  public $conn;//membuat properti public $conn untuk menyimpan koneksi database
  public function __construct()//membuat konstruktor untuk inisialisasi koneksi database
  {
    try {
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);//membuat koneksi PDO ke database
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//mengatur mode error PDO ke exception
    } catch (PDOException $e) {//menangani error koneksi database
      echo "Connection failed: " . $e->getMessage();//menampilkan pesan error jika koneksi gagal
    }
  }
}