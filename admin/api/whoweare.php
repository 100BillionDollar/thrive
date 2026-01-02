<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    getWhoweare($conn);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

function getWhoweare($conn) {
    $sql = "SELECT id, title, content, image_path FROM who_we_are WHERE status = 1 ORDER BY id";
    $result = $conn->query($sql);

    if ($result) {
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'content' => $row['content'],
                'image_path' => $row['image_path']
            ];
        }
        echo json_encode(['success' => true, 'data' => $items]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}
?>