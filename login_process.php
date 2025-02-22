<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch user details
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_type"] = $user["user_type"];
            $_SESSION["name"] = $user["name"];

            // Redirect based on user type
            if ($user["user_type"] == "Restaurant") {
                header("Location: restaurant_dashboard.php");
            } elseif ($user["user_type"] == "NGO") {
                header("Location: ngo_dashboard.php");
            } elseif ($user["user_type"] == "Volunteer") {
                header("Location: volunteer_dashboard.php");
            } elseif ($user["user_type"] == "Individual") {
                header("Location: individual_dashboard.php");
            }else{        
                echo "Unknown user type!";
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $conn->close();
}
?>
