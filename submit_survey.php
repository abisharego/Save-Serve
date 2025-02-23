<?php
$servername = "localhost";
$username = "root";  // Change if using a different DB user
$password = "";      // Change if your DB has a password
$database = "save&serve";  // Change if using a different DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$name = $_POST['name'];
$role = $_POST['role'];
$donation_frequency = $_POST['donation_frequency'];
$challenges = $_POST['challenges'];
$preferred_pickup_time = $_POST['preferred_pickup_time'];
$contact = $_POST['contact'];

// Insert into database
$sql = "INSERT INTO survey_responses (name, role, donation_frequency, challenges, preferred_pickup_time, contact)
        VALUES ('$name', '$role', '$donation_frequency', '$challenges', '$preferred_pickup_time', '$contact')";

if ($conn->query($sql) === TRUE) {
    echo "Thank you for your response!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
