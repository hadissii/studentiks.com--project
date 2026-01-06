<?php
$host = "localhost";
$db_name = "studentiks";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
header("location: index.php");
exit();
}

$conn->set_charset("utf8");
?>
