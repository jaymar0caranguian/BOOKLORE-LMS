<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reports</title>
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/reports.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <!-- Start here -->
    <div class="course-management">
    <div class="title">Manage Reports</div>

    <div class="line"></div>

    <form method="post" action="generate_report.php" target="_blank">
        <div class="dropdown">
            <select name="category" id="category" required>
                <option value="late_returns">Late Returns</option>
                <option value="fine">Fines</option>
            </select>
        </div>

        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" name="start-date" required>

        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" name="end-date" required>

        <button type="submit"><i class='bx bx-save'></i>Create Report</button>
    </form>
    </div>

    <script>
    function generatePDF() {
        window.location.href = 'generate_pdf.php?category=' + document.getElementById('category').value + '&start_date=' + document.getElementById('start-date').value + '&end_date=' + document.getElementById('end-date').value;
    }
    </script>
</body>
</html>
