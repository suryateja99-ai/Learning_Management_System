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
    <a href="teacherp.php"><button>Home</button></a>
    <a href="dashboard.php"><button>Home</button></a>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "sunsun55";
    $dbname = "mdb";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM timetable";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $timetable = array();

        while ($row = $result->fetch_assoc()) {
            $day = $row["day"];
            $period = $row["period"];
            $periodName = $row["period_name"];

            $timetable[$day][$period] = $periodName;
        }

        $heading = $_POST['branch'];
        $headings = $_POST['year'];

        echo "<h1 class='heading'>$heading</h1>";
        echo "<h1 class='heading'>$headings</h1>";

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
