<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lib_sys";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user data based on input ID
$id = $_GET['id'];
$sql = "SELECT id, u_img, full_name, email, course_id, year_id, roles, addresss, phone FROM tbl_user WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

// Check if user exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
       
    // Generate PDF ID card
    require('fpdf.php');
    
    // Create PDF object
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(90, 8, 'Booklore', 0, 1, 'C');
    $pdf->Ln(10);
    
    // Add border
    $pdf->Rect(10, 10, 90, 125);
    
    // Add user image to PDF
    $pdf->Image($row['u_img'], 25, 25, 60, 60);
    
    // Add user data to PDF
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->SetXY(10, 95);
    $pdf->Cell(90, 8, $row['full_name'], 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(10, 105);
    $pdf->Cell(90, 5, $row['email'], 0, 1, 'C');
    $pdf->SetXY(10, 110);
    $pdf->Cell(90, 5, $row['addresss'], 0, 1, 'C');
    $pdf->SetXY(10, 115);
    $pdf->Cell(90, 5, $row['phone'], 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetXY(10, 125);
    $expiry_date = date('Y-m-d', strtotime('+4 years', time())); // Calculate 4 year expiration date from current time
    $pdf->Cell(90, 5, 'Expires: ' . $expiry_date, 0, 1, 'C');
    
    // Set PDF file name
    $file_name = "ID-".$row['id']."-".$row['full_name'].".pdf";
    
    // Output PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename='.$file_name);
    $pdf->Output('D');
} else {
    // Return error message
    echo "User not found";
}

// Close database connection
mysqli_close($conn);
?>
