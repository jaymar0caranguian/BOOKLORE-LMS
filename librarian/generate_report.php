<?php
require('fpdf.php');

$category = $_POST['category'];
$start_date = $_POST['start-date'];
$end_date = $_POST['end-date'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";

$connection = mysqli_connect($servername, $username, $password, $dbname);

if ($category == 'late_returns') {
    $query = "SELECT user_id, book_code, issue_date, return_date, actual_return_date 
              FROM tbl_issued 
              WHERE actual_return_date > return_date 
                  AND issue_date BETWEEN '$start_date' AND '$end_date'";
} else if ($category == 'fine') {
    $query = "SELECT * FROM tbl_issued WHERE fine > 0 AND issue_date BETWEEN '$start_date' AND '$end_date'";
}

$result = mysqli_query($connection, $query);

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Booklore System Report','B',1,'C');

$pdf->SetFont('Arial','B',12);
if ($category == 'late_returns') {
    $pdf->Cell(0,10,'Late Returns Report','B',1,'C');
} else if ($category == 'fine') {
    $pdf->Cell(0,10,'Fine Report','B',1,'C');
}

if(mysqli_num_rows($result) == 0){
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,'No results found for the given date range.','B',1,'C');
} else {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(25,10,'User ID',1,0,'C');
    $pdf->Cell(25,10,'Book Code',1,0,'C');
    $pdf->Cell(35,10,'Issue Date',1,0,'C');
    $pdf->Cell(35,10,'Return Date',1,0,'C');
    $pdf->Cell(45,10,'Actual Return Date',1,0,'C');
    if ($category == 'fine') {
        $pdf->Cell(25,10,'Fine',1,1,'C');
    } else {
        $pdf->Cell(0,10,'',0,1); // Empty cell for formatting purposes
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,10,$row['user_id'],1,0,'C');
        $pdf->Cell(25,10,$row['book_code'],1,0,'C');
        $pdf->Cell(35,10,$row['issue_date'],1,0,'C');
        $pdf->Cell(35,10,$row['return_date'],1,0,'C');
        $pdf->Cell(45,10,$row['actual_return_date'],1,0,'C');
        if ($category == 'fine') {
            $pdf->Cell(25,10,$row['fine'],1,1,'C');
        } else {
            $pdf->Cell(0,10,'',0,1); // Empty cell for formatting purposes
        }
    }
}

mysqli_close($connection);

$pdf->Output();
