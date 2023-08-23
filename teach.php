<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    $sname = $_POST["sname"];
    $fileName = $_FILES["myfile"]["name"];
    $fileType = $_FILES["myfile"]["type"];
    $fileSize = $_FILES["myfile"]["size"];
    $fileTmpName = $_FILES["myfile"]["tmp_name"];

    $fileContent = file_get_contents($fileTmpName);

    $stmt = $conn->prepare("INSERT INTO pydocuments (sname, filename, filetype, filesize, filecontent) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error: " . $conn->error);
    }
    $stmt->bind_param("ssibs", $sname, $fileName, $fileType, $fileSize, $fileContent);
    if ($stmt->execute()) {
        echo "Notes uploaded successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    
    header("refresh:2; url=teacherp.php");
}

$conn->close();
?>
