<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Restaurant Registration</title>
    <style>
        h2{
            padding:10px;
        }
    </style>
</head>
<body>

    <h2>Restaurant Registration</h2>
    <form action="register_restaurant_process.php" method="POST">
    <label for="restaurant_name">Restaurant Name:</label>
    <input type="text" name="restaurant_name" required><br>

    <label for="manager_name">Manager Name:</label>
    <input type="text" name="manager_name" required><br>

    <label for="phone">Phone Number:</label>
    <input type="text" name="phone" required><br>

    <label for="location">Location:</label>
    <input type="text" name="location" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Register</button>
</form>


</body>
</html>
