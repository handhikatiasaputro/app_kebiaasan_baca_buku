<?php
// Koneksi Database
$db = new SQLite3('baca.db');

// Membuat table
$db->query("CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    image TEXT,
    tanggal_baca TEXT NOT NULL,
    pages_read INTEGER NOT NULL,
    reading_date TEXT NOT NULL
)");
?>
