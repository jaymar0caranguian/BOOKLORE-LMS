<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Course Year's</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/course-year.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include 'sidebar.php';?>

    <!-- Start here -->
    <div class="course-management">
    <div class="title">Manage Course Year's
    <a href="insert-course-year.php">
    <button class="add-btn"><i class='bx bxs-plus-circle'></i>Add Course Year</button>
    </a>
    </div>

    <div class="line"></div>

        <?php
            // Database connection code goes here
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "lib_sys";
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Number of records to display per page
            $records_per_page = 5;

            // Get total number of records from the database
            $sql = "SELECT COUNT(*) FROM tbl_years";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $total_records = $row[0];

            // Calculate total number of pages
            $total_pages = ceil($total_records / $records_per_page);

            // Get current page number
            if (!isset($_GET['page'])) {
                $current_page = 1;
            } else {
                $current_page = $_GET['page'];
            }

            // Calculate start and end record index for the current page
            $start_record = ($current_page - 1) * $records_per_page;
            $end_record = $start_record + $records_per_page - 1;

            // Get records from the database
            $sql = "SELECT * FROM tbl_years LIMIT $start_record, $records_per_page";
            $result = mysqli_query($conn, $sql);

            // Display table
            echo '<table>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Year</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['yearsname'] . '</td>';
                echo '<td>';
                echo '<a href="edit-course-year.php?id=' . $row['id'] . '&action=edit"><i class="bx bx-edit"></i></a>';
                echo '<a href="delete-course-year.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\');"><i class="bx bx-trash"></i></a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';

            // Display pagination links
            if ($total_pages > 1) {
                echo '<div class="pagination">';
                echo '<ul>';
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $current_page) {
                        echo '<li><a class="active">' . $i . '</a></li>';
                    } else {
                        echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                echo '</ul>';
                echo '</div>';
            }

            // Close database connection
            mysqli_close($conn);

       
