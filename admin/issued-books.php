<?php
// Database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = new mysqli($servername, $username, $password, $dbname);

// Get total number of records in the database
$sql = "SELECT COUNT(*) as total FROM tbl_issued";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalRecords = $row['total'];

// Define how many records to display per page
$recordsPerPage = 5;

// Calculate total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Get current page number from query parameter, default to 1 if not set
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($currentpage - 1) * $recordsPerPage;

// Get records from the database based on search input with pagination
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST["search"];
    $sql = "SELECT * FROM tbl_issued 
            WHERE book_code LIKE '%$search%' OR user_id LIKE '%$search%'
            LIMIT $offset, $recordsPerPage";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM tbl_issued
            LIMIT $offset, $recordsPerPage";
    $result = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/course-year.css">
    <link rel="stylesheet" href="../css/pagination.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet" />
    <style>
        .left-align::placeholder {
        text-align: left !important;
        padding-left: 10px !important;
        }

        .input-field {
        text-align: center !important;
        color: gray;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php';?>

    <!-- Start here -->
    <div class="course-management">
    <div class="title">Issued Books       
        </div>

        <div class="search-bar">
                <form method="post" action="">
                    <i class="lni lni-magnifier" style="position: absolute; color: gray; padding-left: 90px; padding-top: 12px; left: 0px;"></i>
                    <input type="text" id="search-issued" name="search" placeholder="&nbsp; &nbsp; &nbsp; Search for book code and user id" class="left-align input-field">
                </form>
                <span id="notification" style="color: red;"></span>
            </div>
        
            <br>

        <div class="line"></div>

        <?php

        if (mysqli_num_rows($result) == 0) {
         echo '<p>Sorry, There is no results found.</p>';
        } else {


        // Display table
        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Book Code</th>';
        echo '<th>User ID</th>';
        echo '<th>Issue Date</th>';
        echo '<th>Return Date</th>';
        echo '<th>A. Return Date</th>';
        echo '<th>Fine</th>';
        echo '<th>Action</th>'; // Added action column
        echo '</tr>';
        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['book_code'] . '</td>';
            echo '<td>' . $row['user_id'] . '</td>';
            echo '<td>' . $row['issue_date'] . '</td>';
            echo '<td>' . $row['return_date'] . '</td>';
            echo '<td>' . $row['actual_return_date'] . '</td>';
            echo '<td>' . $row['fine'] . '</td>';
	        echo '<td>'; // Action column
            echo '<a href="update-issue.php?id=' . $row['id'] . '"><i class="bx bx-check"></i></a>';
            // echo '<a href="edit-issued-books.php?id=' . $row['id'] . '"><i class="bx bx-edit"></i></a>'; 
            echo '<a href="delete-issued-books.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\');"><i class="bx bx-trash"></i></a>'; // Delete button
            echo '</td>';
            echo '</tr>';
            echo '</tr>';
        }
        echo '</table>';

    }

        // Close database connection
        mysqli_close($conn);
        ?>

    </div>

    <div class="pagination">
        <ul>
            <?php
            // Display Previous link if not on the first page
            if ($currentpage > 1) {
                echo '<li><a href="?page=' . ($currentpage - 1) . '">&laquo; Previous</a></li>';
            }

            // Display numbered page links
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
            }

            // Display Next link if not on the last page
            if ($currentpage < $totalPages) {
                echo '<li><a href="?page=' . ($currentpage + 1) . '">Next &raquo;</a></li>';
            }
            ?>
        </ul>
    </div>
    <script src="../js/issued-validation.js"></script>
</body>

</html>



