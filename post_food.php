<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "Restaurant") {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $food_type = $_POST["food_type"];
    $quantity = $_POST["quantity"];
    $location = $_SESSION["location"]; // Assuming location is stored in session

    // Insert food post into the database
    $sql = "INSERT INTO food_posts (user_id, food_type, quantity, location, created_at) 
            VALUES ('$user_id', '$food_type', '$quantity', '$location', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Food posted successfully!";
        header("Location: restaurant_dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
