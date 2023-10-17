<?php
    $upload_stat = -1;
    $db = mysqli_connect("localhost", "root", "", "lib_sys");

    if(isset($_GET['submit'])) {
        if(($_FILES['cover']['name'] == "" || ($_FILES['cover']['size'] == 0 && $_FILES['dp']['error'] == 0)) && mysqli_query($db, "UPDATE books SET isbn =\"".$_POST['isbn']."\", tag_id = \"".$_POST['tag']."\", book_title = \"".$_POST['title']."\", qty = ".$_POST['qty'].", author_id = ".$_POST['author_id'].", publisher_id = ".$_POST['publisher_id']." WHERE id = ".$_GET['id']))
            $edit_stat = 1;
        else if(getimagesize($_FILES["cover"]["tmp_name"])) {
            $dest = "../uploads/".basename($_FILES["cover"]["name"]);
            move_uploaded_file($_FILES["cover"]["tmp_name"], $dest);

            if(mysqli_query($db, "UPDATE books SET image = \"".$dest."\", isbn =\"".$_POST['isbn']."\", tag_id = ".$_POST['tag'].", book_title = \"".$_POST['title']."\", qty = ".$_POST['qty'].", author_id = ".$_POST['author_id'].", publisher_id = ".$_POST['publisher_id']." WHERE id = ".$_GET['id']))
                $upload_stat = 1;
            else $upload_stat = 0;
        }
        else $upload_stat = 0;
    }

    $res = mysqli_fetch_assoc(mysqli_query($db, "SELECT isbn, tag_id, book_title, qty, author_id, publisher_id, image FROM books WHERE id = ".$_GET['id']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/course-year.css">

    <style>
        input[type="number"] {
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
        if($upload_stat == 0)
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: red; color: white; border-radius: 6px">Only jpeg, jpg, and png are allowed.</div>';
        else if($upload_stat == 1)
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: green; color: white; border-radius: 6px">Successfully updated!</div>';
    ?>

    <div class="title">
        Update Book
        <hr/>
    </div>
    <br/>

    <form class="pure-g" action="edit-book.php?submit&id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
        <div class="pure-u-1-5">
            <img width="235" height="300" id="preview" style="background-color: #ccc;" src="<?php echo $res['image']; ?>"/>

            <br/><br/>
            <input type="file" name="cover" id="cover" onchange="previewImage()" style="border: 1px solid black; padding: 5px; width: 235px"/>
        </div>

        <div class="pure-u-4-5" style="padding-left: 50px">
            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="isbn">ISBN</label></p>
                    <input style="display: inline" type="text" name="isbn" id="isbn" placeholder="Book ISBN" value="<?php echo $res['isbn']; ?>" required />
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="tag">Tag</label></p>
                    <select name="tag" style="border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <?php
                            $db = mysqli_connect("localhost", "root", "", "lib_sys");

                            $result = mysqli_query($db, "SELECT * FROM tag");
                            if ($result && mysqli_num_rows($result) > 0)
                                while ($row = mysqli_fetch_array($result))
                                    echo "<option value=\"".$row["id"]."\" ".($row['id'] == $res['tag_id'] ? "selected" : "").">" . $row["tag_name"] . "</option>";
                            ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; display: block;"><label for="title">Book Title</label></p>
                    <input style="display: inline; width: 90%" type="text" name="title" id="title" value="<?php echo $res['book_title']; ?>" placeholder="Book Title" required />
                </div>

                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; display: block;"><label for="qty">Quantity</label></p>
                    <input style="display: inline; width: 90%" type="number" name="qty" id="qty" value="<?php echo $res['qty']; ?>" placeholder="Book Quantity" required />
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="author">Author</label></p>
                    <select name="author_id" style="border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <?php
                            $result = mysqli_query($db, "SELECT * FROM author");

                            if ($result && mysqli_num_rows($result) > 0)
                                while ($row = mysqli_fetch_array($result))
                                    echo "<option value=\"" . $row["id"] . "\" ".($row['id'] == $res['author_id'] ? "selected" : "").">" . $row["author_name"] . "</option>";
                        ?>
                    </select>
                </div>

                <div style="display: flex; width: 50%; padding-left: 12px !important">
                    <p style="margin-top: 12px !important"><label for="publisher">Publisher</label></p>
                    <select name="publisher_id" style="border-color: #ccc; border-radius: 4px; width: 100%; padding-left: 5px" required>
                        <?php
                            $result = mysqli_query($db, "SELECT * FROM publisher");

                            if ($result && mysqli_num_rows($result) > 0)
                                while ($row = mysqli_fetch_array($result))
                                    echo "<option value=\"" . $row["id"] . "\" ".($row['id'] == $res['publisher_id'] ? "selected" : "").">" . $row["publisher_name"] . "</option>";
                        ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="float: right; display: flex">
            <a href="mng-books.php" class="submit-btn" style="background-color: green; text-decoration: none">Back to list</a>
                <button type="submit" class="add-btn" style="margin-right: 6px"><i class='bx bx-plus-circle'></i> Update Book</button>
                <!-- <button class="bx bx-trash" style="border: none; content: ''" onclick="void(0)"><a href="insert-books.php" style="color: white; text-decoration: none"> Clear Form</a></button> -->
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage() {
        let reader = new FileReader();

        reader.readAsDataURL(document.getElementById("cover").files[0]);
        reader.onload = (evt)=> {
            document.getElementById("preview").src = evt.target.result;
        }
    };
</script>

<script src="../js/isbn-validation.js"></script>
<script src="../js/bookname-validation.js"></script></body>
</html>