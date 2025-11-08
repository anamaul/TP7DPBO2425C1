<?php
require_once 'config/db.php';

class Author
{
  private $db;

  public function __construct()
  {
    $this->db = (new Database())->conn;
  }

  public function getAllAuthors()
  {
    $stmt = $this->db->query("SELECT * FROM author");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createAuthor($name, $bio)
  {
    $stmt = $this->db->prepare("INSERT INTO author (name, bio) VALUES (?, ?)");
    return $stmt->execute([$name, $bio]);
  }

  public function updateAuthor($author_id, $name, $bio)
  {
    $stmt = $this->db->prepare("UPDATE author SET name = ?, bio = ? WHERE author_id = ?");
    return $stmt->execute([$name, $bio, $author_id]);
  }

  public function deleteAuthor($author_id)
  {
    $stmt = $this->db->prepare("DELETE FROM author WHERE author_id = ?");
    return $stmt->execute([$author_id]);
  }
}