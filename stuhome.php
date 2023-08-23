<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$query = "SELECT message FROM marquee_messages";
$statement = $pdo->prepare($query);
$statement->execute();
$message = $statement->fetchColumn();

session_start();
$loginEmail = $_SESSION['email'];

$getNameQuery = "SELECT fname FROM students WHERE email = :email";
$getNameStatement = $pdo->prepare($getNameQuery);
$getNameStatement->bindParam(':email', $loginEmail);
$getNameStatement->execute();
$studentName = $getNameStatement->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://kit.fontawesome.com/f563d69312.js" crossorigin="anonymous"></script>
  <title>Menu</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      background-image: url("https://media.istockphoto.com/id/1367756031/vector/light-blue-watercolor-background-illustration.jpg?s=612x612&w=0&k=20&c=qiJl7j-2terwHd-1YJxiFIo1VJx6l6IsmoqlgeypQ7c=");
    }

    header {
      background-image: url("https://i0.wp.com/codemyui.com/wp-content/uploads/2019/06/Shooting-Star-Background-in-Pure-CSS-1.gif?fit=880%2C440&ssl=1&resize=350%2C250");
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    h1 {
      margin: 0;
    }

    h3 {
      display: block;
      color: #fdf5f5;
      text-shadow: 2px 2px 4px #080808;
      padding: 10px 0;
    }

    h2 {
      color: #71b2e7;
      text-shadow: 2px 2px 4px #f9fbfc;
      padding: 10px 0;
    }

    #logout {
      background-color: #2c7fdf;
      border: none;
      top: 10px;
      right: 10px;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
      margin: 10px;
      border-radius: 5px;
    }

    #logout:hover {
      background-color: #183f5f;
    }

    .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #2c4779;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 20px;
    }

    .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 20px;
      color: #f1f1f1;
      display: block;
      transition: 0.3s;
    }

    .sidenav a:hover {
      color: #fff;
      background-color: #333;
    }

    .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }

    .openbtn {
      font-size: 20px;
      cursor: pointer;
      background-color: #111;
      color: white;
      padding: 10px 15px;
      border: none;
      float: left;
    }

    .openbtn:hover {
      background-color: #444;
    }

    .main {
      transition: margin-left 0.5s;
      padding: 20px;
    }

    .sidenav.active {
      width: 250px;
    }

    .main.active {
      margin-left: 250px;
    }

    .menu {
      display: flex;
      flex-direction: row;
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    .menu button {
      padding: 10px 20px;
      border: 5px solid #305197;
      text-decoration: none;
      font-size: 18px;
      color: #3e758f;
      display: block;
      margin-right: 80px;
      background: none;
      cursor: pointer;
    }
    
    .enu {
      display: flex;
      flex-direction: row;
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    .in {
      color: #eff1f1;
      background-color: #157aee;
      float: left;
    }

    #on {
      background-color: #2c7fdf;
      border: none;
      top: 10px;
      right: 10px;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
      margin: 10px;
      border-radius: 5px;
    }

    #on:hover {
      background-color: #183f5f;
    }

    #an {
      background-color: #2C944F;
      border: none;
      top: 10px;
      right: 10px;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
      margin: 10px;
      border-radius: 5px;
    }

    #an:hover {
      background-color: green;
    }


    .enu a {
      padding: 10px 20px;
      border: 1px solid #ccc;
      text-decoration: none;
      font-size: 18px;
      color: #89cae9;
      display: block;
    }

    aside {
      background-color: #8ed8eb;
      padding: 10px;
      border-radius: 5px;
      margin-top: 20px;
    }
    .marquee {
      background-color: #2c4779;
      color: #fff;
      padding: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
<header>
  <center>
    <h1>EDUSTAR</h1>
  </center>
  <form align="right" method="post" action="logout.php">
    <button type="submit" id="logout">Logout</button>
  </form>
</header>
<div class="marquee">
  <marquee><?php echo $message; ?></marquee>
</div>
<center>
  <span class="openbtn" onclick="openNav()">&#9776;</span><br><br><br>
  <button class="in" onclick="openNewTab()">INBOX</button>
  <h2>Welcome    <span id="studentname"><?php echo $studentName; ?></span></h2>
  </center>
  <div class="menu">
    <button onclick="location.href='sper.php';">
      <img src="https://cdn0.iconfinder.com/data/icons/data-visualization-color-1/64/distribution-bar-graph-histogram-256.png" alt="Graph" height="215" width="215">
      <br>Your Performances
    </button>
    <button name="submit" onclick="location.href='results.html';">
      <img src="https://www.freeiconspng.com/thumbs/results-icon-png/results-icon-png-12.png" alt="Graph" height="215" width="215">
      <br>Recent Assignment Results
    </button>
    <button onclick="location.href='upcom.php';">
      <img src="https://brightspotcdn.byu.edu/dims4/default/e4f73ef/2147483647/strip/true/crop/228x228+23+0/resize/360x360!/quality/100/?url=https:%2F%2Fbrigham-young-brightspot.s3.amazonaws.com%2F5c%2F85%2Fb1fd16124eeaa2e38fd5b8717ab0%2Fchecklist-icon.png" alt="Graph" height="215" width="215">
      <br>Upcoming Exams
    </button>
    <button onclick="location.href='subass.html';">
      <img src="https://cdn3.iconfinder.com/data/icons/education-555/512/computer-education-learning-search-elearning-512.png" alt="Graph" height="215" width="215">
      <br>Assignments
    </button>
  </div>

<div class="sidenav">
  <form align="center" method="post" action="stuprofile.php">
    <button type="submit" id="on">MY PROFILE</button>
  </form>
  <br><br>
  <h3><center> SELECT </center></h3>
  <a href="#" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="notes.html">NOTES</a><br><br>
  <a href="query.html">POST A QUERY</a><br><br>
  <form align="center" method="POST" action="stugettt.php">
  <input type="submit" id="an" value="TIMETABLE" name="submit"><br><br>
  </form>
</div>

<aside>
  <h3>HELLO STUDENTS &#x1F44B;</h3>
  <h4>Utilize the features available:</h4>
  <ul>
    <li><strong>Access to Enrolled Courses:</strong> The student module provides easy access to all the courses in which the student is enrolled. Students can navigate through the courses and access the course materials, lectures, assignments, and other related resources.</li><br><br>
    <li><strong>Track Performance and Progress:</strong> Students can view their performance and progress within each course. The module displays grades, scores, and progress indicators, allowing students to monitor their academic achievements and identify areas for improvement.</li><br><br>
    <li><strong>View Quiz and Assignment Results:</strong> Students can check their recent quiz and assignment results through the module. It provides a detailed overview of their performance, including scores, feedback, and any additional information provided by the instructors.</li><br><br>
    <li><strong>Upcoming Exams and Events:</strong> The student module keeps students informed about upcoming exams, quizzes, assignments, and other important events related to their courses. It helps them stay organized and prepared by providing timely reminders and notifications.</li><br><br>
    <li><strong>Access to Study Materials:</strong> Students can access various study materials, such as lecture notes, slides, eBooks, and supplementary resources, within the student module. This ensures easy availability of learning materials and supports independent studying.</li><br><br>
    <li><strong>Communicate and Post Queries:</strong> The module allows students to post queries, seek clarification, and participate in discussions related to their courses. They can interact with instructors and fellow students, fostering a collaborative learning environment.</li><br><br>
    <li><strong>View Timetable:</strong> Students can view their personalized timetable within the student module. It provides a convenient overview of their class schedule, including lecture timings, breaks, and any changes to the schedule.</li><br><br>
    <li><strong>Explore Available Courses:</strong> The module also provides information about available courses and programs offered by the educational institution. Students can explore new courses, enroll in additional programs, or express interest in specific subjects or fields of study.</li><br><br>
  </ul>
</aside>


<script>
  function openNav() {
    document.getElementsByClassName("sidenav")[0].style.width = "250px";
    document.getElementsByClassName("main")[0].style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
  }

  function closeNav() {
    document.getElementsByClassName("sidenav")[0].style.width = "0";
    document.getElementsByClassName("main")[0].style.marginLeft = "0";
    document.body.style.backgroundColor = "white";
  }

  function openNewTab() {
    window.open("inbox.html", "_blank");
  }
</script>
</body>
</html>
