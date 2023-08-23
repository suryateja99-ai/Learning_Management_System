<!DOCTYPE html>
<html>
<head>
    <title>Timetable</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
        }

        .heading {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <a href="stuhome.php"><button>Home</button></a>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "sunsun55";
    $dbname = "mdb";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();
    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        
        // Retrieve the student's branch and year based on login email
        $query = "SELECT br, yr FROM students WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $branch = $row["br"];
            $year = $row["yr"];
        } else {
            echo "Failed to retrieve student's details.";
            exit();
        }
    } else {
        echo "User session not found.";
        exit();
    }

    $sql = "SELECT * FROM timetable WHERE branch='$branch' AND year='$year'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $timetable = array();

        while ($row = $result->fetch_assoc()) {
            $day = $row["day"];
            $period = $row["period"];
            $periodName = $row["period_name"];

            $timetable[$day][$period] = $periodName;
        }

        echo "<h1 class='heading'>$branch</h1>";
        echo "<h1 class='heading'>$year</h1>";

        echo "<table>";
        echo "<tr><th></th>";

        $timings = array_keys(reset($timetable));
        usort($timings, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        $previousTiming = null;
        foreach ($timings as $timing) {
            if ($previousTiming) {
                echo "<th>" . date("h:i a", strtotime($previousTiming)) . " - " . date("h:i a", strtotime($timing)) . "</th>";
            }
            $previousTiming = $timing;
        }

        echo "<th>3:30 pm - 4:10 pm</th>";

        echo "</tr>";

        foreach ($timetable as $day => $periods) {
            echo "<tr>";
            echo "<td>$day</td>";

            foreach ($timings as $timing) {
                if (isset($periods[$timing])) {
                    echo "<td>{$periods[$timing]}</td>";
                } else {
                    echo "<td></td>";
                }
            }

            echo "<td>";
            if (isset($periods["4"])) {
                echo $periods["4"];
            }
            echo "</td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No timetable records found.";
    }

    $conn->close();
    ?>
</body>
</html>
