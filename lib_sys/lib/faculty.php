<?php
session_start();
if(!isset($_SESSION['urole']))
    header('Location: ../login.php?need');

$conn = mysqli_connect("localhost", "root", "", "lib_sys");
if(!$conn)
    die("Connection failed: " . mysqli_connect_error());

$error_message = "";
$success_message = "";

if (isset($_SESSION['uid'])) {
    $user_id = $_SESSION['uid'];

    $query = "SELECT * FROM tbl_issued WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $table = "<table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Book Code</th>
                            <th>Issue Date</th>
                            <th>Return Date</th>
                            <th>Actual Return Date</th>
                            <th>Fine</th>
                        </tr>
                    </thead>
                    <tbody>";

        while($row = mysqli_fetch_assoc($result)) {
            $table .= "<tr>
                            <td>" . $row['user_id'] . "</td>
                            <td>" . $row['book_code'] . "</td>
                            <td>" . $row['issue_date'] . "</td>
                            <td>" . $row['return_date'] . "</td>
                            <td>" . $row['actual_return_date'] . "</td>
                            <td>" . $row['fine'] . "</td>
                        </tr>";
        }

        $table .= "</tbody></table>";
    } else {
        $table = "<p>No issued books found.</p>";
    }
} else {
    header("Location: login.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/course-year.css">
</head>
<body>
    <?php include 'f-sidebar.php';?>
    
    <!-- Start here -->
    <div class="course-management">
    <div class="title">Faculty Dashboard
    </div>
    <div class="line"></div>
    <?php echo $table; ?>
    </div>
    
</body>
</html>
