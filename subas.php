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
    $sname = $_POST["sname"];
    $rno = null;
    
    session_start();
    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = "SELECT hallticket FROM students WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $rno = $row["hallticket"];
        }
    }

    if (!$rno) {
        echo "Failed to retrieve rno.";
        exit();
    }

    $fileName = $_FILES["myfile"]["name"];
    $fileType = $_FILES["myfile"]["type"];
    $fileSize = $_FILES["myfile"]["size"];
    $fileTmpName = $_FILES["myfile"]["tmp_name"];

    $fileContent = file_get_contents($fileTmpName);

    $query = "SELECT * FROM submitassi WHERE rno='$rno'";
    $result = mysqli_query($conn, $query);


    $stmt = $conn->prepare("INSERT INTO submitassi (sname, filename, filetype, filesize, filecontent, rno, points) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error: " . $conn->error);
    }
    
    $defaultPoints = 0; 
    $stmt->bind_param("sssdisi", $sname, $fileName, $fileType, $fileSize, $fileContent, $rno, $defaultPoints);
    
    if ($stmt->execute()) {
        echo "File uploaded successfully.";
        header("refresh:2;url=stuhome.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
