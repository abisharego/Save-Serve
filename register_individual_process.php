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
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $food_type = $_POST['food_type'];
    $quantity = $_POST['quantity'];
    $timestamp = date('Y-m-d H:i:s');

    // ✅ Check if donor is logged in
    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

    // ✅ Insert into `food_posts`
    $sql = "INSERT INTO food_posts (user_id, donor_name, donor_phone, food_type, quantity, location, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $name, $phone, $food_type, $quantity, $location, $timestamp);
    
    if ($stmt->execute()) {
        // ✅ Fetch NGO and Volunteer Emails
        $emails = [];
        $query = "SELECT email FROM users WHERE user_type IN ('NGO', 'Volunteer')";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }

        // ✅ Send Email Notification
        if (!empty($emails)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Change if needed
                $mail->SMTPAuth = true;
                $mail->Username = 'abisharego18@gmail.com'; // Replace with your email
                $mail->Password = 'woyo tjgp xlah tasa'; // Replace with your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('abisharego18@gmail.com', 'Save & Serve');
                foreach ($emails as $email) {
                    $mail->addAddress($email);
                }

                $mail->isHTML(true);
                $mail->Subject = "New Food Donation Available!";
                $mail->Body = "
                    <h2>New Food Donation Alert! 🍽️</h2>
                    <p><strong>Donor:</strong> $name</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Location:</strong> $location</p>
                    <p><strong>Food Type:</strong> $food_type</p>
                    <p><strong>Quantity:</strong> $quantity</p>
                    <p>Please coordinate for pickup as soon as possible.</p>
                    <br>
                    <p>📍 <a href='https://maps.google.com/?q=$location'>View Location</a></p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Email failed: " . $mail->ErrorInfo);
            }
        }

        echo "<script>alert('Registration successful! Volunteers & NGOs have been notified.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error in registration.'); window.location.href='register_individual.php';</script>";
    }
}
?>
