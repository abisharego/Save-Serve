<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "Restaurant") {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$name = $_SESSION["name"];

// Fetch restaurant details
$sql = "SELECT name, email, phone, location FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($restaurant_name, $email, $phone, $location);
$stmt->fetch();
$stmt->close();

// Fetch restaurant donation history
$sql = "SELECT * FROM food_posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <style>
        /* =============================
   🔹 GLOBAL STYLES
============================= */
body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fc;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* =============================
   🔹 HEADER STYLES
============================= */
header {
    background: #1f2937;
    color: white;
    padding: 15px 20px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.header-title {
    font-size: 22px;
    font-weight: 600;
}

.header-buttons {
    display: flex;
    gap: 15px;
}

.header-buttons button,
.logout-btn {
    background: #2563eb;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.logout-btn {
    background: #d32f2f;
    text-decoration: none;
}

.header-buttons button:hover {
    background: #1d4ed8;
}

.logout-btn:hover {
    background: #b71c1c;
}

/* =============================
   🔹 MAIN CONTAINER
============================= */
.container {
    max-width: 900px;
    width: 90%;
    margin-top: 30px;
    text-align: center;
}

/* =============================
   🔹 BUTTON STYLES
============================= */
button {
    background: #2563eb;
    color: #fff;
    font-size: 16px;
    padding: 12px 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
}

button:hover {
    background: #1d4ed8;
}

/* =============================
   🔹 FORM STYLES
============================= */
.form-container {
    display: none;
    opacity: 0;
    max-height: 0;
    overflow: hidden;
    transition: opacity 0.4s ease-in-out, max-height 0.6s ease-in-out;
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.form-container.active {
    display: block;
    opacity: 1;
    max-height: 500px;
}

form {
    display: flex;
    flex-direction: column;
    text-align: left;
}

label {
    font-weight: bold;
    margin: 10px 0 5px;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* =============================
   🔹 TABLE STYLES
============================= */
.card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

th {
    background: #2563eb;
    color: #fff;
    font-weight: bold;
}

tr:nth-child(even) {
    background: #f9f9f9;
}

tr:hover {
    background: #e2e8f0;
}

/* =============================
   🔹 PROFILE MODAL
============================= */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 80%;
    max-width: 400px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.close {
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

/* =============================
   🔹 RESPONSIVE DESIGN
============================= */
@media (max-width: 768px) {
    .container {
        width: 100%;
        padding: 0 15px;
    }

    .header-content {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .header-buttons {
        flex-direction: column;
        align-items: center;
    }

    .logout-btn {
        width: 100%;
        text-align: center;
    }
}

    </style>
</head>
<body>

<header>
    <div class="header-content">
        <h2>Welcome, <?php echo htmlspecialchars($name); ?> (Restaurant)</h2>
        <div class="header-buttons">
            <button id="profileBtn">Profile</button>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</header>

<div class="container">

    <!-- "Post Food" Button -->
    <button id="postFoodBtn">Post Food</button>

    <!-- Expandable Form -->
    <div class="card form-container" id="foodForm">
        <h3>Post Food</h3>
        <form action="post_food.php" method="POST">
            <label for="food_type">Food Type:</label>
            <input type="text" name="food_type" required>

            <label for="quantity">Quantity:</label>
            <input type="text" name="quantity" required>

            <label for="pickup_time">Pickup Time:</label>
            <input type="text" name="pickup_time" placeholder="e.g., 6:00 PM" required>

            <label for="special_notes">Special Notes:</label>
            <input type="text" name="special_notes" placeholder="Any additional instructions"><br>

            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Donation History Table -->
    <div class="card">
        <h3>Donation History</h3>
        <table>
            <tr><th>Food Type</th><th>Quantity</th><th>Time</th></tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["food_type"]); ?></td>
                    <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                    <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<!-- Profile Modal -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Restaurant Profile</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($restaurant_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($location); ?></p>
    </div>
</div>

<!-- JavaScript for Expandable Form & Profile Modal -->
<script>
document.getElementById("postFoodBtn").addEventListener("click", function() {
    var form = document.getElementById("foodForm");
    form.classList.toggle("active");
});

// Profile Modal
var modal = document.getElementById("profileModal");
var btn = document.getElementById("profileBtn");
var closeBtn = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

closeBtn.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
