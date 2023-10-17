<?php

if(isset($_POST['save'])){
    $yearsname = $_POST['yearsname'];

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

    // Check if the year name already exists
    $sql = "SELECT * FROM tbl_years WHERE yearsname = '$yearsname'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Year name already exists, display an error message
        echo "<script>alert('Year name already exists!');</script>";
    } else {
        // Year name does not exist, insert a new record
        $sql = "INSERT INTO tbl_years (yearsname) VALUES ('$yearsname')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully!');</script>";
            header("Location: course-year.php");
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
    <title>Insert Course Year</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/course.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include 'sidebar.php';?>

    <!-- Start here -->
    <div class="course-management">
        <div class="title">Insert Course Year</div>
        <div class="line"></div>
        <div class="course-form">
          <form method="post">
            <!-- <label for="yearsname">Course Year Name:</label>
            <br><br> -->
            <span id="notification" style="color: red;"></span>
            <input type="text" id="yearsname" name="yearsname" placeholder="Eg: 1st Year / 2nd Year / 3rd Year / 4th Year" required>
            <br><br>
            <button type="submit" name="save" class="submit-btn" onclick="return confirm('Are you sure you want to save this record?')">
              <i class='bx bx-save'></i> Save Course Year
            </button>
          </form>
        </div>
      </div> 
      <script src="../js/courseyear-validation.js"></script>
</body>
</html>
