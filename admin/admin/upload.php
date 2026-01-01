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
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['file'];

// Validate file type
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.']);
    exit;
}

// Validate file size (5MB max)
if ($file['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 5MB.']);
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
    $imagePath = 'assets/images/uploads/' . $filename;
    
    // Check if this is just an upload or full banner creation
    $action = $_POST['action'] ?? 'create_banner';
    
    if ($action === 'upload_only') {
        // Just return the image path
        echo json_encode(['success' => true, 'image_path' => $imagePath]);
    } else {
        // Save to database (original behavior)
        try {
            $stmt = $conn->prepare("INSERT INTO banner (title, content, image_path, created_at) VALUES (?, ?, ?, NOW())");
            $title = 'New Banner'; // Default title
            $content = ''; // Default content
            
            $stmt->bind_param("sss", $title, $content, $imagePath);
            $stmt->execute();
            
            echo json_encode(['success' => true, 'message' => 'Upload successful', 'image_path' => $imagePath]);
        } catch (Exception $e) {
            // Delete the uploaded file if database insert fails
            unlink($filepath);
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
}
?>