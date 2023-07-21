<?php
$host = "148.66.138.145";
$username = "dbusrShnkr23";
$password = "studDBpwWeb2!";
$dbName = "dbShnkr23stud2";

$conn = mysqli_connect($host, $username, $password, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
