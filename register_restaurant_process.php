<?php
session_start();
include "db.php";

// ✅ Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ✅ Ensure all form fields are present
    if (!isset($_POST['restaurant_name'], $_POST['phone'], $_POST['location'], $_POST['email'], $_POST['password'], $_POST['food_type'], $_POST['quantity'])) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit();
    }

    // ✅ Get form data
    $restaurant_name = trim($_POST['restaurant_name']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $food_type = trim($_POST['food_type']);  // Make sure this matches form field name
    $quantity = trim($_POST['quantity']);    // Make sure this matches form field name
    $timestamp = date('Y-m-d H:i:s');

    // ✅ Debugging: Check received data
    error_log("Received: Name: $restaurant_name, Phone: $phone, Location: $location, Food: $food_type, Qty: $quantity");

    // ✅ Insert restaurant into `users`
    $insert_user = "INSERT INTO users (name, phone, email, password, user_type, created_at) 
                    VALUES (?, ?, ?, ?, 'Restaurant', ?)";
    $stmt = $conn->prepare($insert_user);
    $stmt->bind_param("sssss", $restaurant_name, $phone, $email, $password, $timestamp);

    if ($stmt->execute()) {
        // ✅ Get the new restaurant's user ID
        $user_id = $stmt->insert_id;

        // ✅ Insert food donation into `food_posts`
        $sql = "INSERT INTO food_posts (user_id, donor_name, donor_phone, location, food_type, quantity, created_at, donor_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Restaurant')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $user_id, $restaurant_name, $phone, $location, $food_type, $quantity, $timestamp);
        if (!$stmt->execute()) {
            error_log("Food Post Insert Error: " . $stmt->error);
        }

        // ✅ Fetch NGO and Volunteer Emails
        $emails = [];
        $query = "SELECT email FROM users WHERE user_type IN ('NGO', 'Volunteer')";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }

        // ✅ Debugging: Check if food_type and quantity exist
        error_log("Sending Email: Food: $food_type, Qty: $quantity");

        // ✅ Send Email Notification
        if (!empty($emails)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'your_email@gmail.com'; // Replace with your email
                $mail->Password = 'your_email_app_password'; // Replace with your email app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your_email@gmail.com', 'Save & Serve');
                foreach ($emails as $email) {
                    $mail->addAddress($email);
                }

                $mail->isHTML(true);
                $mail->Subject = "🍽️ New Food Donation from $restaurant_name!";
                $mail->Body = "
                    <h2>New Food Donation Alert! 🍽️</h2>
                    <p><strong>Restaurant:</strong> $restaurant_name</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Location:</strong> $location</p>
                    <p><strong>Food Type:</strong> $food_type</p>
                    <p><strong>Quantity:</strong> $quantity</p>
                    <br>
                    <p>📍 <a href='https://maps.google.com/?q=$location' target='_blank'>View Location on Google Maps</a></p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Email failed: " . $mail->ErrorInfo);
            }
        }

        echo "<script>alert('Restaurant registered & food donation added! NGOs & Volunteers have been notified.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error in registration. Try again.'); window.history.back();</script>";
    }
}
?>
