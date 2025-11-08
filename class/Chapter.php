<?php
require_once 'config/db.php';

class Chapter
{
  private $db;

  public function __construct()
  {
    $this->db = (new Database())->conn;
  }

  public function getAllChapters()
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
");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createChapter($manga_id, $chapter_number, $title)
  {
    $stmt = $this->db->prepare("INSERT INTO chapter (manga_id, chapter_number, title) VALUES (?, ?, ?)");
    return $stmt->execute([$manga_id, $chapter_number, $title]);
  }

  public function updateChapter($chapter_id, $chapter_number, $title)
  {
    $stmt = $this->db->prepare("UPDATE chapter SET title = ?, chapter_number = ? WHERE chapter_id = ?");
    return $stmt->execute([$title, $chapter_number, $chapter_id]);
  }

  public function deleteChapter($chapter_id)
  {
    $stmt = $this->db->prepare("DELETE FROM chapter WHERE chapter_id = ?");
    return $stmt->execute([$chapter_id]);
  }
}