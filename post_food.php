<?php
session_start();
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// ✅ Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("<script>alert('Error: No user logged in. Please login again.'); window.location.href='login.php';</script>");
}
$user_id = $_SESSION['user_id']; // Logged-in user ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ✅ Validate required fields
    if (empty($_POST['food_type']) || empty($_POST['quantity'])) {
        die("<script>alert('All fields are required.'); window.history.back();</script>");
    }

    $food_type = trim($_POST['food_type']);
    $quantity = trim($_POST['quantity']);

    // ✅ Fetch location from database (if user is a restaurant)
    $query = "SELECT location FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($location);
    $stmt->fetch();
    $stmt->close();

    if (empty($location)) {
        die("<script>alert('Error: No location found. Please update your profile.'); window.location.href='restaurant_dashboard.php';</script>");
    }

    $timestamp = date('Y-m-d H:i:s');

    // ✅ Insert food post into the database
    $insert_query = "INSERT INTO food_posts (food_type, quantity, location, user_id, created_at) 
                     VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssis", $food_type, $quantity, $location, $user_id, $timestamp);
    
    if ($stmt->execute()) {
        // ✅ Fetch all NGOs & Volunteers' emails
        $fetch_users = "SELECT email FROM users WHERE user_type IN ('NGO', 'Volunteer')";
        $result = $conn->query($fetch_users);

        $subject = "New Food Available for Distribution!";
        $message = "🍲 **Food Type**: $food_type\n📦 **Quantity**: $quantity\n📍 **Location**: $location\n\n🚀 Claim it now on **Save & Serve**!";

        // ✅ Send email notifications
        while ($row = $result->fetch_assoc()) {
            $to_email = $row['email'];
            sendEmail($to_email, $subject, $message);
        }

        echo "<script>alert('Food posted successfully and notifications sent!'); window.location.href='restaurant_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error posting food. Please try again.'); window.location.href='restaurant_dashboard.php';</script>";
    }
}

// ✅ Function to send email using PHPMailer
function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    try {
        // ✅ SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'abisharego18@gmail.com'; // Replace with your email
        $mail->Password = 'woyo tjgp xlah tasa'; // Use App Password, NOT your actual email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // ✅ Email Content
        $mail->setFrom('abisharego18@gmail.com', 'Save & Serve');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if (!$mail->send()) {
            error_log("Email failed to: $to - Error: {$mail->ErrorInfo}");
        } else {
            error_log("Email sent successfully to: $to");
        }
    } catch (Exception $e) {
        error_log("Exception: Email to $to failed - Error: {$mail->ErrorInfo}");
    }
}
?>

<!-- ✅ Food Post Form -->
<form action="post_food.php" method="POST">
    <label for="food_type">Food Type:</label>
    <input type="text" name="food_type" required>

    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity" required>

    <label for="location">Location:</label>
    <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" readonly>

    <button type="submit">Post Food</button>
</form>
