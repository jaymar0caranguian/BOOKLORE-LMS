<?php

if(isset($_POST['save'])){
    $coursename = $_POST['coursename'];
    $id = $_POST['id'];

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

    // Check if course name already exists
    $sql_check = "SELECT * FROM tbl_course WHERE coursename='$coursename' AND id<>'$id'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Course name already exists!');</script>";
    } else {
        // Execute update query to update the course name
        $sql = "UPDATE tbl_course SET coursename='$coursename' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully!');</script>";
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
    <title>Edit Course</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/course.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include 'sidebar.php';?>
    <!-- Display the form for editing the course name -->
    <form method="post" action="">
        <?php
        // Retrieve the course details from the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lib_sys";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the course details based on the ID passed in the URL
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_course WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $coursename = $row['coursename'];
                ?>
                <div class="course-management">
                <div class="title">Edit Course</div>
                <div class="line"></div>
                <!-- <label for="coursename">Course Name:</label>
                    <br><br> -->
                    <span id="notification" style="color: red;"></span>
                    <input type="text" id="coursename" name="coursename" value="<?php echo $coursename; ?>" required>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <br><br>
                <button type="submit" name="save" class="submit-btn" onclick="return confirm('Are you sure you want to update this record?')">
                    <i class='bx bx-save'></i> Update Course
                </button>
                </div>
                
            <?php
            }
        } else {
            echo "No record found";
        }

        // Close database connection
        $conn->close();
        ?>
        <script src="../js/coursename-validation.js"></script>
    </form>
</body>
</html>
