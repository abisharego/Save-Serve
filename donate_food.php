<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Food | Save & Serve</title>
    <style>
        /* General Page Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    text-align: center;
    padding: 50px;
    background-image: url('images/5.jpg');
    background-size: cover;
}

/* Centered Content Box */
.container {
    background: white;
    padding: 40px;
    width: 30%;
    margin: auto;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Heading */
h2 {
    font-size: 28px;
    margin-bottom: 10px;
    color: #2c3e50;
}

/* Buttons */
.options {
    margin-top: 20px;
}

.btn {
    display: block;
    background: #4CAF50;
    color: white;
    padding: 15px;
    margin: 10px auto;
    width: 80%;
    text-align: center;
    font-size: 18px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s ease-in-out;
}

.btn:hover {
    background: #367c39;
}

    </style>
</head>
<body>

    <div class="container">
        <h2>Donate Food</h2>
        <p>Choose how you'd like to donate:</p>
        
        <div class="options">
            <a href="register_individual.php" class="btn">Donate as Individual</a>
            <a href="register_restaurant.php" class="btn">Donate as Restaurant</a>
        </div>
    </div>

</body>
</html>
