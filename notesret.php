<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$did = $_POST['did'];
$sql = "SELECT * FROM pydocuments WHERE sname = '$did'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

echo '<html>';
echo '<head>';
echo '<style>';
echo 'body {';
echo '    font-family: Arial, sans-serif;';
echo '    margin: 20px;';
echo '}';
echo 'h2 {';
echo '    color: #333;';
echo '}';
echo 'a {';
echo '    display: block;';
echo '    margin-bottom: 10px;';
echo '    text-decoration: none;';
echo '    color: #0066cc;';
echo '}';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<h2>Download NOTES</h2>';
echo '<a href="stuhome.php">Home</a>'; 

echo '<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

h2 {
    color: #333;
}

a {
    display: block;
    margin-bottom: 10px;
    text-decoration: none;
    color: #0066cc;
}
</style>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $documentData = $row["filecontent"];
        $filename = $row["fileName"];

        echo '<a href="data:application/octet-stream;base64,' . base64_encode($documentData) . '" download="' . $filename . '">Download ' . $filename . '</a><br>';
    }
} else {
    echo "No documents found.";
}

echo '</body>';
echo '</html>';

$conn->close();
?>
