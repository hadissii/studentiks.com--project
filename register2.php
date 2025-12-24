<?php
include 'connect.php'

if(isset($_POST['submit-btn'])){
$firstname=$_POST['fname'];
$lastname=$_POST['lname'];
$email=$_POST['email'];
$password=$_POST['password'];
password=md5($password);

$checkEmail="SELECT * FROM users where email='$email'";
$result=$conn -> query($checkEmail);
if($result -> num_rows > 0){
    echo "Email Adress Already Exists";
}else{
    $insertquery="INSERT INTO users(firstname,lastname,email,password)
    VALUES('$firstname','$lastname','$email','$password')"
}

if($conn -> query($insertquery) == true){
    header("location: register.php")
}else{
    echo "Error:".conn -> error
}

if(isset($_POST['login-submit-btn'])){
$email=$_POST['email'];
$password=$_POST['password'];
password=md5($password);

$checkEmail="SELECT * FROM users where email='$email' and password='$password'";
$result=$conn -> query($sql);
if($result -> num_rows > 0){
session_start();
$row=$result ->fetch_assoc();
$_SESSION['email']=$row['email'];
header("location: homepage.php");
exit();
}else{
echo "Not Found Incorrect Email Or Password"
}
}

?>