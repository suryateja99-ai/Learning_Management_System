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

if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  $sql = "SELECT * FROM students WHERE email = '$email'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo '<!DOCTYPE html>
      <html>
      <head>
        <title>Your Profile</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            background-color: #f3f6f8;
            padding: 20px;
          }
          header {
            background-color: #419c49;
            color: #e3e7f0;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px; /* Added gap */
          }
          h1 {
            margin: 0;
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
          .profile-table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
          }
          .profile-table th,
          .profile-table td {
            padding: 10px;
            text-align: left;
          }
          .profile-table th {
            background-color: #419c49;
            color: #e3e7f0;
          }
        </style>
      </head>
      <body>
        <header>
          <h1>Your Profile</h1>
          <a href="stuhome.php" class="home-link">Home</a>
        </header>
        <main>
          <table class="profile-table">';

    while ($row = $result->fetch_assoc()) {
      echo "<tr><th>Fields</th><th>Details</th></tr>";
      echo "<tr><td>First Name:</td><td>" . $row['fname'] . "</td></tr>";
      echo "<tr><td>Last Name:</td><td>" . $row['lname'] . "</td></tr>";
      echo "<tr><td>Email:</td><td>" . $row['email'] . "</td></tr>";
      echo "<tr><td>Hallticket:</td><td>" . $row['hallticket'] . "</td></tr>";
      echo "<tr><td>Date of Birth:</td><td>" . $row['dob'] . "</td></tr>";
      echo "<tr><td>Gender:</td><td>" . $row['gender'] . "</td></tr>";
      echo "<tr><td>Address:</td><td>" . $row['ad1'] . "</td></tr>";
      echo "<tr><td>Year:</td><td>" . $row['yr'] . "</td></tr>";
      echo "<tr><td>Branch:</td><td>" . $row['br'] . "</td></tr>";
      echo "<tr><td>Mobile:</td><td>" . $row['phno'] . "</td></tr>";
      echo "<tr><td>User ID:</td><td>" . $row['user_id'] . "</td></tr>";
    }

    echo '</table>
        </main>
      </body>
      </html>';
  } else {
    echo "No student profile found for the logged-in user.";
  }

  $conn->close();
} else {
  echo "User is not logged in.";
}
?>
