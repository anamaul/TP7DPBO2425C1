<h1>🧾 Janji</h1>
Saya Muhammad Maulana Adrian dengan NIM 2408647 mengerjakan Tugas Praktikum 7
dalam mata kuliah Desain Pemrograman Berbasis Objek untuk keberkahanNya maka
saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

<h2>🌐 Deskripsi Proyek</h2>

Proyek ini adalah implementasi sederhana dari aplikasi CRUD (Create, Read, Update, Delete) untuk mengelola database Manga. Aplikasi ini dibangun menggunakan bahasa pemrograman PHP dengan koneksi database MySQL/MariaDB melalui ekstensi PDO.<br>
Proyek ini menerapkan konsep Object-Oriented Programming (OOP) dengan memisahkan logika database ke dalam Class terpisah (Author.php, Manga.php, Chapter.php).<br>

<h2>🖼️ Design Database</h2>

<img width="855" height="266" alt="image" src="https://github.com/user-attachments/assets/26952463-8002-498f-9dc7-c1840f9d22bb" />

<h2>🛠️ Persyaratan Sistem</h2>

* Web Server: Apache atau Nginx<br>
* Database: MySQL / MariaDB<br>
* Bahasa Pemrograman: PHP (Versi 7.4 ke atas disarankan)<br>

<h2>📝 Desain Program & Struktur File</h2>

Aplikasi ini menggunakan struktur MVC (Model-View-Controller) yang ringan:

<h3>Struktur File Proyek Manga Database CRUD</h3>

<table>
  <thead>
    <tr>
      <th>Folder/File</th>
      <th>Peran Utama</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>index.php</code></td>
      <td>Entry Point</td>
      <td>Titik masuk utama aplikasi, mengatur routing halaman berdasarkan parameter <code>?page=...</code> dan menginstansi Class utama.</td>
    </tr>
    <tr>
      <td><code>config/db.php</code></td>
      <td>Koneksi Database</td>
      <td>Berisi Class Database untuk koneksi ke MySQL menggunakan PDO.</td>
    </tr>
    <tr>
      <td><code>view/header.php</code></td>
      <td>Header &amp; Navigasi</td>
      <td>Berisi navigasi utama (Author, Manga, Chapter).</td>
    </tr>
    <tr>
      <td><code>view/footer.php</code></td>
      <td>Footer</td>
      <td>Berisi informasi copyright.</td>
    </tr>
    <tr>
      <td><code>style.css</code></td>
      <td>Styling</td>
      <td>Mengatur tampilan CSS dasar.</td>
    </tr>
    <tr>
      <td><code>class/Author.php</code></td>
      <td>Model Author</td>
      <td>Berisi fungsi CRUD (createAuthor, getAllAuthors, updateAuthor, deleteAuthor).</td>
    </tr>
    <tr>
      <td><code>class/Manga.php</code></td>
      <td>Model Manga</td>
      <td>Berisi fungsi CRUD (createManga, getUniqueMangas, updateManga, deleteManga) dan fungsi join data.</td>
    </tr>
    <tr>
      <td><code>class/Chapter.php</code></td>
      <td>Model Chapter</td>
      <td>Berisi fungsi CRUD (createChapter, getAllChapters, updateChapter, deleteChapter).</td>
    </tr>
    <tr>
      <td><code>view/authors.php</code></td>
      <td>View Author</td>
      <td>Menampilkan daftar Author dan form untuk menambah/mengedit Author.</td>
    </tr>
    <tr>
      <td><code>view/mangas.php</code></td>
      <td>View Manga</td>
      <td>Menampilkan daftar Manga dan form untuk menambah/mengedit Manga.</td>
    </tr>
    <tr>
      <td><code>view/chapters.php</code></td>
      <td>View Chapter</td>
      <td>Menampilkan daftar Chapter dan form untuk menambah/mengedit Chapter.</td>
    </tr>
  </tbody>
</table>

<h2>🚀 Fitur CRUD Utama</h2>

<p>Aplikasi ini menyediakan antarmuka untuk mengelola tiga entitas utama:</p>

<ol>
  <li>
    <strong>Manga:</strong>
    <ul>
      <li>Menambah, melihat, mengedit, dan menghapus data Manga (Judul, Genre, Tahun, Author).</li>
    </ul>
  </li>
  <li>
    <strong>Author:</strong>
    <ul>
      <li>Menambah, melihat, mengedit, dan menghapus data Author (Nama, Biografi).</li>
      <li>Penghapusan Author akan memicu penghapusan data Manga terkait (ON DELETE CASCADE).</li>
    </ul>
  </li>
  <li>
    <strong>Chapter:</strong>
    <ul>
      <li>Menambah, melihat, mengedit, dan menghapus data Chapter (Nomor Chapter, Judul Chapter).</li>
      <li>Setiap Chapter harus ditautkan ke satu Manga yang sudah ada.</li>
    </ul>
  </li>
</ol>
<h2>⚙️ Cara Menjalankan</h2>
    <ol>
      <li>Setup Database: Impor file db_manga.sql (atau file dump database Anda) ke server MySQL/MariaDB lokal Anda. Pastikan nama database sesuai dengan konfigurasi di config/db.php.</li>
      <li>Konfigurasi PHP: Sesuaikan kredensial database di config/db.php (hostname, username, password, dbname).</li>
      <li>Akses Aplikasi: Tempatkan semua file proyek di folder root server web lokal Anda (misalnya htdocs/db_manga).</li>
      <li>Akses melalui browser dengan URL: http://localhost/db_manga/index.php atau sesuai konfigurasi server Anda.</li>
    </ol>
    
<h2>🎮 Tampilan GUI Program</h2>

<img width="1919" height="1046" alt="image" src="https://github.com/user-attachments/assets/a84f64aa-334a-474f-bfbc-39a17c24ebe6" />

<h2>🧭 Run Program</h2>



https://github.com/user-attachments/assets/93b8c6f1-dd53-40d6-b081-b9a33823a73b

