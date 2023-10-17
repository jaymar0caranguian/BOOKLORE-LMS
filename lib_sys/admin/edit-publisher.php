<?php

if(isset($_POST['save'])){
    $publisher_name = $_POST['publisher_name'];
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

    // Check for duplication
    $duplicationCheckSql = "SELECT COUNT(*) as count FROM publisher WHERE publisher_name='$publisher_name'";
    $result = $conn->query($duplicationCheckSql);
    $row = $result->fetch_assoc();
    if($row['count'] == 0){
        // Execute update query to update the publisher name
        $updateSql = "UPDATE publisher SET publisher_name='$publisher_name' WHERE id='$id'";
        if ($conn->query($updateSql) === TRUE) {
            echo "<script>alert('Record updated successfully!');</script>";
            header("Location: publisher.php");
            exit();
        } else {
            echo "Error: " . $updateSql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Publisher name already exists!');</script>";
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
    <title>Edit Publisher</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/course.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include 'sidebar.php';?>
    <!-- Display the form for editing the publisher name -->
    <form method="post" action="">
        <?php
        // Retrieve the publisher details from the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lib_sys";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the publisher details based on the ID passed in the URL
        $id = $_GET['id'];
        $sql = "SELECT * FROM publisher WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $publisher_name = $row['publisher_name'];
                ?>
                <div class="course-management">
                <div class="title">Edit Publisher</div>
                <div class="line"></div>
                <!-- <label for="publisher_name">Publisher Name:</label>
                    <br><br> -->
                    <span id="notification" style="color: red;"></span>
                    <input type="text" id="publishername" name="publisher_name" value="<?php echo $publisher_name; ?>" required>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <br><br>
                <button type="submit" name="save" class="submit-btn" onclick="return confirm('Are you sure you want to update this record?')">
                    <i class='bx bx-save'></i> Update Publisher
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
        <script src="../js/publisher-validation.js"></script>
    </form

    </body>
</html>