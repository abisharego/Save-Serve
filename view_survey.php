<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$database = "save&serve";  

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM survey_responses ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Responses</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #28a745; color: white; }
    </style>
</head>
<body>

<h2>Survey Responses</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Role</th>
        <th>Donation Frequency</th>
        <th>Challenges</th>
        <th>Preferred Pickup Time</th>
        <th>Contact</th>
        <th>Timestamp</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['donation_frequency'] ?></td>
            <td><?= $row['challenges'] ?></td>
            <td><?= $row['preferred_pickup_time'] ?></td>
            <td><?= $row['contact'] ?></td>
            <td><?= $row['timestamp'] ?></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>

<?php
$conn->close();
?>
