CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    user_type ENUM('Individual', 'Restaurant', 'NGO', 'Volunteer') NOT NULL,
    location TEXT NOT NULL,
    restaurant_name VARCHAR(100),
    manager_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Food Posts Table (For Donations)
CREATE TABLE food_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    food_type VARCHAR(100) NOT NULL,
    quantity VARCHAR(50) NOT NULL,
    location TEXT NOT NULL,
    status ENUM('Available', 'Claimed', 'Delivered') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Orders Table (For Food Distribution)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_id INT NOT NULL,
    receiver_id INT NOT NULL,
    status ENUM('Pending', 'Picked Up', 'Delivered') DEFAULT 'Pending',
    qr_code VARCHAR(255),
    proof_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (food_id) REFERENCES food_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE food_distributions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_id INT NOT NULL,
    ngo_id INT NOT NULL,
    volunteer_id INT NOT NULL,
    food_type VARCHAR(255) NOT NULL,
    quantity VARCHAR(100) NOT NULL,
    collected_by VARCHAR(255) NOT NULL,
    distribution_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    proof_image VARCHAR(255) NULL,
    FOREIGN KEY (food_id) REFERENCES food_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (ngo_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE survey_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role ENUM('Donor', 'NGO', 'Volunteer') NOT NULL,
    donation_frequency ENUM('Daily', 'Weekly', 'Monthly') NOT NULL,
    challenges TEXT,
    preferred_pickup_time TIME,
    contact VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
