<?php
if(isset($_POST['save'])){
    $tagName = $_POST['tagname'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lib_sys";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if tag name already exists
    $sql = "SELECT tag_name FROM tag WHERE tag_name = '$tagName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Genre name already exists!');</script>";
    } else {
        // Execute insert query
        $sql = "INSERT INTO tag (tag_name) VALUES ('$tagName')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully!');</script>";
            header("Location: tag.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Genre</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/course.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include 'sidebar.php';?>

    <!-- Start here -->
    <div class="course-management">
        <div class="title">Add Genre</div>
        <div class="line"></div>
        <div class="course-form">
          <form method="post">
            <!-- <label for="tagname">Tag Name:</label>
            <br><br> -->
            <span id="notification" style="color: red;"></span>
            <input type="text" id="tagname" name="tagname" placeholder="Input Genre" required>
            <br><br>
            <button type="submit" name="save" class="submit-btn" onclick="return confirm('Are you sure you want to save this record?')">
              <i class='bx bx-save'></i> Save Genre
            </button>
          </form>
        </div>
      </div> 
      <script src="../js/tag-validation.js"></script>
</body>
</html>
