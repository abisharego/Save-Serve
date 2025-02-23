<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save & Serve Survey</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input, select, textarea { width: 100%; margin: 8px 0; padding: 10px; }
        button { background-color: #28a745; color: white; padding: 10px; border: none; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<h2>Save & Serve - Food Donation Survey</h2>
<form action="submit_survey.php" method="POST">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Role:</label>
    <select name="role" required>
        <option value="Donor">Donor</option>
        <option value="NGO">NGO</option>
        <option value="Volunteer">Volunteer</option>
    </select>

    <label>How often do you donate/collect food?</label>
    <select name="donation_frequency" required>
        <option value="Daily">Daily</option>
        <option value="Weekly">Weekly</option>
        <option value="Monthly">Monthly</option>
    </select>

    <label>What challenges do you face in food distribution?</label>
    <textarea name="challenges" rows="3"></textarea>

    <label>Preferred Pickup Time:</label>
    <input type="time" name="preferred_pickup_time">

    <label>Contact Information (Email or Phone):</label>
    <input type="text" name="contact" required>

    <button type="submit">Submit Survey</button>
</form>

</body>
</html>
