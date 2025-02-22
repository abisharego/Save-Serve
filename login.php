<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        h2{
            padding:10px;
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
    <br><br><p class="register-link">New to the site? <a href="register.php" class="plain-link">Register here!</a></p>
</form>
