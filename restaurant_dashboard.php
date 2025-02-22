<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "Restaurant") {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$name = $_SESSION["name"];

// Fetch restaurant donation history
$sql = "SELECT * FROM food_posts WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<h2>Welcome, <?php echo $name; ?> (Restaurant)</h2>

<h3>Post Food</h3>
<form action="post_food.php" method="POST">
    <label for="food_type">Food Type:</label>
    <input type="text" name="food_type" required><br>

    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity" required><br>

    <button type="submit">Post Food</button>
</form>

<h3>Donation History</h3>
<table border="1">
    <tr><th>Food Type</th><th>Quantity</th><th>Time</th></tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["food_type"]; ?></td>
            <td><?php echo $row["quantity"]; ?></td>
            <td><?php echo $row["created_at"]; ?></td>
        </tr>
    <?php } ?>
</table>
