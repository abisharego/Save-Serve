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
<style>
    /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    text-align: center;
}

/* Header */
h2 {
    color: #333;
    background-color: #fff;
    padding: 15px;
    margin: 0;
}

/* Table Styles */
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background: white;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background: #4CAF50;
    color: white;
}

/* Buttons and Links */
a {
    text-decoration: none;
    color: #d9534f;
    font-weight: bold;
}

a:hover {
    color: #b52b27;
}

/* Form Styling */
form {
    width: 60%;
    margin: 20px auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}

input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #28a745; /* Green color */
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background-color: #218838; /* Darker green on hover */
}

button:active {
    background-color: #1e7e34; /* Even darker green on click */
}

/* Food Collection History - Images */
img {
    display: block;
    margin: auto;
    border-radius: 5px;
}

/* Modal Background */
/* Modal Background */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

/* Modal Content */
.modal-content {
    background-color: #fff;
    padding: 20px;
    width: 50%;
    margin: 10% auto;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
}

/* Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: black;
}

/* Add Volunteer Button */
button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background-color: #218838;
}

button:active {
    background-color: #1e7e34;
}

/* Form Inputs */
input {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
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

<button onclick="openModal()">Add Volunteer</button>

<!-- The Modal -->
<div id="volunteerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
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
    </div>
</div>


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
