<head>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* General Styling */
body {
    font-family: Arial, sans-serif;
    background: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Centered Container */
form {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 320px;
    text-align: center;
}

/* Heading */
h2 {
    margin-bottom: 15px;
    color: #333;
    padding: 20px;
}

/* Labels */
label {
    font-weight: bold;
    display: block;
    text-align: left;
    margin-bottom: 5px;
    color: #555;
}

/* Input Fields */
input[type="email"], 
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* Button */
button {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s ease-in-out;
}

button:hover {
    background: #218838;
}

/* Registration Links */
.register-link {
    font-size: 14px;
    color: #555;
}

.plain-link {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

.plain-link:hover {
    text-decoration: underline;
}

    </style>
</head>
<h2>Login</h2>
<form action="login_process.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Login</button>
    <br><br><p class="register-link">Want to donate food? <a href="donate_food.php" class="plain-link">Register here!</a><br><br>Want to distribute it to people? <a href="register_receiver.php" class="plain-link">Register Here!</a></p>
</form>
