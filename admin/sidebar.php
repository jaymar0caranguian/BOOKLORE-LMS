<?php
    session_start();

    if(!isset($_SESSION['uid']))
        header("Location: ../login.php?need");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Sidebar</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/navigation.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="sidebar close">
        <div class="logo-details">
          <i class='bx bx-book-open'></i>
          <span class="logo_name">Booklore</span>
        </div>
        <ul class="nav-links">
          <li>
            <a href="./admin.php">
              <i class='bx bxs-dashboard' ></i>
              <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="./admin.php">Dashboard</a></li>
            </ul>
          </li>
          <li>
            <div class="iocn-link">
              <a href="#">
                <i class='bx bx-collection' ></i>
                <span class="link_name">Classification</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <li><a class="link_name" href="#">Classification</a></li>
              <li><a href="./author.php">Manage Author</a></li>
              <li><a href="./publisher.php">Manage Publisher</a></li>
              <li><a href="./tag.php">Manage Genre</a></li>
            </ul>
          </li>
          <li>
            <div class="iocn-link">
              <a href="#">
                <i class='bx bx-book-alt' ></i>
                <span class="link_name">Academics</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <li><a class="link_name" href="#">Academics</a></li>
              <li><a href="./course.php">Manage Course</a></li>
              <li><a href="./course-year.php">Manage Year</a></li>
            </ul>
          </li>
          
          <li>
            <div class="iocn-link">
              <a href="#">
                <i class='bx bx-library' ></i>
                <span class="link_name">Manage Library</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <li><a class="link_name" href="#">Manage Library</a></li>
              <li><a href="./insert-books.php">Add Book</a></li>
              <li><a href="./mng-books.php">Manage Books</a></li>
              <li><a href="./issue-books.php">Issue Books</a></li>
              <li><a href="./issued-books.php">Issued Books</a></li>
            </ul>
          </li>
          <li>
            <a href="./manage-user.php">
              <i class='bx bx-user' ></i>
              <span class="link_name">Manage Users</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="./manage-user.php">Manage Users</a></li>
            </ul>
          </li>
          <li>
            <a href="./reports.php">
              <i class='bx bxs-report'></i>
              <span class="link_name">Reports</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="./reports.php">Reports</a></li>
            </ul>
          </li>
          <li>
            <a href="./settings.php">
              <i class='bx bx-cog' ></i>
              <span class="link_name">Settings</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="./settings.php">Settings</a></li>
            </ul>
          </li>
          <li>
        <div class="profile-details">
          <div class="profile-content">
          </div>
          <div class="name-job">
            <div class="profile_name"></div>
            <div class="job"></div>
          </div>
          <i id="logout-btn" class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
    <!-- Put all the necessary codes here -->
      </div>
      <section class="home-section">
        <div class="home-content">
          <i class='bx bx-menu' ></i>
          <span class="text"></span>
        </div>
</body>
    <!-- Scripts -->
    <script src="../js/navigation.js"></script>
    <script src="../js/logout.js"></script>
</html>