<?php
require "db.php";
$id = $_GET['id'];
$db->query("DELETE FROM books WHERE id = $id");
header('Location: index.php');
?>
