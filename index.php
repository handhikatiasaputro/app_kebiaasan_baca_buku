<?php
require "db.php";

// Tambahkan catatan baca
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $pages_read = $_POST['pages_read'];
    $reading_date = $_POST['reading_date'];
    $tanggal_baca = $_POST['tanggal_baca'];

 // Untuk Memasukan gambar
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Mengambil nama file asli
    $imageName = $_FILES['image']['name'];
    // Tentukan direktori tujuan
    $targetDirectory = 'uploads/';
    // Gabungkan direktori dan nama file
    $targetFile = $targetDirectory . $imageName;
    // Pindahkan file yang diunggah ke direktori 'uploads/'
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        echo "Gambar berhasil diunggah!";
    } else {
        echo "Terjadi kesalahan saat mengunggah gambar.";
    }
} else {
    $imageName = null; // Jika tidak ada gambar yang diunggah
}


    $db->query("INSERT INTO books (title, image, pages_read, reading_date, tanggal_baca) VALUES ('$title', '$imageName', '$pages_read', '$reading_date', '$tanggal_baca')");
    header('Location: index.php');
}

// Fetch all books
$results = $db->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tracking Kebiasaan Baca Buku
    </title>
</head>
<body>
    <div class="container">
        <h1>Tambah Catatan Membaca</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Judul Buku</label>
            <input type="text" name="title" required>

            <label for="image">Cover Buku</label>
            <input type="file" name="image">

            <label for="tanggal_baca">Tanggal Baca:</label>
            <input type="date" name="tanggal_baca" id="tanggal_baca" required>

            <label for="pages_read">Baca Berapa Halaman</label>
            <input type="number" name="pages_read" required>

            <label for="reading_date">Waktu Baca</label>
            <input type="text" name="reading_date" required>

            <input type="submit" name="submit" value="Kirim"class="button">
        </form>

        <h2>Catatan Kebiasaan Baca Buku </h2>
        <table>
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Baca</th>
                    <th>Jumlah Halaman</th>
                    <th>Waktu Baca</th>
                    <th>Aksi    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $results->fetchArray()) : ?>
                <tr>
                    <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="350" height="70"></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_baca']))); ?></td>
                    <td><?php echo htmlspecialchars($row['pages_read']); ?></td>
                    <td><?php echo htmlspecialchars($row['reading_date']); ?></td>
                    <td class="action-buttons">
                        <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
