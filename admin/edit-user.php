<?php
    $edit_stat = -1;
    $db = mysqli_connect("localhost", "root", "", "lib_sys");

    if(isset($_GET['submit'])) {
        if(($_FILES['dp']['name'] == "" || ($_FILES['dp']['size'] == 0 && $_FILES['dp']['error'] == 0)) && mysqli_query($db, "UPDATE tbl_user SET full_name = \"".$_POST["fullname"]."\", email = \"".$_POST["email"]."\", ".(isset($_POST['pword']) && $_POST['pword'] != "" ? "password = \"".sha1($_POST['pword'])."\", " : "")."year_id = ".$_POST["year"].", roles=\"".$_POST["roles"]."\", addresss=\"".$_POST["addresss"]."\", course_id=".$_POST['course']." WHERE id=".$_GET['id'].";"))
            $edit_stat = 1;
        else if(getimagesize($_FILES["dp"]["tmp_name"])) {
            $dest = "../uploads/".basename($_FILES["dp"]["name"]);
            move_uploaded_file($_FILES["dp"]["tmp_name"], $dest);

            if(mysqli_query($db, "UPDATE tbl_user SET u_img = \"".$dest."\", full_name = \"".$_POST["fullname"]."\", email = \"".$_POST["email"]."\", ".(isset($_POST['pword']) && $_POST['pword'] != "" ? "password = \"".sha1($_POST['pword'])."\", " : "")."year_id = ".$_POST["year"].", roles=\"".$_POST["roles"]."\", addresss=\"".$_POST["addressss"]."\" WHERE id=".$_GET['id'].";"))
                $edit_stat = 1;
            else $edit_stat = 0;
        }
        else $edit_stat = 0;

        if($edit_stat == 1)
            echo '<script>window.location.href="manage-user.php?edited";</script>';
    }

    if(!isset($_GET['id']))
        echo "<script>window.location.href='manage-user.php';</script>";

    $res = mysqli_fetch_row(mysqli_query($db, "SELECT u_img, full_name, email, roles, year_id, addresss, course_id FROM tbl_user WHERE id=".$_GET["id"]));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/course-year.css">
    <style>
    input[type="password"], input[type="number"] {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
        width: 100% !important;
    }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <span id="notification" style="color: red; margin-left: 400px;"></span>
    <div class="course-management">
    <?php
        if($edit_stat == 0)
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: red; color: white; border-radius: 6px">Only jpeg, jpg, and png are allowed.</div>';
    ?>

    <div class="title">
        Edit User
        <hr/>
    </div>
    <br/>

    <form class="pure-g" action="edit-user.php?submit&id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
        <div class="pure-u-1-5" align="center">
            <img width="200" height="200" id="preview" style="background-color: #ccc;" src="<?php echo $res[0]; ?>" />

            <br/><br/>
            <input type="file" name="dp" id="dp" onchange="previewImage()" style="border: 1px solid black; padding: 5px; width: 200px" />
        </div>

        <div class="pure-u-4-5">
            <div style="display: flex">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; display: block;"><label for="fullname">Fullname</label></p>
                    <input style="display: inline; width: 90%" type="text" name="fullname" id="fullname" value="<?php echo $res[1]; ?>" placeholder="Fullname" required />
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; display: block;"><label for="uid">Course</label></p>
                    <select name="course" style="padding: 8px; border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <?php
                            $cres = mysqli_query($db, "SELECT * FROM tbl_course");

                            if ($cres && mysqli_num_rows($cres) > 0)
                                while ($crow = mysqli_fetch_array($cres))
                                    echo "<option value=\"".$crow["id"]."\" ".($crow["id"] == $res[6] ? "selected" : "").">".$crow["coursename"]."</option>";
                        ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="email">Email</label></p>
                    <input style="display: inline" type="text" name="email" id="email" value="<?php echo $res[2]; ?>" placeholder="Email" required />
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="pword">Password</label></p>
                    <input style="display: inline" type="password" style="padding: 10px; border-radius: 5px !important; border: 1px solid #ccc !important; margin-right: 10px !important; width: 100% !important;" name="pword" id="pword" placeholder="Password" />
                </div>
            </div>
            <br/>

            <div style="display: flex;">
            <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="roles">Role</label></p>
                    <select name="roles" style="padding: 8px; border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <option value="student" <?php echo $res[3] == "student" ? "selected='selected'" : ""; ?>>Student</option>
                        <option value="librarian" <?php echo $res[3] == "librarian" ? "selected='selected'" : ""; ?>>Librarian</option>
                        <option value="faculty" <?php echo $res[3] == "faculty" ? "selected='selected'" : ""; ?>>Faculty</option>
                        <option value="super admin" <?php echo $res[3] == "super admin" ? "selected='selected'" : ""; ?>>Super Admin</option>
                    </select>
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; margin-left: 8px"><label for="year">Year</label></p>
                    <select name="year" style="padding: 8px; border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <?php
                            $rs = mysqli_query($db, "SELECT * FROM tbl_years");

                            if ($rs && mysqli_num_rows($rs) > 0)
                                while ($row = mysqli_fetch_array($rs))
                                    echo "<option value=\"" . $row["id"] . "\" ".($row["id"] == $res[4] ? 'selected="selected"' : "").">" . $row["yearsname"] . "</option>";
                        ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <p style="margin-top: 12px !important"><label for="addresss">Address</label></p>
                <input style="display: inline" type="text" name="addresss" id="addresss" value="<?php echo $res[5]; ?>" placeholder="Address" required />
            </div>
            <br/>

            <div style="float: right; display: flex">
                <button type="submit" class="add-btn" style="margin-right: 6px"><i class='bx bxs-save'></i> Edit User</button>
                <a href="manage-user.php" class="submit-btn" style="background-color: green; text-decoration: none">Back to list</a>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage() {
        let reader = new FileReader();

        reader.readAsDataURL(document.getElementById("dp").files[0]);
        reader.onload = (evt)=> {
            document.getElementById("preview").src = evt.target.result;
        }
    };
</script>
<script src="../js/name-validation.js"></script>
<script src="../js/address-validation.js"></script>
<script src="../js/email-validation.js"></script>
<script src="../js/password-validation.js"></script>
</body>
</html>