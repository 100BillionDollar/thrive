<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Check admin authentication
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

require_once '../config/database.php';
require_once 'dashboard.php';

$dashboard = new Dashboard($conn);

// Get request method and action
$method = $_SERVER['REQUEST_METHOD'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get_subscribers':
        if ($method === 'GET') {
            getSubscribers($conn);
        }
        break;
        
    case 'update_content':
        if ($method === 'POST') {
            updateContent($dashboard);
        }
        break;
        
    case 'delete_subscriber':
        if ($method === 'DELETE') {
            deleteSubscriber($conn);
        }
        break;
        
    case 'get_analytics':
        if ($method === 'GET') {
            getAnalytics($dashboard);
        }
        break;
        
    // Notification actions
    case 'mark_notification_read':
        if ($method === 'POST') {
            markNotificationRead($dashboard);
        }
        break;
        
    case 'mark_all_notifications_read':
        if ($method === 'POST') {
            markAllNotificationsRead($dashboard);
        }
        break;
        
    case 'remove_notification':
        if ($method === 'POST') {
            removeNotification($dashboard);
        }
        break;
        
    case 'get_unread_count':
        if ($method === 'POST') {
            getUnreadCount($dashboard);
        }
        break;
        break;
        
    case 'get_ecosystem':
        if ($method === 'GET') {
            getEcosystemItems($conn);
        }
        break;
        
    case 'save_ecosystem':
        if ($method === 'POST') {
            saveEcosystemItem($conn);
        }
        break;
        
    case 'delete_ecosystem':
        if ($method === 'DELETE') {
            deleteEcosystemItem($conn);
        }
        break;
        
    case 'delete_banner':
        if ($method === 'DELETE') {
            deleteBannerItem($conn);
        }
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Action not found']);
        break;
}

// Get newsletter subscribers
function getSubscribers($conn) {
    $page = max(1, intval($_GET['page'] ?? 1));
    $limit = max(1, intval($_GET['limit'] ?? 10));
    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? '';
    
    $offset = ($page - 1) * $limit;
    
    // Build query
    $whereConditions = [];
    $params = [];
    $types = '';
    
    if (!empty($search)) {
        $whereConditions[] = "email LIKE ?";
        $params[] = "%$search%";
        $types .= 's';
    }
    
    if (!empty($status)) {
        $whereConditions[] = "status = ?";
        $params[] = $status;
        $types .= 's';
    }
    
    $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
    
    // Get total count
    $countSQL = "SELECT COUNT(*) as total FROM newsletter_subscribers $whereClause";
    $stmt = $conn->prepare($countSQL);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];
    
    // Get subscribers
    $sql = "SELECT id, email, status, created_at, updated_at 
            FROM newsletter_subscribers 
            $whereClause 
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($sql);
    $params[] = $limit;
    $params[] = $offset;
    $types .= 'ii';
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $subscribers = [];
    while ($row = $result->fetch_assoc()) {
        $subscribers[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => [
            'subscribers' => $subscribers,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => ceil($total / $limit)
            ]
        ]
    ]);
}

// Update content
function updateContent($dashboard) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['type'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing content type']);
        return;
    }
    
    $type = $input['type'];
    $id = $input['id'] ?? '';
    $title = $input['title'] ?? '';
    $content = $input['content'] ?? '';
    
    $result = ['success' => false, 'message' => 'Invalid content type'];
    
    switch ($type) {
        case 'who_we_are':
            $image_path = $input['image_path'] ?? null;
            $result = $dashboard->updateWhoWeAre($title, $content, $image_path);
            break;
            
        case 'banner':
            $image_path = $input['image_path'] ?? null;
            $position = $input['position'] ?? null;
            if ($id) {
                $result = $dashboard->updateBanner($id, $title, $content, $image_path, $position);
            } else {
                $result = $dashboard->addBanner($title, $content, $image_path, $position ?? 1);
            }
            break;
            
        case 'ecosystem':
            $icon = $input['icon'] ?? 'fa-globe';
            if ($id) {
                $result = $dashboard->updateEcosystemItem($id, $title, $content, $icon);
            } else {
                $result = $dashboard->addEcosystemItem($title, $content, $icon);
            }
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid content type']);
            return;
    }
    
    echo json_encode($result);
}

// Delete subscriber
function deleteSubscriber($conn) {
    $id = intval($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid subscriber ID']);
        return;
    }
    
    $sql = "DELETE FROM newsletter_subscribers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Subscriber deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete subscriber']);
    }
}

// Get analytics data
function getAnalytics($dashboard) {
    $period = $_GET['period'] ?? '7days';
    
    $analytics = $dashboard->getAnalytics();
    
    // Add period-specific data
    switch ($period) {
        case '7days':
            $analytics['visitor_chart'] = getVisitorData($conn, 7);
            $analytics['newsletter_chart'] = getNewsletterGrowthData($conn, 7);
            break;
        case '30days':
            $analytics['visitor_chart'] = getVisitorData($conn, 30);
            $analytics['newsletter_chart'] = getNewsletterGrowthData($conn, 30);
            break;
        case '90days':
            $analytics['visitor_chart'] = getVisitorData($conn, 90);
            $analytics['newsletter_chart'] = getNewsletterGrowthData($conn, 90);
            break;
    }
    
    echo json_encode(['success' => true, 'data' => $analytics]);
}

