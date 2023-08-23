<?php
$message = $_POST['message'];

$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$deleteQuery = "DELETE FROM marquee_messages";
$deleteStatement = $pdo->prepare($deleteQuery);
$deleteStatement->execute();

$insertQuery = "INSERT INTO marquee_messages (message) VALUES (:message)";
$insertStatement = $pdo->prepare($insertQuery);
$insertStatement->bindParam(':message', $message);
$insertStatement->execute();

$response = ['success' => true];
echo json_encode($response);
?>
<script>
    setTimeout(function() {
        window.location.href = 'dashboard.html';
    }, 500);
</script>
