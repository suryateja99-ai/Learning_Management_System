<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $_GET["email"];
$stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
if (!$stmt) {
    printf("Error: %s\n", $conn->error);
    exit();
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$result) {
    printf("Error: %s\n", $conn->error);
    exit();
}
$row = $result->fetch_assoc();

if ($row) {
    echo "email:" . $row["email"] . "<br>";
    echo "first name:" . $row["fname"] . "<br>";
    echo "hallticket:" . $row["hallticket"] . "<br>";
    echo "date of birth:" . $row["dob"] . "<br>";
    echo "gender:" . $row["gender"] . "<br>";
    echo "address:" . $row["ad1"] . "<br>";
    echo "year:" . $row["yr"] . "<br>";
    echo "branch:" . $row["br"] . "<br>";
    echo "mobile:" . $row["phno"] . "<br>";
} else {
    echo "No results found.";
}
?>
