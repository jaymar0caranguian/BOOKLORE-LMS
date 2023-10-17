<?php

if(isset($_POST['save'])){
    $yearsname = $_POST['yearsname'];
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
    $sql_check = "SELECT * FROM tbl_years WHERE yearsname='$yearsname' AND id<>'$id'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Year name already exists!');</script>";
    } else {
        // Execute update query to update the course name
        $sql = "UPDATE tbl_years SET yearsname='$yearsname' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully!');</script>";
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
    <title>Edit Years</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/course.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include 'sidebar.php';?>
    <!-- Display the form for editing the years name -->
    <form method="post" action="">
        <?php
        // Retrieve the years details from the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lib_sys";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the years details based on the ID passed in the URL
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_years WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $yearsname = $row['yearsname'];
                ?>
                <div class="course-management">
                <div class="title">Edit Year</div>
                <div class="line"></div>
                <!-- <label for="yearsname">Years Name:</label>
                    <br><br> -->
                    <span id="notification" style="color: red;"></span>
                    <input type="text" id="yearsname" name="yearsname" value="<?php echo $yearsname; ?>" required>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <br><br>
                <button type="submit" name="save" class="submit-btn" onclick="return confirm('Are you sure you want to update this record?')">
                    <i class='bx bx-save'></i> Update Year
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
        <script src="../js/courseyear-validation.js"></script>
   
