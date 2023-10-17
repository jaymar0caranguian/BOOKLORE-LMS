<?php
// Database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = new mysqli($servername, $username, $password, $dbname);

// Get total number of records in the database
$sql = "SELECT COUNT(*) as total FROM tbl_user";
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
    $sql = "SELECT * FROM tbl_user 
            WHERE full_name LIKE '%$search%' OR email LIKE '%$search%'
            LIMIT $offset, $recordsPerPage";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM tbl_user
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
    <title>Manage User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/course-year.css">
    <link rel="stylesheet" href="../css/pagination.css">
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="course-management">
    <?php
        $db = mysqli_connect("localhost", "root", "", "lib_sys");

        if(isset($_GET["delete"]) && mysqli_query($db, "DELETE FROM tbl_user WHERE id=".$_GET["id"]))            
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: green; color: white; border-radius: 6px">Successfully deleted!</div>';
    ?>

    <div class="pure-g">
        <div class="pure-u-1-5">
            <div class="title">Manage Users</div>
        </div>

        <div class="pure-u-4-5">
            <a href="insert-user.php"><button class="add-btn" style="margin-right: 6px"><i class='bx bx-plus-circle'></i> Add Users</button></a>
        </div>

    </div>
    <hr />

    <?php
        $result = mysqli_query($db, "SELECT * FROM tbl_user");

        echo '<table>';
        echo '<tr>';
        echo '<th>User ID</th>';
        // echo '<th>Display Picture</th>';
        echo '<th>Name</th>';
        echo '<th>Email</th>';
        echo '<th>Role</th>';
        echo '<th>Year</th>';
        echo '<th>Actions</th>';
        echo '</tr>';

        if(mysqli_num_rows($result) == 0)
            echo "<tr><td colspan=\"7\"><br/><center>No users yet.</center><br/></tr>";

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<td>'.$row['id'].'</td>';
            // echo '<td><img src="'.$row['u_img'].'" width="200" height="200" /></td>';
            echo '<td>'.$row['full_name'].'</td>';
            echo '<td>'.$row['email'].'</td>';
            echo '<td>'.$row['roles'].'</td>';
            echo '<td>'.mysqli_fetch_row(mysqli_query($db, "SELECT yearsname FROM tbl_years WHERE id=".$row['year_id']))[0].'</td>';
            echo '<td>';
            echo '<a href="print-card.php?id=' . $row['id'] . '"><i class="bx bxs-id-card"></i></a>';
            echo '<a href="edit-user.php?id=' . $row['id'] . '"><i class="bx bx-edit"></i></a>';
            echo '<a href="manage-user.php?delete&id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this user?\');"><i class="bx bx-trash"></i></a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        mysqli_close($db);
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
    
</body>
</html>