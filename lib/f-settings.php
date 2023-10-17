<?php
    session_start();

    if(!isset($_SESSION['urole']))
        header('Location: ../login.php?need');

    $edit_stat = -1;
    $db = mysqli_connect("localhost", "root", "", "lib_sys");

    if(isset($_GET['edit'])) {
        if(($_FILES['dp']['name'] == "" || ($_FILES['dp']['size'] == 0 && $_FILES['dp']['error'] == 0)) && mysqli_query($db, "UPDATE tbl_user SET full_name = \"".$_POST["fullname"]."\", email = \"".$_POST["email"]."\", ".((isset($_POST['pword']) && $_POST['pword'] != "") ? "password = \"".sha1($_POST['pword'])."\", " : "")."phone = \"".$_POST['phone']."\", addresss = \"".$_POST['addr']."\" WHERE id=".$_SESSION['uid']))
            $edit_stat = 1;
        else if(getimagesize($_FILES["dp"]["tmp_name"])) {
            $dest = "../uploads/".basename($_FILES["dp"]["name"]);
            move_uploaded_file($_FILES["dp"]["tmp_name"], $dest);

            if(mysqli_query($db, "UPDATE tbl_user SET u_img = \"".$dest."\", full_name = \"".$_POST["fullname"]."\", email = \"".$_POST["email"]."\", ".((isset($_POST['pword']) && $_POST['pword'] != "") ? "password = \"".sha1($_POST['pword'])."\", " : "")."phone = \"".$_POST['phone']."\", addresss = \"".$_POST['addr']."\" WHERE id=".$_SESSION['uid']))
                $edit_stat = 1;
            else $edit_stat = 0;
        }
        else $edit_stat = 0;
    }

    $row = mysqli_fetch_assoc(mysqli_query($db, "SELECT u_img, full_name, email, roles, year_id, addresss, phone FROM tbl_user WHERE id=".$_SESSION['uid']));
    $_SESSION['uimg'] = $row['u_img'];
    $_SESSION['uname'] = $row['full_name'];
    $_SESSION['uaddr'] = $row['addresss'];
    $_SESSION['uemail'] = $row['email'];
    $_SESSION['uphone'] = $row['phone'];
    $_SESSION['urole'] = $row['roles'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/course-year.css">
<style>
    body {
        background: #E4E9F7;
    }
</style>
</head>
<body>
    <?php include 'f-sidebar.php'; ?>
    <h1 style="margin-left: 64px; margin-top: 0 !important">My Profile</h1>

<div class="pure-g">
    <div class="pure-u-2-5">
        <div class="course-management" style="margin-top: 0 !important; margin-right: 20px !important">
            <center>
                <img src="<?php echo $_SESSION['uimg']; ?>" id="preview" width="100" height="100" />
                <h3><?php echo $_SESSION['uname']; ?></h3>
                <small style="padding: 4px !important; display: inline-block; margin-top: 9px !important; background-color: gray; color: white; border-radius: 12px; width: auto !important;"><?php echo $_SESSION['urole']; ?></small>
            </center>

            <br/>
        </div>
    </div>

    <form action="f-settings.php?edit" method="post" class="pure-u-3-5" enctype="multipart/form-data">
        <div class="course-management" style="margin-top: 0 !important; margin-left: 0 !important">
            <?php
                if($edit_stat == 0)
                    echo '<div style="padding: 12px; margin-bottom: 14px; background-color: red; color: white; border-radius: 6px">Something went wrong while adding user to the database.</div>';
                else if($edit_stat == 1)
                    echo '<div style="padding: 12px; margin-bottom: 14px; background-color: green; color: white; border-radius: 6px">Successfully edited!</div>';
            ?>

            <div class="title">My details</div>
            <hr/><br/>

            <div class="pure-g">
                <div class="pure-u-1-5"><label for="dp" style="display: inline-block; margin-top: 10px !important;">Profile Picture</label></div>
                <div class="pure-u-4-5"><input style="display: inline-block; width: 100%" onchange="previewImage()" type="file" name="dp" id="dp" /></div>
            </div>
            <br/>

            <div class="pure-g">
                <div class="pure-u-1-5"><label for="fullname" style="display: inline-block; margin-top: 10px !important;">Fullname</label></div>
                <div class="pure-u-4-5"><input style="display: inline-block; width: 100%" type="text" name="fullname" id="fullname" value="<?php echo $_SESSION['uname']; ?>" readonly placeholder="Fullname" /></div>
            </div>
            <br/>

            <div class="pure-g">
                <div class="pure-u-1-5"><label for="email" style="display: inline-block; margin-top: 10px !important;">Email</label></div>
                <div class="pure-u-4-5"><input style="display: inline-block; width: 100%" type="email" name="email" id="email" value="<?php echo $_SESSION['uemail']; ?>" readonly placeholder="Email" /></div>
            </div>
            <br/>

            <div class="pure-g">
                <div class="pure-u-1-5"><label for="pword" style="display: inline-block; margin-top: 10px !important;">Password</label></div>
                <div class="pure-u-4-5"><input style="display: inline-block; width: 100%" type="password" name="pword" id="pword" placeholder="Password" /></div>
                <span id="notification" style="color: red; margin-left: 400px;"></span>
            </div>
            <br/>

            <div class="pure-g">
                <div class="pure-u-1-5"><label for="phone" style="display: inline-block; margin-top: 10px !important;">Phone No.</label></div>
                <div class="pure-u-4-5"><input style="display: inline-block; width: 100%" type="number" name="phone" id="phone" value="<?php echo $_SESSION['uphone']; ?>" placeholder="Phone No." /></div>
                <span id="notification" style="color: red; margin-left: 400px;"></span>
            </div>
            <br/>

            <div class="pure-g">
                <div class="pure-u-1-5"><label for="addresss" style="display: inline-block; margin-top: 10px !important;">Address</label></div>
                <div class="pure-u-4-5"><input style="display: inline-block; width: 100%" type="text" name="addr" id="addr" value="<?php echo $_SESSION['uaddr']; ?>" readonly placeholder="Address" /></div>
            </div>
            <br/>

            <button type="submit" class="add-btn" style="margin-right: 6px; display: block"><i class='bx bx-edit-alt'></i> Save</button>
            <br/><br/>
        </div>
    </form>
</div>
<br/><br/><br/>

<script>
    function previewImage() {
        let reader = new FileReader();

        reader.readAsDataURL(document.getElementById("dp").files[0]);
        reader.onload = (evt)=> {
            document.getElementById("preview").src = evt.target.result;
        }
    };
</script>
<script src="../js/phone-validation.js"></script>
<script src="../js/password-validation.js"></script>
</body>
</html>