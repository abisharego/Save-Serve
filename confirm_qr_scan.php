<?php
session_start();
include "db.php";

// ✅ Validate QR Scan Request
if (!isset($_POST["food_id"])) {
    die("❌ Invalid request: Missing food_id.");
}

$food_id = $_POST["food_id"];

// ✅ Update Status to "Picked Up"
$sql = "UPDATE food_distributions SET status = 'Picked Up' WHERE food_id = ? AND status = 'Pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $food_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo "✅ Pickup confirmed successfully!";
} else {
    echo "❌ Error: Pickup already confirmed or invalid request.";
}

$stmt->close();
$conn->close();
?>
