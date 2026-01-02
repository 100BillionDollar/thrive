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
    getEcosystem($conn);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

function getEcosystem($conn) {
    $sql = "SELECT id, name, description, image_path, image_path FROM ecosystem WHERE status = 'active' ORDER BY sort_order";
    $result = $conn->query($sql);

    if ($result) {
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
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