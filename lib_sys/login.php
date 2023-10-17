<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "lib_sys");

if(!$conn)
    die("Connection failed: " . mysqli_connect_error());

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '".sha1($password)."'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $role = $row["roles"];

        $_SESSION['uid'] = $row['id'];
        $_SESSION['uimg'] = $row['u_img'];
        $_SESSION['uname'] = $row['full_name'];
        $_SESSION['uaddr'] = $row['addresss'];
        $_SESSION['uemail'] = $row['email'];
        $_SESSION['urole'] = $row['roles'];

        $success_message = "Login successful.";
        if ($role == "student") {
            header("Refresh:1; url=lib/students.php");
        } else if ($role == "librarian") {
            header("Refresh:1; url=librarian/librarian.php");
        } else if ($role == "faculty") {
            header("Refresh:1; url=lib/faculty.php");
        } else if ($role == "super admin") {
            header("Refresh:1; url=admin/admin.php");
        }
        exit();
    } else {
        $error_message = "Invalid email or password";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Library System | Login</title>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/banner.css">
</head>

<body>
    <?php include 'banner.php';?>
    <div class="login-box">
        <?php
            if(isset($_GET['need']))
                echo "<div style='background-color: red; color: white; padding: 6px; margin-bottom: 12px; border-radius: 4px; text-align: center'>You need to log-in first.</div>";
        ?>
        <form action="#" method="post">
            <?php if (!empty($error_message)) echo "<p class ='error-message'>$error_message</p>"; ?>
            <?php if (!empty($success_message)) echo "<p class ='success-message'>$success_message</p>"; ?>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        var modal = document.getElementById("myModal");
        var closeBtn = document.getElementsByClassName("close")[0];

        <?php
            if(!isset($_GET['need'])) {
        ?>

        window.onload = function () {
            modal.style.display = "block";
        }

        <?php
            }
        ?>

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