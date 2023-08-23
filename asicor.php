<!DOCTYPE html>
<html>
<head>
    <title>Document Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        .submission {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .submission-info {
            margin-bottom: 10px;
        }

        .submission-info span {
            font-weight: bold;
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

        .download-link {
            display: block;
            margin-top: 10px;
        }

        .points-form {
            margin-top: 10px;
        }

        .points-form input[type="number"] {
            width: 50px;
            padding: 5px;
        }

        .points-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .no-documents {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
 <a class="previous-button" href="assicorr.html">&lt; Previous</a><br><br><br>
    <h2>Document Submission</h2>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "sunsun55";
    $dbname = "mdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sub = $_POST['sub'];
    $sql = "SELECT * FROM submitassi WHERE sname = '$sub'";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $documentData = $row["filecontent"];
            $filename = $row["fileName"];
            $rno = $row["rno"];

            echo '<div class="submission">';
            echo '<div class="submission-info">';
            echo '<span>ROLLNO:</span> ' . $rno . '<br>';
            echo '<span>SUBJECT:</span> ' . $row["sname"] . '<br>';
            echo '<span>FILE:</span> ' . $row["fileName"] . '<br>';
            echo '</div>';

            // Add an input field for points
            echo '<form class="points-form" method="post" action="update_points.php">';
            echo '<input type="hidden" name="rno" value="' . $rno . '">';
            echo '<input type="hidden" name="sub" value="' . $sub . '">';
            echo '<span>Points:</span> <input type="number" name="points" min="0" max="5" required><br>';
            echo '<input type="submit" value="Submit Points">';
            echo '</form>';

            echo '<a class="download-link" href="data:application/octet-stream;base64,' . base64_encode($documentData) . '" download="' . $filename . '">Download ' . $filename . '</a>';
            echo '</div>';
        }
    } else {
        echo '<div class="no-documents">No documents found.</div>';
    }

    $conn->close();
    ?>

</body>
</html>
