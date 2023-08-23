<?php
// MySQL database credentials
$db_host = 'localhost';
$db_name = 'mdb';
$db_user = 'root';
$db_pass = 'sunsun55';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["submit"])) {
    if(isset($_POST["sname"]) && !empty($_POST["sname"]) && isset($_FILES["video"]) && !empty($_FILES["video"])) {
        $sname = $_POST["sname"];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["video"]["name"]);
        $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file is a video
        if($videoFileType != "mp4" && $videoFileType != "avi" && $videoFileType != "mov") {
            echo "Sorry, only MP4, AVI, and MOV files are allowed.";
            exit;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            exit;
        }

        // Check if file was uploaded successfully
        if ($_FILES["video"]["error"] !== UPLOAD_ERR_OK) {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }

        // Upload the file to the server
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["video"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }

        $file_path = mysqli_real_escape_string($conn, $target_file);
        $sql = "INSERT INTO classes (sname, filep) VALUES ('$sname', '$file_path')";

        if (mysqli_query($conn, $sql)) {
            echo "File path saved to database successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Please enter a name and select a file to upload.";
    }
}

mysqli_close($conn);
?>
