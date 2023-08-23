<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["pas"]) && isset($_POST["dob"]) && isset($_POST["phone"]) && isset($_POST["ad"]) && isset($_POST["Gender"]) && isset($_POST["Year"]) && isset($_POST["branch"])) {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $pas = $_POST["pas"];
        $dob = $_POST["dob"];
        $phone = $_POST["phone"];
        $ad = $_POST["ad"];
        $gender = $_POST["Gender"];
        $year = $_POST["Year"];
        $branch = $_POST["branch"];
        $uid = $_POST["uid"];
        $hallticket = $_POST["htno"];

        $servername = "localhost";
        $username = "root";
        $password = "sunsun55";
        $dbname = "mdb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $duplicateStmt = $conn->prepare("SELECT * FROM students WHERE hallticket = ?");
        $duplicateStmt->bind_param("s", $hallticket);
        $duplicateStmt->execute();
        $duplicateResult = $duplicateStmt->get_result();
        if ($duplicateResult->num_rows > 0) {
            echo "Error: Student with the given hall ticket number already exists.";
            exit;
        }
        $duplicateStmt->close();

        $stmt = $conn->prepare("INSERT INTO students (fname, lname, hallticket, email, pas, dob, gender, ad1, yr, br, phno, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $fname, $lname, $hallticket, $email, $pas, $dob, $gender, $ad, $year, $branch, $phone, $uid);

        if ($stmt->execute()) {
            echo "Student added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    
}
?>
