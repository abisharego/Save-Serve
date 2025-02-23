<?php
session_start();
include "db.php";
include "phpqrcode/qrlib.php"; // Include QR Code library

// Ensure the 'qrcodes' directory exists
$qrDir = "qrcodes/";
if (!is_dir($qrDir)) {
    mkdir($qrDir, 0777, true);
}

// Validate input
if (!isset($_POST["food_id"], $_POST["volunteer_id"])) {
    die("❌ Invalid request: Missing food_id or volunteer_id.");
}

$food_id = $_POST["food_id"];
$volunteer_id = $_POST["volunteer_id"];

// Fetch food details
$sql = "SELECT quantity, food_type FROM food_posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $food_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Food item not found.");
}

$row = $result->fetch_assoc();
$quantity = $row["quantity"];
$food_type = $row["food_type"];

// Generate QR Code content
$qrData = "Food ID: $food_id\nVolunteer ID: $volunteer_id\nFood Type: $food_type\nQuantity: $quantity";
$qrFileName = $qrDir . "food_" . $food_id . ".png";

// Generate and Save QR Code
QRcode::png($qrData, $qrFileName, QR_ECLEVEL_L, 5);

// Insert or Update the QR Code in `food_distributions` table
$sql = "INSERT INTO food_distributions (food_id, volunteer_id, quantity, qr_code, status, distribution_time) 
        VALUES (?, ?, ?, ?, 'Pending', NOW())
        ON DUPLICATE KEY UPDATE qr_code = VALUES(qr_code), status = 'Pending'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $food_id, $volunteer_id, $quantity, $qrFileName);

if ($stmt->execute()) {
    echo "✅ Pickup confirmed! QR Code saved:<br>";
    echo "<img src='$qrFileName' alt='QR Code'>";
} else {
    echo "❌ Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
