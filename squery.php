<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    $quer = $_POST["quer"];
    $sub = $_POST["sub"];
    $rno = null;
    $name = null;

    session_start();
    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = "SELECT hallticket, fname FROM students WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $rno = $row["hallticket"];
            $name = $row["fname"];
        }
    }

    if (!$rno) {
        echo "Failed to retrieve rno.";
        exit();
    }

    $query = "SELECT * FROM queries WHERE doubts='$quer'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "No need to write the same doubt again! Your faculty will solve your doubt and will post back soon. Keep checking your inbox.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO queries (doubts, sub, rno, name) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $quer, $sub, $rno, $name);

    if ($stmt->execute()) {
        echo "Your query was sent successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Redirect to stuhome.php after 2 seconds
    header("refresh:2; url=stuhome.php");
}

// Close the database connection
$conn->close();
?>
