<?php
require_once 'config/database.php';

// Drop and recreate activities table with proper structure
$conn->query("DROP TABLE IF EXISTS activities");

$createActivitiesTable = "
CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('user', 'admin', 'system', 'newsletter') DEFAULT 'system',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($createActivitiesTable)) {
    echo "Activities table recreated successfully\n";
} else {
    echo "Error creating activities table: " . $conn->error . "\n";
}

// Insert sample activities
$activities = [
    ['Admin Login', 'Administrator logged into the dashboard', 'admin'],
    ['New Subscriber', 'New newsletter subscription received', 'newsletter'],
    ['Content Updated', 'Who We Are section was updated', 'admin'],
    ['System Check', 'Daily system health check completed', 'system']
];

foreach ($activities as $activity) {
    $stmt = $conn->prepare("INSERT INTO activities (activity, description, type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $activity[0], $activity[1], $activity[2]);
    $stmt->execute();
}

echo "Sample activities inserted successfully!\n";
?>
