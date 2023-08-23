<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $requiredFields = array("fname", "lname", "email", "pas", "Gender", "ad1", "sub", "phno");
    $isValidData = true;

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            echo "Error: Missing or empty field: " . $field;
            $isValidData = false;
            break;
        }
    }

    if ($isValidData) {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $pas = $_POST["pas"];
        $gender = $_POST["Gender"];
        $address = $_POST["ad1"];
        $subject = $_POST["sub"];
        $mobile = $_POST["phno"];

        $servername = "localhost";
        $username = "root";
        $password = "sunsun55";
        $dbname = "mdb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $duplicateStmt = $conn->prepare("SELECT * FROM teachers WHERE fname = ?");
        $duplicateStmt->bind_param("s", $fname);
        $duplicateStmt->execute();
        $duplicateResult = $duplicateStmt->get_result();
        if ($duplicateResult->num_rows > 0) {
            echo "Error: Instructor with the given name already exists.";
            exit;
        }
        $duplicateStmt->close();

        $stmt = $conn->prepare("INSERT INTO teachers (fname, lname, email, pas, gender, ad1, sub, phno) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $fname, $lname, $email, $pas, $gender, $address, $subject, $mobile);

        if ($stmt->execute()) {
            echo "Instructor added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    
} else {
    echo "Error: This script should be accessed via a POST request.";
}
?>
