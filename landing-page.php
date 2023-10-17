<?php
    session_start();
    if(isset($_GET['logout']))
        session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System | Main</title>
    <link rel="stylesheet" href="./css/landing.css">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/banner.css">

    <style>
        .card {
            display: flex;
            width: 40%;
            padding-right: 3px;
            margin: 0px;
            border-color: gray !important;
            border-width: 1px !important;
            border-radius: 16px !important;
            border-style: solid;
            text-align: left;
        }

        .card-left, .card-right {
            width: 50%;
        }

        .card-right {
            padding-top: 16px;
        }

        .card img {
            margin-top: 2px;
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
            width: 80%;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a href="">BOOKLORE</a></li>
            <li class="nav-item"><a href="#home">HOME</a></li>
            <li class="nav-item"><a href="#faqs">FAQS</a></li>
            <li class="nav-item"><a href="#contact">CONTACT</a></li>
            <li class="nav-item"><a href="./login.php">LOGIN</a></li>
        </ul>
    </nav>
    <div id="home">
    <div class="search-bar-container">
        <div class="search-bar">
            <form action="" method="get">
                <h1 style="position: relative"><i class="lni lni-magnifier" style="position: absolute; color: black; padding-left: 30px; padding-top: 12px; left: 0px;"></i></h1>
                <input type="text" class="search-input" name="search" placeholder="Search by Title, and Author" <?php echo isset($_GET['search']) ? "value='".$_GET['search']."'" : ""; ?>>
                <input type="submit" style="display: none" />
            </form>
        </div>
    </div>
    </div>

    <?php
        if(isset($_GET['search']) && $_GET['search'] != '') {
    ?>

    <div class="search-result">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "lib_sys";
            $conn = new mysqli($servername, $username, $password, $dbname);
        
            $result = mysqli_query($conn, "SELECT books.image, books.id, books.qty, books.image, books.isbn, books.book_title, author.author_name FROM author, books WHERE books.author_id=author.id AND (books.book_title LIKE '%".$_GET['search']."%' OR author.author_name LIKE '%".$_GET['search']."%')");
        ?>

        <h1>Search results for <?php echo "\"".$_GET['search']."\" (".mysqli_num_rows($result).")"; ?></h1>
        <br/>

        <center>
        <?php
            if(mysqli_num_rows($result) == 0)
                echo "<p>No results found.</p><br/><br/>";
            while($row = mysqli_fetch_assoc($result))
                echo "<div class='card'><div class='card-left'><img src='".substr($row['image'], 3)."'/></div><div class='card-right'><h2>".$row['book_title']."</h2><br/><p><b>ISBN:</b> ".$row['isbn']."<br/><b>Author:</b> ".$row["author_name"]."<br/><b>Book Quantity:</b> ".$row['qty']."</p></div></div><br/>";
        ?>
        </center>
    </div>

    <?php
        }
        else {
    ?>
    <div id="faqs">
        <h1>Frequently Asked Questions</h1>
        <div class="faqs-container">
            <div class="faq active">
                <h3 class="faq-title">
                    How do I create an account on the Booklore Library Management System?
                </h3>
                <p class="faq-text">
                    Only the admin can create accounts on the Booklore Library Management System. Students cannot create their own
                    accounts. Please contact the admin to request an account creation.
                </p>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
    
            <div class="faq">
                <h3 class="faq-title">
                    Can I change my profile picture and password?
                </h3>
                <p class="faq-text">
                    Yes, students can change their profile picture and password after logging into their account. Please go
                    to the "Settings" section in your account settings to make any changes.
                </p>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
    
            <div class="faq">
                <h3 class="faq-title">
                    Can I return a borrowed book before the due date?
                </h3>
                <p class="faq-text">
                    Yes, you can return a borrowed book before the due date by visiting the library in person and returning
                    the book to the library location. The library staff will update the status of the book in
                    your account.
                </p>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
    
            <div class="faq">
                <h3 class="faq-title">
                    How do I contact the admin or library staff for assistance?
                </h3>
                <p class="faq-text">
                    You can contact the admin or library staff through the "Contact Us" section in the System or by using
                    the contact information provided. Please allow for reasonable response time for inquiries and requests.
                </p>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
    
            <div class="faq">
                <h3 class="faq-title">
                    How is my personal information protected?
                </h3>
                <p class="faq-text">
                    We take reasonable measures to protect the security and privacy of your personal information within our
                    control. However, no method of transmission over the Internet or electronic storage is completely
                    secure. Please refer to our Privacy Policy for more information on how we collect, use, and disclose
                    personal information.
                </p>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
    
            <div class="faq">
                <h3 class="faq-title">
                    Can I share my account information with others?
                </h3>
                <p class="faq-text">
                    No, sharing your account information with others is strictly prohibited. Your account is for your
                    personal use only, and you are responsible for maintaining the confidentiality of your account
                    information. Any unauthorized use of your account may result in suspension or termination of your
                    account privileges.
                </p>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
    
            <div class="faq">
                <h3 class="faq-title">
                    How is my personal information protected?
                </h3>
                <p class="faq-text">
                    We take reasonable measures to protect the security and privacy of your personal information within our
                    control. However, no method of transmission over the Internet or electronic storage is completely
                    secure. Please refer to our Privacy Policy for more information on how we collect, use, and disclose
                    personal information.
                </p>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="contact-container">
        <div class="map-container">
            <!-- Embedded Google Map -->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61742.023229184975!2d121.02794331327333!3d14.71957627635532!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b05760295d7f%3A0xd578bee37f58277a!2sNovaliches%2C%20Quezon%20City%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1681382658962!5m2!1sen!2sph"
                width="800" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                tabindex="0"></iframe>
        </div>
        
        <div id="contact">
        <div class="contact-info-container">
            <div class="address-container">
                <h2><i class="fas fa-map-marker-alt"></i> Address</h2><br>
                <p>
                    Novaliches Quezon City <br>
                    Metro Manila, 1123
                </p>
            </div>
            <div class="email-container">
                <h2><i class="fas fa-envelope"></i> Email</h2><br>
                <p>books@booklore.com</p>
            </div>
            <div class="contact-number-container">
                <h2><i class="fas fa-phone"></i> Contact Number</h2><br>
                <p>(555) 555-1234</p>
            </div>
        </div>
        </div>
    </div>

    <?php
        }
    ?>

    <div class="footer-container">
        <div class="footer-left">
            <h2>Booklore</h2>
            <br>
            <p>Welcome to the Booklore Library System, your go-to destination for all your reading needs. Our library is open from Monday to Friday, 9:00 AM to 7:00 PM, and on Saturday from 10:00 AM to 5:00 PM.</p>
            <br><br>
            <p>&copy; 2023 Booklore. All rights reserved.</p>
        </div>
        <div class="footer-right">
            <h2>Follow Us</h2>
            <br>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
                <a href="https://mail.google.com" target="_blank"><i class="fas fa-envelope fa-2x" aria-hidden="true"></i></a>
            </div>
            <br><br><br>
            <p><a href="./terms-condition.php" target="_blank">Terms & Conditions</a> | <a href="./privacy-policy.php" target="_blank">Privacy Policy</a></p>
        </div>
    </div>

    <script src="./js/index.js"></script>
    <script src="https://kit.fontawesome.com/60d035dc34.js" crossorigin="anonymous"></script>
    <script>
        var modal = document.getElementById("myModal");
        var closeBtn = document.getElementsByClassName("close")[0];

        window.onload = function () {
            modal.style.display = "block";
        }

        closeBtn.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>