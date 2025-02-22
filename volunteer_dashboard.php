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
    <p><strong>Total Food Distributed:</strong> <?php echo $distribution_count; ?> times</p>

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
                    <a href="confirm_pickup.php?food_id=<?php echo $food['id']; ?>">Confirm Pickup</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h3>Upload Proof of Distribution</h3>
    <form action="upload_proof.php" method="post" enctype="multipart/form-data">
        <input type="file" name="proof_image" required>
        <input type="hidden" name="volunteer_id" value="<?php echo $volunteer_id; ?>">
        <button type="submit">Upload</button>
    </form>

    <a href="logout.php">Logout</a>

</body>
</html>
