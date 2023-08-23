<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ph = $_POST["mob"];
    $sub = $_POST["sub"];
    $email = $_POST["email"];
    $name = $_POST["name"];

    function sanitizeInput($input)
    {
        $sanitizedInput = $input;
        return $sanitizedInput;
    }

    function getTeacherDetails($conn, $ph, $email, $sub, $name)
    {
        $ph = sanitizeInput($ph);
        $email = sanitizeInput($email);
        $sub = sanitizeInput($sub);
        $name = sanitizeInput($name);

        $sql = "SELECT * FROM teachers WHERE 1=1";
        if (!empty($ph)) {
            $sql .= " AND phno = '$ph'";
        }
        if (!empty($email)) {
            $sql .= " AND email = '$email'";
        }
        if (!empty($sub)) {
            $sql .= " AND sub = '$sub'";
        }
        if (!empty($name)) {
            $sql .= " AND fname LIKE '%$name%'";
        }

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    $teacherDetails = getTeacherDetails($conn, $ph, $email, $sub, $name);
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Instructor Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .teacher-table {
            margin-top: 20px;
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

        .teacher-row {
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
        }

        .teacher-row label {
            width: 150px;
            font-weight: bold;
        }

        .teacher-row span {
            margin-left: 10px;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <a class="previous-button" href="teachdet.html">&lt; Previous</a><br><br><br>
    <header>Instructor Details</header>
    <?php if (!empty($teacherDetails)) : ?>
        <div class="teacher-table">
            <?php foreach ($teacherDetails as $teacher) : ?>
                <div class="teacher-row">
                    <label>First Name:</label>
                    <span><?php echo $teacher['fname']; ?></span>
                </div>
                <div class="teacher-row">
                    <label>Last Name:</label>
                    <span><?php echo $teacher['lname']; ?></span>
                </div>
                <div class="teacher-row">
                    <label>Email:</label>
                    <span><?php echo $teacher['email']; ?></span>
                </div>
                <div class="teacher-row">
                    <label>Phone:</label>
                    <span><?php echo $teacher['phno']; ?></span>
                </div>
                <div class="teacher-row">
                    <label>Subject:</label>
                    <span><?php echo $teacher['sub']; ?></span>
                </div>
                <div class="teacher-row">
                    <label>Gender:</label>
                    <span><?php echo $teacher['gender']; ?></span>
                </div>
                <div class="teacher-row">
                    <label>Password:</label>
                    <span><?php echo $teacher['pas']; ?></span>
                </div>
                <div class="teacher-row">
                    <label>Address:</label>
                    <span><?php echo $teacher['ad1']; ?></span>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>No instructor details found.</p>
    <?php endif; ?>
    <a href="dashboard.html">Home</a>
</body>

</html>
