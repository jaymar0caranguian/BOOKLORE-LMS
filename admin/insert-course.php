<?php

if(isset($_POST['save'])){
    $coursename = $_POST['coursename'];

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

    // Check if the course name already exists
    $sql = "SELECT * FROM tbl_course WHERE coursename = '$coursename'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Course name already exists, display an error message
        echo "<script>alert('Course name already exists!');</script>";
    } else {
        // Course name does not exist, insert a new record
        $sql = "INSERT INTO tbl_course (coursename) VALUES ('$coursename')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully!');</script>";
            header("Location: course.php");
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
    <title>Insert Course</title>
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
        <div class="title">Insert Course</div>
        <div class="line"></div>
        <div class="course-form">
          <form method="post">
            <!-- <label for="coursename">Course Name:</label>
            <br><br> -->
            <span id="notification" style="color: red;"></span>
            <input type="text" id="coursename" name="coursename" placeholder="Eg: BSIT / BSIE / BSA" required>
            <br><br>
            <button type="submit" name="save" class="submit-btn" onclick="return confirm('Are you sure you want to save this record?')">
              <i class='bx bx-save'></i> Save Course
            </button>
          </form>
        </div>
      </div> 
      <script src="../js/coursename-validation.js"></script>
</body>
</html>
