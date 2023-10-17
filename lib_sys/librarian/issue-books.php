<?php
// Database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get all user IDs from tbl_user
$userSql = "SELECT id FROM tbl_user";
$userResult = $conn->query($userSql);
$userIdOptions = "";
if ($userResult->num_rows > 0) {
  while ($userRow = $userResult->fetch_assoc()) {
    $userIdOptions .= "<option value='" . $userRow['id'] . "'>" . $userRow['id'] . "</option>";
  }
}

if (isset($_POST['right_search'])) {
  $bookSearchTerm = $_POST['right_search'];
  $bookSql = "SELECT b.id, b.book_title, t.tag_name, b.qty
              FROM books b 
              INNER JOIN tag t ON b.tag_id = t.id 
              WHERE b.id = ?";
  $bookStmt = $conn->prepare($bookSql);
  $bookStmt->bind_param("s", $bookSearchTerm);
  $bookStmt->execute();

  $bookResult = $bookStmt->get_result();

  if ($bookResult->num_rows > 0) {
    $row = $bookResult->fetch_assoc();
    $id = $row['id'];
    $bookTitle = $row['book_title'];
    $tagName = $row['tag_name'];
    $qty = $row['qty'];
  } else {
    $id = "";
    $bookTitle = "";
    $tagName = "";
    $qty = "";
  }
} else {
  $id = "";
  $bookTitle = "";
  $tagName = "";
  $qty = "";
}
?>

<?php
if (isset($_POST['issue_book'])) {
  $bookId = $_POST['book_id'];
  $userId = $_POST['user_id'];
  $issueDate = $_POST['start-date'];
  $returnDate = $_POST['end-date'];

  $issueSql = "INSERT INTO tbl_issued (book_code, user_id, issue_date, return_date) VALUES (?, ?, ?, ?)";
  $issueStmt = $conn->prepare($issueSql);
  $issueStmt->bind_param("iiss", $bookId, $userId, $issueDate, $returnDate);

  // Deduct the quantity of the book with the same ID from the books table that matches the book_code from tbl_issued
  $deductSql = "UPDATE books SET qty = qty - 1 WHERE id = ?";
  $deductStmt = $conn->prepare($deductSql);
  $deductStmt->bind_param("i", $bookId);

  if ($issueStmt->execute() && $deductStmt->execute()) {
    echo "<script>alert('Book issued successfully.');</script>";
  } else {
    echo "<script>alert('Error issuing book.');</script>";
  }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Issue Books</title>
  <link rel="stylesheet" href="../css/course.css">
  <link rel="stylesheet" href="../css/issue-books.css">
</head>
<body>
  <?php include 'sidebar.php'; ?>
  <span id="notification" style="color: red; margin-left: 400px;"></span>

  <!-- Start here -->
  <div class="course-management">
    <div class="title">Issue Books</div>

    <div class="line"></div>

    <form method="POST">
      <div class="search-container">
        <div class="right-search">
          <input type="text" id="issue-search" name="right_search" placeholder="Search..." required>
          <button type="submit">Search</button>
        </div>
      </div>
    </form>
    
    <form method="post">
  <div class="textbox-container-right">
    <select name="user_id" class="textbox" required>
      <option value="">Select User ID</option>
      <?php echo $userIdOptions; ?>
    </select>

    <input type="text" name="book_id" class="textbox" placeholder="Id" value="<?php echo $id; ?>" readonly>
    <input type="text" name="book_title" class="textbox" placeholder="Book Title" value="<?php echo $bookTitle; ?>" readonly>
    <input type="text" name="book_genre" class="textbox" placeholder="Book Genre" value="<?php echo $tagName; ?>" readonly>
  </div>

  <!-- Update the hidden input element with the selected user_id value before the form is submitted -->
  <input type="hidden" name="user_id" value="" id="user_id_hidden_input">

  <label for="start-date">Issue Date:</label>
  <input type="date" id="start-date" name="start-date" required>

  <label for="end-date">Return Date:</label>
  <input type="date" id="end-date" name="end-date" required>

  <input type="hidden" name="book_id" value="<?php echo $id; ?>">
  <input type="hidden" name="book_title" value="<?php echo $bookTitle; ?>">
  <input type="hidden" name="book_genre" value="<?php echo $tagName; ?>">

  <!-- Add a JavaScript function to update the value of the hidden input element with the selected user_id value -->
  <button type="submit" name="issue_book" onclick="updateUserIdValue()"><i class='bx bx-save'></i>Issue Book</button>
</form>
</div>


    </div>

    <script>
function updateUserIdValue() {
  // Get the selected user_id value from the dropdown select element
  var selectedUserId = document.getElementsByName("user_id")[0].value;

  // Update the value of the hidden input element with the selected user_id value
  document.getElementById("user_id_hidden_input").value = selectedUserId;
}
</script>

<script src="../js/issue-validation.js"></script>
</body>
</html>