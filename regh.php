<?php
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$pas = $_POST['pas'];
$gender = $_POST['gender'];
$ad1 = $_POST['ad1'];
$sub =$_POST['sub'];
$phno = $_POST['phno'];
 //db connection
$con=mysqli_connect('localhost','root','sunsun55','mdb');
 if(!$con){
    echo "connection fail";
    exit();
}
$sql= "INSERT INTO teachers(id, fname, lname, email, pas, gender, ad1, phno, sub) VALUES('0', '$fname', '$lname', '$email', '$pas', '$gender', '$ad1', '$phno', '$sub')";
if(mysqli_query($con, $sql)){
    echo"New record created";
 }
else{
    echo"Error: ".$sql."<br>". mysqli_error($con);
}
mysqli_close($con);
?>