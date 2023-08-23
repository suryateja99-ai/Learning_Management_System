<?php
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$hallticket = $_POST['hallticket'];
$email = $_POST['email'];
$pas = $_POST['pas'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$ad1 = $_POST['ad1'];
$yr = $_POST['yr'];
$phno = $_POST['phno'];
$br= $_POST['br'];
$user_id=$_POST['user_id'];

$con = mysqli_connect('localhost','root','sunsun55','mdb');
if(!$con){
    echo "Connection failed";
    exit();
}

$query = "SELECT * FROM students WHERE email='$email'";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    echo "User already exists!";
    exit();
}

$sql = "INSERT INTO students (id, fname, lname, hallticket, email, pas, dob, gender, ad1, yr, phno, br, user_id) VALUES ('0', '$fname', '$lname', '$hallticket', '$email', '$pas', '$dob', '$gender', '$ad1', '$yr', '$phno', '$br', '$user_id')";
if(mysqli_query($con, $sql)){
    echo "New record created in students table.";

    $userId = mysqli_insert_id($con);
    $credentialsInsertQuery = "INSERT INTO cred (email, pas) VALUES ('$email', '$pas')";
    if(mysqli_query($con, $credentialsInsertQuery)){
        echo "...";
    } else {
        echo "Error: " . $credentialsInsertQuery . "<br>" . mysqli_error($con);
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>
