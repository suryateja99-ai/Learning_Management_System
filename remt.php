<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["fname"])) {
        $fname = $_POST["fname"];

        $servername = "localhost";
        $username = "root";
        $password = "sunsun55";
        $dbname = "mdb";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $stmt = $conn->prepare("DELETE FROM teachers WHERE fname = ?");
        $stmt->bind_param("s", $fname);


        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Instructor removed successfully.";
            } else {
                echo "No Instructor found with the given hall ticket number.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>
