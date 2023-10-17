<?php
// Database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'];
$sql = "DELETE FROM books WHERE id = $id";

mysqli_query($conn, $sql);
mysqli_close($conn);

header("Location: mng-books.php");
exit();
?>
