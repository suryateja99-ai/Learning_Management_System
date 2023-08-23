<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rno = $_POST['rno'];
$sub = $_POST['sub'];
$points = $_POST['points'];

$sql = "UPDATE submitassi SET points = ? WHERE rno = ? AND sname = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $points, $rno, $sub);

if ($stmt->execute()) {
    echo "Points updated successfully.";
} else {
    echo "Error updating points: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
