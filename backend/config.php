

<?php
$servername = "localhost"; // if the database is on the same server as the php file
$username = "root"; // replace with your phpMyAdmin username
$password = ""; // replace with your phpMyAdmin password
$dbname = "ewlearn"; 

// create connection
$conn = new mysqli($servername, $username, $password,$dbname) ;

// check connection
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>