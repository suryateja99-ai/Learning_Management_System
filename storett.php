<?php

$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateTimeSlots($start, $end, $interval, $gapStart, $gapEnd)
{
    $startTime = strtotime($start);
    $endTime = strtotime($end);
    $timeSlots = array();

    while ($startTime <= $endTime) {
        $time = date("H:i", $startTime);
        $timeSlots[] = $time;

        if ($time == $gapStart) {
            $startTime += 10 * 60; 
        }

        $startTime += $interval * 60;

        if ($time == $gapEnd) {
            $startTime += 10 * 60; 
        }
    }

    return $timeSlots;
}

$branch = $_POST['branch'];
$year = $_POST['year'];

$sqlDelete = "DELETE FROM timetable WHERE branch = ? AND year = ?";
$stmtDelete = $conn->prepare($sqlDelete);

if ($stmtDelete) {
    $stmtDelete->bind_param("ss", $branch, $year);
    $stmtDelete->execute();
} else {
    echo "Error deleting existing timetable: " . $conn->error;
    exit();
}

$start = "09:30";
$end = "16:10";
$interval = 50;
$gapStart = "11:10";
$gapEnd = "11:20";

$timeSlots = generateTimeSlots($start, $end, $interval, $gapStart, $gapEnd);

$periodNames = array();

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

foreach ($daysOfWeek as $day) {
    $periodNames[$day] = isset($_POST[$day]) ? $_POST[$day] : array();
}

$sqlInsert = "INSERT INTO timetable (branch, year, day, period, period_name) VALUES (?, ?, ?, ?, ?)";
$stmtInsert = $conn->prepare($sqlInsert);

if ($stmtInsert) {
    foreach ($daysOfWeek as $day) {
        foreach ($timeSlots as $index => $time) {
            $periodName = isset($periodNames[$day][$index]) ? $periodNames[$day][$index] : '';
            $stmtInsert->bind_param("sssss", $branch, $year, $day, $time, $periodName);
            $stmtInsert->execute();
        }
    }

    echo "Timetable created successfully.";

    header("refresh:3;url=dashboard.html");
    exit();
} else {
    echo "Error creating timetable: " . $conn->error;
}

$stmtInsert->close();
$conn->close();
?>
