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
    getBanners($conn);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

function getBanners($conn) {
    $sql = "SELECT id, title, content, image_path, position FROM banner WHERE status = 'active' ORDER BY position ASC";
    $result = $conn->query($sql);

    if ($result) {
        $banners = [];
        while ($row = $result->fetch_assoc()) {
            $banners[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'content' => $row['content'],
                'image_path' => $row['image_path'],
                'position' => $row['position']
            ];
        }
        echo json_encode(['success' => true, 'data' => $banners]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}
?>