<?php
$host = "localhost";
$dbname = "save&serve";
$username = "root";  // Change this if needed
$password = "";  // Change this if you have a MySQL password

$conn = new mysqli($host, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
