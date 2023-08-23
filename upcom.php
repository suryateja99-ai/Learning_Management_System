<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "sunsun55";
$database = "mdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['email'])) {
    $loginEmail = $_SESSION['email'];

    $branchQuery = "SELECT br FROM students WHERE email = '$loginEmail'";
    $resultBranch = $conn->query($branchQuery);

    if ($resultBranch !== false) {
        if ($resultBranch->num_rows > 0) {
            $rowBranch = $resultBranch->fetch_assoc();
            $branch = $rowBranch['br'];

            $secExamQuery = "SELECT * FROM secexam WHERE branch = '$branch'";
            $resultSecExam = $conn->query($secExamQuery);

            if ($resultSecExam !== false) {
                if ($resultSecExam->num_rows > 0) {
                    echo "<!DOCTYPE html>";
                    echo "<html>";
                    echo "<head>";
                    echo "<style>";
                    echo "body {";
                    echo "  font-family: Arial, sans-serif;";
                    echo "  background-color: #f3f6f8;";
                    echo "  padding: 20px;";
                    echo "}";
                    echo "h1 {";
                    echo "  text-align: center;";
                    echo "}";
                    echo "table {";
                    echo "  border-collapse: collapse;";
                    echo "  width: 100%;";
                    echo "}";
                    echo "th, td {";
                    echo "  text-align: left;";
                    echo "  padding: 8px;";
                    echo "}";
                    echo "th {";
                    echo "  background-color: #4CAF50;";
                    echo "  color: white;";
                    echo "}";
                    echo "tr:nth-child(even) {";
                    echo "  background-color: #f2f2f2;";
                    echo "}";
                    echo ".home-link {";
                    echo "  position: absolute;";
                    echo "  top: 10px;";
                    echo "  left: 10px;";
                    echo "  background-color: #4CAF50;";
                    echo "  color: white;";
                    echo "  padding: 10px 20px;";
                    echo "  text-decoration: none;";
                    echo "}";
                    echo "</style>";
                    echo "</head>";
                    echo "<body>";
                    echo "<a class=\"home-link\" href=\"stuhome.php\">Home</a>";
                    echo "<h1>Exam Schedule</h1>";
                    echo "<table>";
                    echo "<tr><th>Subject</th><th>Date</th></tr>";

                    while ($rowSecExam = $resultSecExam->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $rowSecExam["subject"] . "</td>";
                        echo "<td>" . $rowSecExam["date"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                    echo "</body>";
                    echo "</html>";
                } else {
                    echo "No exam schedule found for the branch.";
                }
            } else {
                echo "Error retrieving exam schedule: " . $conn->error;
            }
        } else {
            echo "Branch information not found for the login email.";
        }
    } else {
        echo "Error retrieving branch information: " . $conn->error;
    }
} else {
    echo "Login email not found in session.";
}

$conn->close();
?>
