<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$database = "mdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $query = "SELECT hallticket FROM students WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $rno = $row["hallticket"];

        $sql = "SELECT points FROM submitassi WHERE rno='$rno'";
        $result = $conn->query($sql);

        $dataPoints = [];
        while ($row = $result->fetch_assoc()) {
            $points = $row["points"];
            $dataPoints[] = $points;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Performance Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f6f8;
            padding: 20px;
        }
        h1 {
            margin: 0;
        }
        header {
            background-color: #419c49;
            color: #e3e7f0;
            padding: 10px;
            margin-bottom: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
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
        #pointsChart,
        #performanceChart {
            width: 200%;
            max-width: 400%;
            max-height: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo isset($_POST["rno"]) ? $_POST["rno"] : "PERFORMANCE"; ?> ASSAIGNMENT PERFORMANCE</h1>
            <a href="stuper.html" class="home-link">Back</a>
        </div>
    </header>
    <div class="container">
        <canvas id="pointsChart"></canvas>
        <canvas id="performanceChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('pointsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Assignment 1', 'Assignment 2', 'Assignment 3', 'Assignment 4', 'Assignment 5'],
                datasets: [{
                    label: 'Points',
                    data: <?php echo json_encode($dataPoints); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });

        var points = <?php echo $dataPoints ? json_encode($dataPoints) : '[]'; ?>;
        var canvas = document.getElementById("performanceChart");
    </script>
</body>
</html>
