<?php
session_start();
include "db.php";

// Ensure the user is logged in as an NGO
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "NGO") {
    header("Location: login.html");
    exit();
}

$ngo_id = $_SESSION["user_id"]; // NGO ID from session

// Fetch NGO details
$sql_ngo = "SELECT name FROM users WHERE id = '$ngo_id'";
$result_ngo = $conn->query($sql_ngo);

if ($result_ngo->num_rows > 0) {
    $row = $result_ngo->fetch_assoc();
    $name = $row['name'];  // Now $name is defined
} else {
    $name = "NGO"; // Default name if not found
}

// Fetch volunteers under this NGO
$sql_volunteers = "SELECT * FROM users WHERE user_type = 'Volunteer' AND ngo_id = '$ngo_id'";
$result_volunteers = $conn->query($sql_volunteers);

// Fetch food collection history
$sql_history = "SELECT * FROM food_distributions WHERE ngo_id = '$ngo_id' ORDER BY distribution_time DESC";
$result_history = $conn->query($sql_history);

if (!$result_history) {
    echo "Error fetching food distribution history: " . $conn->error;
}

$result_history = $conn->query($sql_history);
?>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<h2>Welcome, <?php echo $name; ?> (NGO)</h2>

<h2>Volunteers Under Your NGO</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php
    // Fetch volunteers linked to this NGO
    $sql_volunteers = "SELECT * FROM users WHERE user_type = 'Volunteer' AND ngo_id = '$ngo_id'";
    $result_volunteers = $conn->query($sql_volunteers);

    if ($result_volunteers->num_rows > 0) {
        while ($row = $result_volunteers->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td><a href='remove_volunteer.php?id=" . $row["id"] . "'>Remove</a></td>
                 </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No volunteers added yet.</td></tr>";
    }
    ?>
</table>

<h2>Add Volunteer</h2>
<form action="add_volunteer.php" method="POST">
    <label>Name:</label>
    <input type="text" name="volunteer_name" required>
    
    <label>Phone:</label>
    <input type="text" name="volunteer_phone" required>
    
    <label>Email:</label>
    <input type="email" name="volunteer_email" required>
    
    <label>Password:</label>
    <input type="password" name="volunteer_password" required>
    
    <button type="submit">Add Volunteer</button>
</form>

<h3>Food Collection History</h3>
<table border="1">
    <tr><th>Food Type</th><th>Quantity</th><th>Collected By</th><th>Time</th><th>Proof</th></tr>
    <?php while ($row = $result_history->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["food_type"]; ?></td>
            <td><?php echo $row["quantity"]; ?></td>
            <td><?php echo $row["collected_by"]; ?></td>
            <td><?php echo $row["distribution_time"]; ?></td>
            <td><img src="<?php echo $row["proof_image"]; ?>" width="100"></td>
        </tr>
    <?php } ?>
</table>
