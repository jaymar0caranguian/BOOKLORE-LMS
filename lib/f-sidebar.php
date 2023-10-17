<?php
    if(!isset($_SESSION['urole']))
        header('Location: ../login.php?need');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
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
            <a href="./faculty.php">
              <i class='bx bxs-dashboard' ></i>
              <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="./faculty.php">Dashboard</a></li>
            </ul>
          </li>
          <li>
            <a href="./f-settings.php">
              <i class='bx bx-cog' ></i>
              <span class="link_name">Settings</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="./f-settings.php">Settings</a></li>
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