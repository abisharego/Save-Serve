<?php
session_start();
include "db.php";

// Ensure the user is logged in as an NGO
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "NGO") {
    header("Location: login.html");
    exit();
}

$ngo_id = $_SESSION["user_id"]; // Get NGO ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["volunteer_name"];
    $phone = $_POST["volunteer_phone"];
    $email = $_POST["volunteer_email"];
    $password = password_hash($_POST["volunteer_password"], PASSWORD_BCRYPT); // Secure password
    
    // Insert volunteer into database
    $sql = "INSERT INTO users (name, phone, email, password, user_type, ngo_id) VALUES ('$name', '$phone', '$email', '$password', 'Volunteer', '$ngo_id')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Volunteer added successfully!";
        header("refresh:2; url=ngo_dashboard.php"); // Redirect after 2 seconds
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
