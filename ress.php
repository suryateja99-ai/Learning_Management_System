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

    $query = "SELECT points, sname FROM submitassi WHERE rno='$rno'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<h1 class='header'>Assignment Points</h1>";
            echo "<a href='stuhome.php' class='home-link'>Home</a><br><br>";
            echo "<table>";
            echo "<tr><th>Assignment Points</th><th>Subject Name</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['points'] . "</td>";
                echo "<td>" . $row['sname'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No assignment points found.";
        }
    } else {
        echo "Error retrieving assignment points: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
    
    .header {
        margin: 0;
        padding: 20px;
        background-color: #419c49;
        color: #e3e7f0;
        text-align: center;
    }
    
    .home-link {
        color: #1c1e1f;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease-in-out;
    }
    
    .home-link:hover {
        color: #f5f3f3;
    }
</style>
