<?php
session_start();
include "db.php";

$query = "SELECT id, food_type, quantity, location, posted_by FROM food_posts";
$result = $conn->query("SELECT * FROM food_posts LIMIT 1");
if (!$result) {
    die("Query Failed: " . $conn->error);
}

// Check if the user is logged in and is a volunteer
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "Volunteer") {
    header("Location: login.php");
    exit();
}

$volunteer_id = $_SESSION["user_id"];

// Fetch the volunteer's distribution count
$dist_query = "SELECT COUNT(*) AS distribution_count FROM food_distributions WHERE volunteer_id = '$volunteer_id'";
$dist_result = $conn->query($dist_query);
$distribution_count = ($dist_result->num_rows > 0) ? $dist_result->fetch_assoc()["distribution_count"] : 0;

// Fetch real-time available food posts
$food_query = "SELECT * FROM food_posts WHERE status = 'Available' ORDER BY created_at DESC";
$food_result = $conn->query($food_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/volunteer_dashboard.css">
    <title>Volunteer Dashboard</title>
</head>
<body>

    <h2>Welcome, Volunteer!</h2>
    <p><strong>Total Confirmation Count:</strong> <?php echo $distribution_count; ?> times</p>
    <input type="hidden" id="volunteer_id" value="<?php echo $volunteer_id; ?>">
    <div id="result"></div> <!-- To Display QR Code -->
    <h3>Available Food Donations</h3>
    <table border="1">
        <tr>
            <th>Food Type</th>
            <th>Quantity</th>
            <th>Location</th>
            <th>Posted By</th>
            <th>Action</th>
        </tr>

        <?php while ($food = $food_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $food["food_type"]; ?></td>
                <td><?php echo $food["quantity"]; ?></td>
                <td><?php echo $food["location"]; ?></td>
                <td><?php echo $food["posted_by"]; ?></td>
                <td>
    <button class="confirmPickupBtn" data-food-id="<?php echo $food['id']; ?>">Confirm Pickup</button>
</td>
            </tr>
        <?php } ?>
    </table>

    <h3>Pending Pickups</h3>
<table border="1">
    <tr>
        <th>Food Type</th>
        <th>Quantity</th>
        <th>Location</th>
        <th>QR Code</th>
        <th>Status</th>
        <th>Proof</th>
    </tr>

    <?php
    $pending_query = "SELECT f.food_type, f.quantity, f.location, d.qr_code, d.status, d.id 
                      FROM food_distributions d
                      JOIN food_posts f ON d.food_id = f.id
                      WHERE d.volunteer_id = ? AND d.status = 'Pending'
                      ORDER BY d.distribution_time DESC";
    $stmt = $conn->prepare($pending_query);
    $stmt->bind_param("i", $volunteer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["food_type"]; ?></td>
            <td><?php echo $row["quantity"]; ?></td>
            <td><?php echo $row["location"]; ?></td>
            <td><img src="<?php echo $row["qr_code"]; ?>" alt="QR Code"></td>
            <td><?php echo $row["status"]; ?></td>
            <td>
                <form action="upload_proof.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="proof_image" required>
                    <input type="hidden" name="distribution_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Upload Proof</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".confirmPickupBtn").click(function() {
        let foodId = $(this).data("food-id");
        let volunteerId = $("#volunteer_id").val(); // Get hidden volunteer ID

        if (!foodId || !volunteerId) {
            alert("❌ Missing food ID or volunteer ID.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "confirm_pickup.php",
            data: { food_id: foodId, volunteer_id: volunteerId },
            success: function(response) {
                $("#result").html(response); // ✅ Display QR Code
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("❌ Error confirming pickup.");
            }
        });
    });
});
</script>

    <a href="logout.php">Logout</a>

</body>
</html>
