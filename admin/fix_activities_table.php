<?php
require_once 'config/database.php';

// Check if description column exists in activities table
$result = $conn->query("DESCRIBE activities");
$hasDescription = false;

while ($row = $result->fetch_assoc()) {
    if ($row['Field'] === 'description') {
        $hasDescription = true;
        break;
    }
}

if (!$hasDescription) {
    // Add description column
    $conn->query("ALTER TABLE activities ADD COLUMN description TEXT AFTER activity");
    echo "Description column added to activities table\n";
} else {
    echo "Description column already exists\n";
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
