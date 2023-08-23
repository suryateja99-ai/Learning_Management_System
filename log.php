<?php
$host = 'localhost';
$dbname = 'mdb';
$username = 'root';
$password = 'sunsun55';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pas = $_POST["pas"];

    $query = "SELECT * FROM cred WHERE email = :email AND pas = :pas";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pas', $pas);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["email"] = $user["email"];
        header("Location: stuhome.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}

$pdo = null;
?>