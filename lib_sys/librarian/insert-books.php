<?php
$upload_stat = -1;

if(isset($_GET['submit'])) {
    $db = mysqli_connect("localhost", "root", "", "lib_sys");

    // Check if ISBN already exists in the database
    $isbn = mysqli_real_escape_string($db, $_POST["isbn"]);
    $result = mysqli_query($db, "SELECT COUNT(*) as count FROM books WHERE isbn = '$isbn'");
    $data = mysqli_fetch_assoc($result);
    $count = $data['count'];

    if($count > 0) {
        echo "<script>alert('ISBN already exists!');</script>";
        $upload_stat = 0; // Set upload status to 0 to indicate duplicate ISBN
    } else {
        // Upload book data and image
        if(getimagesize($_FILES["cover"]["tmp_name"])) {
            $dest = "../uploads/".basename($_FILES["cover"]["name"]);
            move_uploaded_file($_FILES["cover"]["tmp_name"], $dest);

            $tag_id = mysqli_real_escape_string($db, $_POST["tag"]);
            $title = mysqli_real_escape_string($db, $_POST["title"]);
            $author_id = mysqli_real_escape_string($db, $_POST["author"]);
            $publisher_id = mysqli_real_escape_string($db, $_POST["publisher"]);
            $qty = mysqli_real_escape_string($db, $_POST["qty"]);

            if(mysqli_query($db, "INSERT INTO books (image, isbn, tag_id, book_title, author_id, publisher_id, qty) VALUES(\"".$dest."\", \"".$isbn."\", ".$tag_id.", \"".$title."\", ".$author_id.", ".$publisher_id.", ".$qty.")")) {
                $upload_stat = 1;
                echo "<script>alert('Book saved successfully!');</script>";
            } else {
                $upload_stat = 0;
            }
        }
        else {
            $upload_stat = 0;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Books</title>
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
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: red; color: white; border-radius: 6px">There is an error on adding the book.</div>';
        else if($upload_stat == 1)
            echo '<div style="padding: 12px; margin-bottom: 14px; background-color: green; color: white; border-radius: 6px">Successfully added!</div>';
    ?>

    <div class="title">
        Add Book
        <hr/>
    </div>
    <br/>

    <form class="pure-g" action="insert-books.php?submit" method="post" enctype="multipart/form-data">
        <div class="pure-u-1-5">
            <img width="230" height="270" id="preview" style="background-color: #ccc;" />

            <br/><br/>
            <input type="file" name="cover" id="cover" onchange="previewImage()" style="border: 1px solid black; padding: 5px; width: 235px" required />
        </div>

        <div class="pure-u-4-5" style="padding-left: 50px">
            <div style="display: flex;">
                <div style="display: flex; width: 47%">
                    <p style="margin-top: 12px !important"><label for="isbn">ISBN</label></p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input style="display: inline" type="text" name="isbn" id="isbn" placeholder="Book ISBN" required />
                </div>
                

                <div style="display: flex; width: 55%">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p style="margin-top: 12px !important"><label for="tag">Tag</label></p>
                    <select name="tag" style="border-color: #ccc; border-radius: 4px; width:70%; padding-left: 5px" required>
                        <?php 
                            $db = mysqli_connect("localhost", "root", "", "lib_sys");

                            $result = mysqli_query($db, "SELECT * FROM tag");
                            if ($result && mysqli_num_rows($result) > 0)
                                while ($row = mysqli_fetch_array($result))
                                    echo "<option value=\"" . $row["id"] . "\">" . $row["tag_name"] . "</option>";
                            ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important; display: block;"><label for="title">Book Title</label></p>
                    <input style="display: inline; width: 70%" type="text" name="title" id="title" placeholder="Book Title" required />
                </div>

                <div style="display: flex; width: 50%">
                &nbsp;&nbsp;&nbsp;&nbsp;<p style="margin-top: 12px !important; display: block;"><label for="qty">Quantity</label></p>
                    <input style="display: inline; width: 100%" type="number" name="qty" id="qty" placeholder="Book Quantity" required />
                </div>
            </div>
            <br/>

            <div style="display: flex;">
                <div style="display: flex; width: 50%">
                    <p style="margin-top: 12px !important"><label for="author">Author</label></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="author" style="border-color: #ccc; border-radius: 4px; width: 70%; padding-left: 5px" required>
                        <?php
                            $res = mysqli_query($db, "SELECT * FROM author");

                            if ($res && mysqli_num_rows($res) > 0)
                                while ($row = mysqli_fetch_array($res))
                                    echo "<option value=\"" . $row["id"] . "\">" . $row["author_name"] . "</option>";
                        ?>
                    </select>
                </div>

                <div style="display: flex; width: 50%; padding-left: 12px !important">
                    <p style="margin-top: 12px !important"><label for="publisher">Publisher</label></p>
                    <select name="publisher" style="border-color: #ccc; border-radius: 4px; width: 80%; padding-left: 5px" required>
                        <?php
                            $res = mysqli_query($db, "SELECT * FROM publisher");

                            if ($res && mysqli_num_rows($res) > 0)
                                while ($row = mysqli_fetch_array($res))
                                    echo "<option value=\"" . $row["id"] . "\">" . $row["publisher_name"] . "</option>";
                        ?>
                    </select>
                </div>
            </div>
            <br/>

            <div style="float: right; display: flex">
                <button type="submit" class="add-btn" style="margin-right: 6px"><i class='bx bx-plus-circle'></i> Add Book</button>
                <button class="bx bx-trash" style="border: none; content: ''" onclick="void(0)" style="margin-right: 20px"><a href="insert-books.php" style="color: white; text-decoration: none"> Clear Form</a></button>
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
<script src="../js/bookname-validation.js"></script>
</body>
</html>