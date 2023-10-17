<?php
if(isset($_POST['save'])){
    $publisherName = $_POST['publishername'];

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

    // Check if publisher name already exists
    $sql = "SELECT publisher_name FROM publisher WHERE publisher_name = '$publisherName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Publisher name already exists!');</script>";
    } else {
        // Execute insert query
        $sql = "INSERT INTO publisher (publisher_name) VALUES ('$publisherName')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully!');</script>";
            header("Location: publisher.php");
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
    <title>Add Publisher</title>
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
        <div class="title">Add Publisher</div>
        <div class="line"></div>
        <div class="course-form">
          <form method="post">
            <!-- <label for="publishername">Publisher Name:</label>
            <br><br> -->
            <span id="notification" style="color: red;"></span>
            <input type="text" id="publishername" name="publishername" placeholder="Input Publisher Name" required>
            <br><br>
            <button type="submit" name="save" class="submit-btn" onclick="return confirm('Are you sure you want to save this record?')">
              <i class='bx bx-save'></i> Save Publisher
            </button>
          </form>
        </div>
      </div> 
      <script src="../js/publisher-validation.js"></script>
</body>
</html>
