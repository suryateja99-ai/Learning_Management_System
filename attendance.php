<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$output = "";

if (isset($_POST["submit"])) {
    $branch = $_POST["branch"];
    $year = $_POST["year"];

    $query = "SELECT hallticket FROM students WHERE br='$branch' AND yr='$year' ORDER BY hallticket ASC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $output .= "<h2>Student Attendance</h2>";
        $output .= "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>";
        $output .= "<input type='hidden' name='branch' value='$branch'>";
        $output .= "<input type='hidden' name='year' value='$year'>";

        $output .= "<table>";
        $output .= "<tr><th>Hallticket</th><th>Attendance</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $hallticket = $row['hallticket'];
            $output .= "<tr>";
            $output .= "<td>$hallticket</td>";
            $output .= "<td>";
            $output .= "<input type='radio' name='attendance[$hallticket]' value='Present' checked> Present";
            $output .= "<input type='radio' name='attendance[$hallticket]' value='Absent'> Absent";
            $output .= "</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";
        $output .= "<br>";
        $output .= "<input type='submit' name='submitAttendance' value='Submit Attendance'>";
        $output .= "</form>";
    } else {
        $output .= "Error retrieving student halltickets: " . mysqli_error($conn);
    }
}

if (isset($_POST["submitAttendance"])) {
    $branch = $_POST["branch"];
    $year = $_POST["year"];
    $attendance = isset($_POST["attendance"]) ? $_POST["attendance"] : array();
    $date = date('Y-m-d');

    if (!empty($attendance)) {
        foreach ($attendance as $hallticket => $status) {
            $escapedHallticket = mysqli_real_escape_string($conn, $hallticket);
            $escapedStatus = mysqli_real_escape_string($conn, $status);
            $insertQuery = "INSERT INTO attendance (hallticket, date, status) VALUES ('$escapedHallticket', '$date', '$escapedStatus')";

            if (mysqli_query($conn, $insertQuery)) {
                echo "";
            } else {
                echo "Error inserting attendance: " . mysqli_error($conn);
            }
        }
    }

    $output .= "Attendance taken successfully.";

    $filename = "attendance_" . date('Y-m-d') . ".txt";
    $fileContent = "Attendance for $branch $year\n\n";
    foreach ($attendance as $hallticket => $status) {
        $fileContent .= "$hallticket - $status\n";
    }
    file_put_contents($filename, $fileContent);

    $output .= "<br>";
    $output .= "<a href='$filename' download>Download Attendance</a>";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

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

        .previous-button {
           position: absolute;
           background-color: #4CAF50;
           color: white;
           padding: 10px 20px;
           border: none;
           border-radius: 4px;
           top: 10px;
           left: 10px;
           cursor: pointer;
           font-size: 16px;
       }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            margin-top: 10px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #333;
            border-radius: 3px;
        }
    </style>
</head>
<body>
 <a class="previous-button" href="stuat.html">&lt; Previous</a><br><br><br>
    <?php echo $output; ?>
</body>
</html>