// Get visitor data for charts
function getVisitorData($conn, $days) {
    $sql = "SELECT DATE(created_at) as date, COUNT(*) as visitors 
            FROM visitors 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY date";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $days);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date' => $row['date'],
            'visitors' => intval($row['visitors'])
        ];
    }
    
    return $data;
}

// Get newsletter growth data
function getNewsletterGrowthData($conn, $days) {
    $sql = "SELECT DATE(created_at) as date, COUNT(*) as subscribers 
            FROM newsletter_subscribers 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY date";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $days);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date' => $row['date'],
            'subscribers' => intval($row['subscribers'])
        ];
    }
    
    return $data;
}

// Get ecosystem items
function getEcosystemItems($conn) {
    // First, create ecosystem table if it doesn't exist
    $createTableSQL = "CREATE TABLE IF NOT EXISTS ecosystem (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        icon VARCHAR(100),
        status ENUM('active', 'inactive') DEFAULT 'active',
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $conn->query($createTableSQL);
    
    // Insert default data if table is empty
    $checkDataSQL = "SELECT COUNT(*) as count FROM ecosystem";
    $result = $conn->query($checkDataSQL);
    if ($result && $result->fetch_assoc()['count'] == 0) {
        $defaultItems = [
            ['Parenting360', 'Comprehensive parenting resources and support', 'fa-baby', 1],
            ['MomsHQ', 'Empowering mothers with knowledge and community', 'fa-heart', 2],
            ['Diyaa', 'Innovative solutions for modern families', 'fa-lightbulb', 3]
        ];
        
        foreach ($defaultItems as $item) {
            $insertSQL = "INSERT INTO ecosystem (name, description, icon, sort_order) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSQL);
            $stmt->bind_param("sssi", $item[0], $item[1], $item[2], $item[3]);
            $stmt->execute();
        }
    }
    
    // Get all ecosystem items
    $sql = "SELECT * FROM ecosystem ORDER BY sort_order, name";
    $result = $conn->query($sql);
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $items]);
}

// Save ecosystem item
function saveEcosystemItem($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['name']) || !isset($input['description'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Name and description required']);
        return;
    }
    
    $id = intval($input['id'] ?? 0);
    $name = $input['name'];
    $description = $input['description'];
    $icon = $input['icon'] ?? 'fa-globe';
    $status = $input['status'] ?? 'active';
    $sortOrder = intval($input['sort_order'] ?? 0);
    
    if ($id > 0) {
        // Update existing item
        $sql = "UPDATE ecosystem SET name = ?, description = ?, icon = ?, status = ?, sort_order = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $name, $description, $icon, $status, $sortOrder, $id);
    } else {
        // Insert new item
        $sql = "INSERT INTO ecosystem (name, description, icon, status, sort_order) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $description, $icon, $status, $sortOrder);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Ecosystem item saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save ecosystem item']);
    }
}

// Delete ecosystem item
function deleteEcosystemItem($conn) {
    $id = intval($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid ecosystem item ID']);
        return;
    }
    
    $sql = "DELETE FROM ecosystem WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Ecosystem item deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete ecosystem item']);
    }
}

// Delete banner item
function deleteBannerItem($conn) {
    $id = intval($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid banner ID']);
        return;
    }
    
    $sql = "UPDATE banner SET status = 'inactive' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Banner deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete banner']);
    }
}

// Notification handler functions
function markNotificationRead($dashboard) {
    $notificationId = intval($_POST['notification_id'] ?? 0);
    
    if ($notificationId <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid notification ID']);
        return;
    }
    
    if ($dashboard->markNotificationAsRead($notificationId)) {
        echo json_encode(['success' => true, 'message' => 'Notification marked as read']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to mark notification as read']);
    }
}

function markAllNotificationsRead($dashboard) {
    if ($dashboard->markAllNotificationsAsRead()) {
        echo json_encode(['success' => true, 'message' => 'All notifications marked as read']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to mark all notifications as read']);
    }
}

function removeNotification($dashboard) {
    $notificationId = intval($_POST['notification_id'] ?? 0);
    
    if ($notificationId <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid notification ID']);
        return;
    }
    
    require_once 'notifications.php';
    $notificationManager = new NotificationManager($dashboard->conn);
    
    if ($notificationManager->deleteNotification($notificationId)) {
        echo json_encode(['success' => true, 'message' => 'Notification removed successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to remove notification']);
    }
}

function getUnreadCount($dashboard) {
    $count = $dashboard->getUnreadNotificationCount();
    echo json_encode(['success' => true, 'count' => $count]);
}
?>
