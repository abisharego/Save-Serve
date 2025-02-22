<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_name = $_POST["restaurant_name"];
    $manager_name = $_POST["manager_name"];
    $phone = $_POST["phone"];
    $location = $_POST["location"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password

    // Debug: Print SQL Query
    $sql = "INSERT INTO users (name, phone, email, password, location, user_type, restaurant_name, manager_name) 
            VALUES ('$manager_name', '$phone', '$email', '$password', '$location', 'Restaurant', '$restaurant_name', '$manager_name')";

    

    if ($conn->query($sql) === TRUE) {
        echo "Restaurant registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
