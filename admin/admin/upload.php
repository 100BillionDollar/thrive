<?php
session_start();
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo 'Unauthorized';
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['file'])) {
    http_response_code(400);
    echo 'No file uploaded';
    exit;
}

$file = $_FILES['file'];

// Validate file type
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.';
    exit;
}

// Validate file size (5MB max)
if ($file['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    echo 'File too large. Maximum size is 5MB.';
    exit;
}

// Create uploads directory if it doesn't exist
$uploadDir = '../assets/images/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('banner_', true) . '.' . $extension;
$filepath = $uploadDir . $filename;

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    // Save to database
    try {
        $stmt = $conn->prepare("INSERT INTO banner (title, content, image_path, created_at) VALUES (?, ?, ?, NOW())");
        $title = 'New Banner'; // Default title
        $content = ''; // Default content
        $imagePath = 'assets/images/uploads/' . $filename;
        
        $stmt->bind_param("sss", $title, $content, $imagePath);
        $stmt->execute();
        
        echo 'Upload successful';
    } catch (Exception $e) {
        // Delete the uploaded file if database insert fails
        unlink($filepath);
        http_response_code(500);
        echo 'Database error: ' . $e->getMessage();
    }
} else {
    http_response_code(500);
    echo 'Failed to save file';
}
?>