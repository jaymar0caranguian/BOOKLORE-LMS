<?php
error_reporting(E_ERROR);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$sql = "SELECT COUNT(*) as totalBooks FROM books";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBooks = $row["totalBooks"];
}
else {
    $totalBooks = 0;
}

$sql = "SELECT SUM(fine) as totalFine FROM tbl_issued";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalFine = $row["totalFine"];
}
else {
    $totalFine = 0;
}

//$sql = "SELECT SUM(borrowed) as totalBorrowed FROM books";
//$result = $conn->query($sql);

//if ($result->num_rows > 0) {
//    $row = $result->fetch_assoc();
//    $totalBorrowed = $row["totalBorrowed"];
//} else {
//    $totalBorrowed = 0;
//}

$sql = "SELECT COUNT(*) as totalUsers FROM tbl_user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row["totalUsers"];
} else {
    $totalUsers = 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian | Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/course.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <!-- Start here -->
    <div class="course-management">
        <div class="title">Dashboard
        </div>

        <div class="line"></div>

        <ul class="box-info">
            <li>
                <i class='bx bxs-book'></i>
                <span class="text">
                    <p>Total Books</p>
                    <h3><?php echo $totalBooks; ?></h3>
                </span>
            </li>
            <li>
                <i class='bx bxs-dollar-circle'></i>
                <span class="text">
                    <p>Collect Fine</p>
                    <h3><?php echo $totalFine; ?></h3>
                </span>
            </li>
            <!-- <li>
                <i class='bx bxs-cart-alt'></i>
                <span class="text">
                    <p>Total Borrowed</p>
                    <h3><?php echo $totalBorrowed ?? 0; ?></h3>
                </span>
            </li> -->
            <li>
                <i class='bx bxs-group'></i>
                <span class="text">
                    <p>Users</p>
                    <h3><?php echo $totalUsers; ?></h3>
                </span>
            </li>
        </ul>
    </div>
</body>

</html>