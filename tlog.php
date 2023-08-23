<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$pas = $_POST['pas'];

$stmt = $conn->prepare("SELECT * FROM teachers WHERE email=? AND pas=?");
if ($stmt) {
    $stmt->bind_param("ss", $email, $pas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        
        $_SESSION['email'] = $email;

    
        header("Location: teacherp.php");
        exit();
    } else {
        echo "Incorrect username or password";
    }

    $stmt->close();
} else {
    echo "Error in preparing statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
