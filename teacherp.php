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
      h2{
        color: #2BECDB;
        text-shadow: 2px 2px 4px #080808;
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
        font-size: 25px;
        color: #f1f1f1;
        display: block;
        transition: 0.3s;
      }

      .sidenav a:hover {
        color: #fff;
        background-color: #333;
      }
      .sidenav.closebtn {
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
  }
      .openbtn:hover {
        background-color: #444;
      }
      .main {
        transition: margin-left .5s;
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
        border: 4px solid #4462e4;
        text-decoration: none;
        font-size: 18px;
        color: #3e758f;
        display: block;
        margin-bottom: 10px;
        margin-right: 30px;
      }

      .menu a {
        padding: 10px 20px;
        border: 4px solid #4462e4;
        text-decoration: none;
        font-size: 18px;
        color: #3e758f;
        display: block;
        margin-bottom: 10px;
        margin-right: 30px;
      }
      .enu {
        display: flex;
        flex-direction: row;
        list-style-type: none;
        margin: 0;
        padding: 0;
      }
      .enu a {
        padding: 10px 20px;
        border: 4px solid #3961aa;
        text-decoration: none;
        font-size: 18px;
        color: #3e758f;
        display: block;
        margin-right: 30px;
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
        <form align="right" method="post" action="loout.php">
          <button type="submit" id="logout">Logout</button>
        </form>
      <h1>EDUSTAR</h1>
      </center>
    </header>
    <div class="marquee">
    <marquee><?php echo $message; ?></marquee>
    </div>
    <div align="left" class="main">
      <button class="openbtn" onclick="openNav()">&#9776;</button>
    </div>
    <center>
      <h2>Welcome Instructor <?php echo $studentName; ?></h2>
      <div class="menu">
        <button onclick="location.href='stude.php';">
            <img src="https://www.coilk12.net/cms/lib/CA01001063/Centricity/Domain/45/student%20information.png" height="250" width="260">
            <br>Student Details
        </button>
        <button onclick="location.href='stuper.html';"><img src="https://static.vecteezy.com/system/resources/thumbnails/016/693/544/small_2x/3d-render-increase-bar-graph-icon-png.png" alt="Graph" height="250" width="260"><br>Students Performances</button>
        <button onclick="location.href='assicorr.html';"><img src="https://static.vecteezy.com/system/resources/thumbnails/009/733/051/small_2x/3d-check-list-sheet-of-paper-for-efficiency-work-progress-icon-design-paper-document-with-tasks-and-check-and-cross-mark-symbol-project-plan-time-management-exam-blank-medical-anamnesis-vector.jpg" alt="Graph" height="250" width="260"><br>Assaignment correction and post result</button>
        <button onclick="location.href='sechdule.html';"><img src="https://static.vecteezy.com/system/resources/thumbnails/022/498/223/small_2x/alarm-clock-3d-render-isolated-on-transparent-background-png.png" alt="Graph" height="250" width="260"><br>Sechedule Exams</button>
      </div>
    </center>
    <div class="sidenav">
      <h3>SELECT :</h3>
      <a href="#" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="tnotes.html">UPLOAD NOTES</a><br><br>
      <a href="tquery.html">STUDENT QURIES</a><br><br>
      <a href="tassaign.html">POST ASSIGNMENTS</a><br><br>
      <a href="gettt.html">TIMETABLE</a><br><br>
    </div>

    <div class="enu">
        <a href="stuat.html"><img src="https://www.clipartmax.com/png/full/436-4361431_marks-student-icon-icon-search-engine-student-attendance-system-logo.png" alt="Graph" height="250" width="260"><br>Student attendance</a>
        <a href="check.php"><img src="https://www.paatham.in/assets/images/1.webp" alt="Graph" height="300" width="261"><br>Check Student attendance</a>
    </div>
    <script>
      function openNav() {
        document.querySelector(".sidenav").classList.add("active");
        document.querySelector(".main").classList.add("active");
      }
    
      function closeNav() {
        document.querySelector(".sidenav").classList.remove("active");
        document.querySelector(".main").classList.remove("active");
      }
    </script>
  </body>
</html>
