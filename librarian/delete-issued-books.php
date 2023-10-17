<?php
// Database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the ID of the record to delete
$id = $_GET['id'];

// Delete the record from the database
$sql = "DELETE FROM tbl_issued WHERE id = $id";
mysqli_query($conn, $sql);

// Close database connection
mysqli_close($conn);

// Redirect back to the original page
header("Location: issued-books.php");
exit();
?>
