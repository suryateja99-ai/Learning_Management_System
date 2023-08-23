<?php
$host = 'localhost';
$username = 'root';
$password = 'sunsun55';
$database = 'mdb';

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die('Database connection failed: ' . mysqli_connect_error());
}

$attendanceData = $_POST['attendance'];

$attendance = array();

foreach ($attendanceData as $hallticket => $status) {
    $attendance[$hallticket] = ($status == 'present') ? 'Present' : 'Absent';
}

$report = "Attendance Report\n\n";
foreach ($attendance as $hallticket => $status) {
    $query = "SELECT fname FROM students WHERE hallticket = '$hallticket'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $name = $row['fname'];

    $report .= "Name: $name\n";
    $report .= "Hallticket: $hallticket\n";
    $report .= "Attendance: $status\n\n";
}

$filename = 'attendance_report.txt';
file_put_contents($filename, $report);

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
</head>
<body>
    <h1>Attendance Report</h1>
    <p>Attendance has been recorded and the report has been generated.</p>
    <p>Click the link below to download the attendance report:</p>
    <a href="<?php echo $filename; ?>" download>Download Attendance Report</a>
</body>
</html>
