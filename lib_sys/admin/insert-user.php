<?php
    $add_stat = -1;
    $db = mysqli_connect("localhost", "root", "", "lib_sys");

    if(isset($_GET['submit'])) {
        if($_FILES['dp']['name'] == "" || ($_FILES['dp']['size'] == 0 && $_FILES['dp']['error'] == 0))
            $add_stat = 2;
        else if(getimagesize($_FILES["dp"]["tmp_name"])) {
            $dest = "../uploads/".basename($_FILES["dp"]["name"]);
            move_uploaded_file($_FILES["dp"]["tmp_name"], $dest);

            if(mysqli_query($db, "INSERT INTO tbl_user (course_id, u_img, full_name, email, password, year_id, roles, addresss) VALUES(".$_POST["course"].", \"".$dest."\", \"".$_POST["fullname"]."\", \"".$_POST["email"]."\", ".("\"".sha1($_POST["pword"])."\", ").$_POST["year"].", \"".$_POST["roles"]."\", \"".$_POST["addresss"]."\")"))
                $add_stat = 1;
            else $add_stat = 0;
        }
        else $add_stat = 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert User</title>
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
        if($add_stat == 0)
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: red; color: white; border-radius: 6px">Only jpeg, jpg, and png are allowed.</div>';
        else if($add_stat == 1)
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: green; color: white; border-radius: 6px">Successfully added!</div>';
        else if($add_stat == 2)
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: red; color: white; border-radius: 6px">No uploaded display picture.</div>';
    ?>

    <div class="title">
        Add User
    </div>
    <hr>
    <br/>

    <form class="pure-g" action="insert-user.php?submit" method="post" enctype="multipart/form-data">
        <div class="pure-u-1-5" align="center">
            <img width="200" height="200" id="preview" style="background-color: #ccc;" />

            <br/><br/>
            <input type="file" name="dp" id="dp" onchange="previewImage()" style="border: 1px solid black; padding: 5px; width: 200px" required />
        </div>

        <div class="pure-u-4-5">
            <div style="display: flex">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; display: block;"><label for="fullname">Fullname</label></p>
                    <input style="display: inline; width: 90%" type="text" name="fullname" id="fullname" placeholder="Fullname" required />
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; display: block;"><label for="uid">Course</label></p>
                    <select name="course" style="padding: 8px; border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <?php
                            $res = mysqli_query($db, "SELECT * FROM tbl_course");

                            if ($res && mysqli_num_rows($res) > 0)
                                while ($row = mysqli_fetch_array($res))
                                    echo "<option value=\"" . $row["id"] . "\">" . $row["coursename"] . "</option>";
                        ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="email">Email</label></p>
                    <input style="display: inline" type="text" name="email" id="email" placeholder="Email" required />
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="pword">Password</label></p>
                    <input style="display: inline" type="password" style="padding: 10px; border-radius: 5px !important; border: 1px solid #ccc !important; margin-right: 10px !important; width: 100% !important;" name="pword" id="pword" placeholder="Password" required />
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="roles">Role</label></p>
                    <select name="roles" style="padding: 8px; border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <option value="student">Student</option>
                        <option value="librarian">Librarian</option> 
                        <option value="faculty">Faculty</option>
                        <option value="super admin">Super Admin</option>
                    </select>
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; margin-left: 8px"><label for="year">Year</label></p>
                    <select name="year" style="padding: 8px; border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <?php
                            $res = mysqli_query($db, "SELECT * FROM tbl_years");

                            if ($res && mysqli_num_rows($res) > 0)
                                while ($row = mysqli_fetch_array($res))
                                    echo "<option value=\"" . $row["id"] . "\">" . $row["yearsname"] . "</option>";
                        ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <p style="margin-top: 12px !important"><label for="addresss">Address</label></p>
                <input style="display: inline" type="text" name="addresss" id="addresss" placeholder="Address" required />
            </div>
            <br/>

            <div style="float: right; display: flex">
                <button type="submit" class="add-btn" style="margin-right: 6px"><i class='bx bxs-save'></i> Add User</button>
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