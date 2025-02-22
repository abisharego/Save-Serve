<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $location = $_POST["location"];
    $food_type = $_POST["food_type"];
    $quantity = $_POST["quantity"];

    // Insert Individual Donor into users table
    $sql = "INSERT INTO users (name, phone, location, user_type) 
            VALUES ('$name', '$phone', '$location', 'Individual')";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id; // Get the newly created user ID
        
        // Insert food donation details
        $food_sql = "INSERT INTO food_posts (user_id, food_type, quantity, location) 
                     VALUES ('$user_id', '$food_type', '$quantity', '$location')";
        
        if ($conn->query($food_sql) === TRUE) {
            echo "Individual registered and food post added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
    
    $conn->close();
}
?>
