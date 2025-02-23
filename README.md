# Save & Serve – A Smarter Approach to Tackling Food Waste and Hunger

## Overview  
Save & Serve is a platform designed to minimize food waste by efficiently connecting food providers with those in need. It enables **real-time food listings**, where surplus food is listed and matched with nearby NGOs and volunteers using **AI-powered smart matching**. The notifications ensure timely pickups and efficient food distribution.  

## Key Features  
- ✅ **Real-Time Food Listings** – Food providers can list surplus food with details like quantity, and pickup time.  
- ✅ **AI-Powered NGO & Volunteer Matching** – Smart algorithms connect food sources with the nearest NGOs based on demand and location.  
- ✅ **Live Tracking & Notifications** – Ensures quick response times and reduces delays in food pickup.  
- ✅ **QR-Based Pickup Verification** – Enhances transparency and accountability in the distribution process.   
- ✅ **Impact Tracker** – Displays real-time data on meals saved, food waste reduced, and people fed.  

## How It Works  
1. **Food providers** list surplus food with details like availability and pickup time.  
2. **NGOs & volunteers** receive real-time notifications when food is available.  
3. **Matching algorithm** pairs food providers with the nearest NGOs based on demand.  
4. **Pickup & distribution** are verified using QR codes for accountability.   

## Impact & Sustainability  
Save & Serve aligns with the **United Nations Sustainable Development Goals (SDGs)**:  
- 🌍 **SDG #2 – Zero Hunger:** Ensures surplus food reaches those in need.  
- 🌿 **SDG #12 – Responsible Consumption & Production:** Reduces food waste and promotes sustainability.  

By efficiently redistributing excess food, **Save & Serve** helps combat food insecurity while reducing waste, making a tangible impact on society.

## 🚀 Installation Guide  

### 1️⃣ Start Apache & MySQL  
- Open **XAMPP Control Panel**  
- Start **Apache** and **MySQL**  

### 2️⃣ Download & Extract the Project  
- Download the zip file
- Extract the zip file folder into: C:\xampp\htdocs\save&serve

### 3️⃣ Import the Database
- Open phpMyAdmin (http://localhost/phpmyadmin/)
- Create a database: save&serve
- Import `save&serve.sql` from the project folder

### 4️⃣ Configure Database Connection  
- Open `db.php` and update the database credentials if needed:  

```php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "save&serve";
```

### 5️⃣ Run the Application
- Open a browser and visit: http://localhost/save&serve

---

### 📜 License  
This project is open-source and available under the [MIT License](LICENSE).
