<?php
// Database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the ID of the record to delete
$id = $_GET['id'];

// Check if there are any dependent records in the books table
$sql_check = "SELECT COUNT(*) AS cnt FROM books WHERE publisher_id = $id";
$result = mysqli_query($conn, $sql_check);
$row = mysqli_fetch_assoc($result);
$count = $row['cnt'];

if ($count > 0) {
    // There are dependent records, so don't delete the publisher
    echo "Cannot delete this publisher because there are books associated with it.";
} else {
    // No dependent records, so delete the publisher
    $sql_delete = "DELETE FROM publisher WHERE id = $id";
    mysqli_query($conn, $sql_delete);
    echo "Publisher deleted successfully.";
}

// Close database connection
mysqli_close($conn);

// Redirect back to the original page
header("Location: publisher.php");
exit();


?>
