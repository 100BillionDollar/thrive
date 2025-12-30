<?php
require_once 'config/database.php';

// Create notifications table
$createNotificationsTable = "
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Create activities table
$createActivitiesTable = "
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('user', 'admin', 'system', 'newsletter') DEFAULT 'system',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute table creation
if ($conn->query($createNotificationsTable)) {
    echo "Notifications table created successfully\n";
} else {
    echo "Error creating notifications table: " . $conn->error . "\n";
}

if ($conn->query($createActivitiesTable)) {
    echo "Activities table created successfully\n";
} else {
    echo "Error creating activities table: " . $conn->error . "\n";
}

// Insert sample notifications
$insertNotifications = "INSERT INTO notifications (title, message, type) VALUES ('Welcome to Thrive Admin', 'You have successfully logged into the admin dashboard.', 'success'), ('New Newsletter Subscriber', 'A new user has subscribed to your newsletter.', 'info'), ('System Update', 'The system has been updated to the latest version.', 'warning') ON DUPLICATE KEY UPDATE title=VALUES(title), message=VALUES(message), type=VALUES(type)";

if ($conn->query($insertNotifications)) {
    echo "Sample notifications inserted successfully\n";
} else {
    echo "Error inserting notifications: " . $conn->error . "\n";
}

echo "Database setup completed!\n";
?>
