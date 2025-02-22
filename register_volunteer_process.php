<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $location = $_POST["location"];
    $user_type = "Individual";  // Ensure it's set

    $sql = "INSERT INTO users (name, phone, email, password, location, user_type) 
            VALUES ('$name', '$phone', '$email', '$password', '$location', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Individual registered successfully!";
        header("refresh:2; url=login.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
