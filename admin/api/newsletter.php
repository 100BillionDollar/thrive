<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';
require_once 'dashboard.php';

$dashboard = new Dashboard($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle newsletter subscription
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['email']) || !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Valid email is required']);
        exit;
    }
    
    $email = $input['email'];
    $result = $dashboard->addNewsletterSubscriber($email);
    
    echo json_encode($result);
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get newsletter statistics
    $sql = "SELECT COUNT(*) as total_subscribers, 
                   COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as weekly_new,
                   COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as monthly_new
            FROM newsletter_subscribers WHERE status = 'active'";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $stats = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $stats]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch statistics']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
