<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode([
        'status' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => 'No file uploaded'
    ]);
    exit;
}

$file = $_FILES['file'];

// Allowed file types
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => 'Invalid file type'
    ]);
    exit;
}

// Max size: 5MB
if ($file['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => 'File too large (Max 5MB)'
    ]);
    exit;
}

// Upload directory
$uploadDir = '../assets/images/uploadEcosystem/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename  = uniqid('banner_', true) . '.' . $extension;
$filepath  = $uploadDir . $filename;
$imagePath = 'assets/images/uploads/' . $filename;

// Move file
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    echo json_encode([
        'status'     => true,
        'message'    => 'Upload successful',
        'image_name' => $filename,
        'image_path' => $imagePath
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'message' => 'Failed to upload file'
    ]);
}
?>
