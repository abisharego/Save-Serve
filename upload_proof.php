<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["distribution_id"]) && isset($_FILES["proof_image"])) {
    $distribution_id = $_POST["distribution_id"];
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["proof_image"]["name"]);
    move_uploaded_file($_FILES["proof_image"]["tmp_name"], $target_file);

    $sql = "UPDATE food_distributions SET proof_image = ?, status = 'Completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $target_file, $distribution_id);

    if ($stmt->execute()) {
        echo "Proof uploaded successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
