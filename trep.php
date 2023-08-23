<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rno = $_POST["rno"];
    $sol = $_POST["sol"];

    $sol = mysqli_real_escape_string($conn, $sol);

    $sql = "INSERT INTO reply (rno, sol) VALUES ('$rno', '$sol')";

    if (mysqli_query($conn, $sql)) {
        echo "Text uploaded successfully";
    } else {
        echo "Error uploading text: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
