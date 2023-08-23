<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$database = "mdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['uname'];
    $password = $_POST['psw'];
    
    $stmt = $conn->prepare("SELECT * FROM `admin login` WHERE AdminName = ? AND AdminPassword = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        header('Location:dashboard.html');
        exit();
    } else {
        $error = 'Invalid username or password';
        echo $error;
    }

    $stmt->close();
    $conn->close();
}