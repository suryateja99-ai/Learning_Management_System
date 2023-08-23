<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sub = $_POST["sub"];
$sql = "SELECT doubts, rno FROM queries WHERE sub='$sub'";
$result = $conn->query($sql);

echo '<div class="container">';
echo '<a class="home-link" href="teacherp.php">Home</a>'; // Home button

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="doubt">';
        echo "<strong>Doubts:</strong> " . $row["doubts"]. "<br>";
        echo "<strong>Roll Number:</strong> " . $row["rno"]. "<br>";
        echo '</div>';
        
        // Delete the record from the database
        $rno = $row["rno"];
        $deleteSql = "DELETE FROM queries WHERE rno='$rno' AND sub='$sub'";
        $conn->query($deleteSql);
    }
} else {
    echo "0 results";
}
echo '</div>';

$conn->close();
?>

<div class="button-container">
    <button onclick="openNewTab()">Reply to students by Rollno</button>
</div>

<script>
function openNewTab() {
  window.open('treply.html', '_blank');
}
</script>

<style>
.container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 5px;
}

.doubt {
    background-color: #f2f2f2;
    padding: 10px;
    margin-bottom: 10px;
}

.doubt strong {
    font-weight: bold;
}

.button-container {
    margin-top: 20px;
    text-align: center;
}

button {
    background-color: #4CAF50;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

.home-link {
    color: #000000;
    text-decoration: none;
    margin-bottom: 10px;
    display: block;
    font-weight: bold;
}

.home-link:hover {
    text-decoration: underline;
}
</style>
