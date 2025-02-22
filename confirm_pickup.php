<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_id = $_POST["food_id"];
    $volunteer_id = $_SESSION["user_id"];
    
    // Fetch food details
    $sql_food = "SELECT * FROM food_posts WHERE id = '$food_id'";
    $result_food = $conn->query($sql_food);
    $food = $result_food->fetch_assoc();

    // Get NGO ID
    $sql_ngo = "SELECT ngo_id FROM users WHERE id = '$volunteer_id'";
    $result_ngo = $conn->query($sql_ngo);
    $ngo = $result_ngo->fetch_assoc();
    $ngo_id = $ngo['ngo_id'];

    // Insert into food_distributions
    $sql_insert = "INSERT INTO food_distributions (food_id, ngo_id, volunteer_id, food_type, quantity, collected_by) 
                   VALUES ('$food_id', '$ngo_id', '$volunteer_id', '{$food['food_type']}', '{$food['quantity']}', '{$_SESSION['name']}')";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "Food pickup confirmed!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
