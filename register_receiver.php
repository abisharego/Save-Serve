<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Distribution Registration</title>
    <style>
        h2{
            padding:10px;
        }
        /* Style the select dropdown */
select {
    background-color: white;
    color: #333;
    outline: none;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    width: 90%;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
}

/* Hover effect */
select:hover {
    border-color: #367c39;
}

/* Focus effect */
select:focus {
    border-color: #2c3e50;
    box-shadow: 0px 0px 5px rgba(76, 175, 80, 0.5);
}

/* Style the dropdown options */
option {
    padding: 10px;
    font-size: 16px;
    background-color: white;
    color: #333;
}

    </style>
</head>
<body>

    <h2>Distribution Registration</h2>
    <form action="register_receiver_process.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Phone Number:</label>
        <input type="text" name="phone" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Are you an NGO or Individual?</label>
        <select name="role">
            <option value="NGO">NGO</option>
            <option value="Individual">Individual</option>
        </select><br>

        <button type="submit">Register</button>
    </form>

</body>
</html>
