<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Individual Registration</title>
    <style>
        h2{
            padding:10px;
            color: white;
            text-shadow: 10px 10px 30px rgba(0, 0, 0, 0.2);
            text-style: italic;
        }
        body{
            background-image:url("images/7.jpg");
        }
    </style>
</head>
<body>

    <h2>Individual Registration</h2>
    <form action="register_individual_process.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Phone Number:</label>
        <input type="text" name="phone" required><br>

        <label>Location:</label>
        <input type="text" name="location" required><br>

        <label>Food Type:</label>
        <input type="text" name="food_type" required><br>

        <label>Quantity:</label>
        <input type="text" name="quantity" required><br>

        <button type="submit">Register</button>
    </form>

</body>
</html>
