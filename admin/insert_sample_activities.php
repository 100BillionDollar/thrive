<?php
require_once 'config/database.php';

// Insert sample activities one by one
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
