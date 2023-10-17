<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'];

// Check if the book has already been returned
$sql = "SELECT actual_return_date FROM tbl_issued WHERE id={$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row['actual_return_date'] != null) {
  header("Location: issued-books.php?msg=book_returned");
  exit;
}

// Get the due date and calculate the days late and fine
$sql = "SELECT return_date, book_code FROM tbl_issued WHERE id={$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$return_date = date('Y-m-d'); // Get the current date
$due_date = $row['return_date'];
$actual_return_date = $return_date;
if ($actual_return_date <= $due_date) {
  $days_late = 0;
  $fine = 0;
} else {
  $days_late = max(0, (strtotime($actual_return_date) - strtotime($due_date)) / (60 * 60 * 24));
  $fine = $days_late * 5;
}

// Update the actual return date and fine in the database
$book_code = $row['book_code'];
$sql = "UPDATE books SET qty=qty+1 WHERE id={$book_code}";
mysqli_query($conn, $sql);
$sql = "UPDATE tbl_issued SET actual_return_date='$actual_return_date', fine='$fine' WHERE id={$id}";
mysqli_query($conn, $sql);
echo "Book return successfully!";
header("Location: ./issued-books.php"); // Redirect the user back to the issued-books.php page
exit; // Terminate the script
?>
