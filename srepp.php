<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

// Enable error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    session_start();
    $email = $_SESSION["email"] ?? '';

    
    $query = "SELECT hallticket FROM students WHERE email='$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $rno = $row["hallticket"];

        
        $stmt = $conn->prepare("SELECT sol FROM reply WHERE rno=?");
        if ($stmt) {
            $stmt->bind_param("s", $rno);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<h2>Solution to your Query:</h2>";
                        echo "<p>" . $row["sol"] . "</p>";

                        // Delete the record from the database
                        $deleteSql = "DELETE FROM reply WHERE rno=?";
                        $deleteStmt = $conn->prepare($deleteSql);
                        if ($deleteStmt) {
                            $deleteStmt->bind_param("s", $rno);
                            $deleteStmt->execute();
                            $deleteStmt->close();
                        } else {
                            echo "Error in preparing delete statement: " . $conn->error;
                        }
                    }
                } else {
                    echo "No results found.";
                }
            } else {
                echo "Error executing query: " . $conn->error;
            }

            $result->close();
            // Close the statement
            $stmt->close();
        } else {
            echo "Error in preparing select statement: " . $conn->error;
        }
    } else {
        echo "Failed to retrieve rno.";
        exit();
    }
}

// Close the database connection
$conn->close();
?>
