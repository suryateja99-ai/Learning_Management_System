<?php
$assi = $_POST['assi'];
$year = $_POST['year'];
$br = $_POST['br'];
$sub = $_POST['sub'];
$top = $_POST['top'];
$dat = $_POST['dat'];

$con = mysqli_connect('localhost', 'root', 'sunsun55', 'mdb');
if (!$con) {
    echo "Connection failed";
    exit();
}
$currentDate = date("Y-m-d");

$output = "";

$sql = "INSERT INTO assignments (assi, year, br, sub, top, dat) VALUES ('$assi', '$year', '$br', '$sub', '$top', '$dat')";
if (mysqli_query($con, $sql)) {
    $output .= "Assignment assigned. ";
} else {
    $output .= "Error assigning assignment: " . mysqli_error($con) . ". ";
}

$sql = "DELETE FROM assignments WHERE dat < '$currentDate'";
if ($con->query($sql) === true) {
    $output .= ".";
} else {
    $output .= "Error deleting expired assignments: " . mysqli_error($con) . ".";
}

echo $output;
mysqli_close($con);

header("refresh:2; url=teacherp.php");
exit();
?>
