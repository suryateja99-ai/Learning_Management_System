<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function calculateAttendancePercentage($hallticket) {
    global $conn;

    $query = "SELECT COUNT(*) as total, SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) as present FROM attendance WHERE hallticket='$hallticket'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];
        $present = $row['present'];

        if ($total > 0) {
            $percentage = ($present / $total) * 100;
            return round($percentage, 2);
        }
    }

    return 0;
}

// Retrieve attendance data for the student
if (isset($_POST["hallticket"])) {
    $hallticket = $_POST["hallticket"];

    // Calculate overall attendance percentage for the student
    $attendancePercentage = calculateAttendancePercentage($hallticket);

    echo "<h2>Student Attendance</h2>";
    echo "<p>Hall Ticket: $hallticket</p>";
    echo "<p>Overall Attendance Percentage: $attendancePercentage%</p>";

    // Retrieve attendance data for the student
    $query = "SELECT date, status FROM attendance WHERE hallticket='$hallticket' ORDER BY date";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $dates = array();
        $statuses = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $dates[] = $row['date'];
            $statuses[] = $row['status'];
        }

        // Output attendance graph
        echo "<canvas id='attendanceChart'></canvas>";

        $graphData = array(
            'labels' => $dates,
            'datasets' => array(
                array(
                    'label' => 'Attendance',
                    'data' => $statuses,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                )
            )
        );

        // Convert graph data to JSON format
        $graphDataJSON = json_encode($graphData);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Attendance</title>
    <style>
        .container {
            display: flex;
            flex-direction: row;

        }
        .previous-button {
           position: absolute;
           background-color: #4CAF50;
           color: white;
           padding: 10px 20px;
           border: none;
           border-radius: 4px;
           top: 10px;
           right: 10px;
           cursor: pointer;
           font-size: 16px;
       }
    </style>
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            var ctx = document.getElementById('attendanceChart').getContext('2d');
            var attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: <?php echo $graphDataJSON; ?>,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 1,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
</head>
<body>
    <h2>Student Attendance</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="hallticket">Hall Ticket:</label>
        <input type="text" id="hallticket" name="hallticket" required>
        <br><br>
        <input type="submit" name="submit" value="Get Attendance">
    </form>
</body>
<a class="previous-button" href="dashboard.html">&lt; Previous</a><br><br><br>
</html>
