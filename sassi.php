<?php
$con = mysqli_connect('localhost', 'root', 'sunsun55', 'mdb');
if (!$con) {
    echo "Connection failed";
    exit();
}

if (isset($_POST["submit"])) {
    $year = null;
    $br = null;

    session_start();
    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = "SELECT yr, br FROM students WHERE email='$email'";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $year = $row["yr"];
            $br = $row["br"];
        } else {
            echo "Error retrieving student details.";
            exit();
        }
    } else {
        echo "Session not found.";
        exit();
    }

    $sql = "SELECT assi, sub, top, dat FROM assignments WHERE br='$br' AND year='$year'";
    $result = $con->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<div style='font-family: Arial, sans-serif;'>";
            echo "<h2>Your Assignments</h2>";
            echo "<table style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background-color: #f2f2f2;'>";
            echo "<th style='padding: 10px; border: 1px solid #ddd;'>Assignment</th>";
            echo "<th style='padding: 10px; border: 1px solid #ddd;'>Subject</th>";
            echo "<th style='padding: 10px; border: 1px solid #ddd;'>Topic</th>";
            echo "<th style='padding: 10px; border: 1px solid #ddd;'>Deadline</th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["assi"] . "</td>";
                echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["sub"] . "</td>";
                echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["top"] . "</td>";
                echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["dat"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "No assignments found.";
        }
    } else {
        echo "Error executing query: " . $con->error;
    }

    $con->close();
}
?>
<div style="position: absolute; top: 10px; right: 10px;">
    <a href="stuhome.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; text-decoration: none; font-size: 16px;">Home</a>
</div>

<center>
<button onclick="openNewTab()" style="padding: 10px 20px; background-color: #785be0; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
     Submit Your Assignment by Topic/Subject
</button>
</center>

<script>
function openNewTab() {
    window.open('submitassi.html', '_blank');
}
</script>
