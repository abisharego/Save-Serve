<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST["role"];
    $location = "Not specified"; // Default location

    // Insert Receiver into users table
    $sql = "INSERT INTO users (name, phone, email, password, user_type, location) 
            VALUES ('$name', '$phone', '$email', '$password', '$role', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "Receiver registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
