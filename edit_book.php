<?php
require "db.php";

// Mengambil data buku yang akan diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $db->query("SELECT * FROM books WHERE id = $id");
    $book = $result->fetchArray();
}

// Menyimpan perubahan
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $pages_read = $_POST['pages_read'];
    $reading_date = $_POST['reading_date'];
     $tanggal_baca = $_POST['tanggal_baca'];
    
    // Untuk Memasukkan gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Mengambil nama file asli
        $imageName = $_FILES['image']['name'];
        // Tentukan direktori tujuan
        $targetDirectory = 'uploads/';
        // Gabungkan direktori dan nama file
        $targetFile = $targetDirectory . $imageName;
        // Pindahkan file yang diunggah ke direktori 'uploads/'
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Update data buku termasuk gambar
            $db->query("UPDATE books SET title = '$title', image = '$imageName', pages_read = '$pages_read', reading_date = '$reading_date', tanggal_baca = '$tanggal_baca' WHERE id = $id");
            header('Location: index.php');
        } else {
            echo "Terjadi kesalahan saat mengunggah gambar.";
        }
    } else {
        // Jika tidak ada gambar baru, update tanpa mengganti gambar
        $db->query("UPDATE books SET title = '$title', pages_read = '$pages_read', reading_date = '$reading_date', tanggal_baca = '$tanggal_baca' WHERE id = $id");
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Buku</title>
</head>
<body>
    <div class="container">
        <h1>Edit Tracking Buku</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Judul Buku</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

            <label for="image">Cover Buku</label>
            <input type="file" name="image">

            <label for="tanggal_baca">Tanggal Baca:</label>
            <input type="date" name="tanggal_baca" id="tanggal_baca" value="<?php echo htmlspecialchars($book['tanggal_baca']); ?>" required>

            <label for="pages_read">Baca Berapa Halaman</label>
            <input type="number" name="pages_read" value="<?php echo htmlspecialchars($book['pages_read']); ?>" required>

            <label for="reading_date">Waktu Baca</label>
            <input type="text" name="reading_date" value="<?php echo htmlspecialchars($book['reading_date']); ?>" required>

            <input type="submit" name="submit" value="Update Buku" class="button">
        </form>
        <a href="index.php" class="back">Kembali</a>
    </div>
</body>
</html>
