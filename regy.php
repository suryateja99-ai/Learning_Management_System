<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$database = "mdb";

$conn = new mysqli($servername, $username, $password, $database);

if (isset($_POST['submit'])) {
    $adminName = $_POST['aname'];
    $email = $_POST['email'];
    $password = $_POST['pas'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO `admin login` (AdminName, email, AdminPassword) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $adminName, $email, $password);

    $stmt->execute();

    $stmt->close();
    $conn->close();

    echo "Registration successful!";
}
?>
