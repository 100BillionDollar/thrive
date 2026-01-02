<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

require_once '../config/database.php';
require_once 'dashboard.php';

$dashboard = new Dashboard($conn);

$method = $_SERVER['REQUEST_METHOD'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {

    /* ================== SUBSCRIBERS ================== */
    case 'get_subscribers':
        if ($method === 'GET') getSubscribers($conn);
        break;

    case 'delete_subscriber':
        if ($method === 'DELETE') deleteSubscriber($conn);
        break;

    /* ================== ANALYTICS ================== */
    case 'get_analytics':
        if ($method === 'GET') getAnalytics($dashboard, $conn);
        break;

    /* ================== BANNERS ================== */
    case 'add_banner':
        if ($method === 'POST') addBanner($dashboard);
        break;

    case 'update_banner':
        if ($method === 'POST') updateBanner($dashboard);
        break;

    case 'delete_banner':
        if ($method === 'DELETE') deleteBannerItem($conn);
        break;

    /* ================== ECOSYSTEM ================== */
    case 'get_ecosystem':
        if ($method === 'GET') getEcosystemItems($conn);
        break;

    case 'add_ecosystem':
        if ($method === 'POST') saveEcosystemItem($conn);
        break;

    case 'update_ecosystem':
        if ($method === 'POST') saveEcosystemItem($conn);
        break;

    case 'delete_ecosystem':
        if ($method === 'DELETE') deleteEcosystemItem($conn);
        break;

    /* ================== WHOWEARE ================== */
    case 'get_whoweare':
        if ($method === 'GET') getWhoweareItems($conn);
        break;

    case 'add_whoweare':
        if ($method === 'POST') saveWhoweareItem($conn);
        break;

    case 'update_whoweare':
        if ($method === 'POST') saveWhoweareItem($conn);
        break;

    case 'delete_whoweare':
        if ($method === 'DELETE') deleteWhoweareItem($conn);
        break;

    /* ================== NOTIFICATIONS ================== */
    case 'mark_notification_read':
        if ($method === 'POST') markNotificationRead($dashboard);
        break;

    case 'mark_all_notifications_read':
        if ($method === 'POST') markAllNotificationsRead($dashboard);
        break;

    case 'remove_notification':
        if ($method === 'POST') removeNotification($dashboard);
        break;

    case 'get_unread_count':
        if ($method === 'POST') getUnreadCount($dashboard);
        break;

    /* ================== SETTINGS ================== */
    case 'save_settings':
        if ($method === 'POST') saveSettings($dashboard);
        break;

    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Action not found']);
}

/* ================== FUNCTIONS ================== */

function addBanner($dashboard) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['title'], $input['image_path'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Title and image path required']);
        return;
    }

    echo json_encode(
        $dashboard->addBanner(
            $input['title'],
            $input['content'] ?? '',
            $input['image_path'],
            intval($input['position'] ?? 1)
        )
    );
}

// function updateBanner($dashboard) {
//     $input = json_decode(file_get_contents('php://input'), true);

//     if (!isset($input['id'], $input['title'], $input['image_path'])) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'ID, title and image path required']);
//         return;
//     }

//     echo json_encode(
//         $dashboard->updateBanner(
//             $input['id'],
//             $input['title'],
//             $input['content'] ?? '',
//             $input['image_path'],
//             $input['position']
//         )
//     );
// }




function updateBanner($dashboard)
{
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id'], $input['title'], $input['image_path'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID, title and image path required'
        ]);
        return;
    }

    echo json_encode(
        $dashboard->updateBanner(
            (int)$input['id'],                 
            trim($input['title']),              
            $input['content'] ?? '',            
            $input['image_path'],             
            (int)($input['position'] ?? 1)     
        )
    );
}

function deleteBannerItem($conn) {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid banner ID']);
        return;
    }

    $stmt = $conn->prepare("UPDATE banner SET status='inactive' WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Banner deleted']);
}

function getSubscribers($conn) {
    $result = $conn->query("SELECT * FROM newsletter_subscribers ORDER BY created_at DESC");
    echo json_encode(['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)]);
}

function deleteSubscriber($conn) {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM newsletter_subscribers WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
}

function getAnalytics($dashboard, $conn) {
    echo json_encode(['success' => true, 'data' => $dashboard->getAnalytics()]);
}

function getEcosystemItems($conn) {
    $result = $conn->query("SELECT * FROM ecosystem ORDER BY sort_order");
    echo json_encode(['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)]);
}

function saveEcosystemItem($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['name']) || empty($input['description'])) {
        echo json_encode(['success' => false, 'message' => 'Name & description required']);
        return;
    }

    if (!empty($input['id'])) {
        $stmt = $conn->prepare("UPDATE ecosystem SET name=?, description=?, image_path=?, status=?, sort_order=? WHERE id=?");
        $stmt->bind_param(
            "ssssii",
            $input['name'],
            $input['description'],
            $input['image_path'],
            $input['status'],
            $input['sort_order'],
            $input['id']
        );
    } else {
        $stmt = $conn->prepare("INSERT INTO ecosystem (name, description, image_path, status, sort_order) VALUES (?,?,?,?,?)");
        $stmt->bind_param(
            "ssssi",
            $input['name'],
            $input['description'],
            $input['image_path'],
            $input['status'],
            $input['sort_order']
        );
    }

    $stmt->execute();
    echo json_encode(['success' => true]);
}

function deleteEcosystemItem($conn) {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM ecosystem WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
}

function getWhoweareItems($conn) {
    $result = $conn->query("SELECT * FROM who_we_are ORDER BY id");
    echo json_encode(['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)]);
}

function saveWhoweareItem($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['name']) || empty($input['image_path'])) {
        echo json_encode(['success' => false, 'message' => 'Name & image required']);
        return;
    }

    if (!empty($input['id'])) {
        $stmt = $conn->prepare("UPDATE who_we_are SET title=?, content=?, image_path=?, status=? WHERE id=?");
        $stmt->bind_param(
            "ssssi",
            $input['name'],
            $input['content'],
            $input['image_path'],
            $input['status'],
            $input['id']
        );
    } else {
        $stmt = $conn->prepare("INSERT INTO who_we_are (title, content, image_path, status) VALUES (?,?,?,?)");
        $stmt->bind_param(
            "ssss",
            $input['name'],
            $input['content'],
            $input['image_path'],
            $input['status']
        );
    }

    $stmt->execute();
    echo json_encode(['success' => true]);
}

function deleteWhoweareItem($conn) {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM who_we_are WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
}

function markNotificationRead($dashboard) {
    $id = intval($_POST['notification_id'] ?? 0);
    echo json_encode(['success' => $dashboard->markNotificationAsRead($id)]);
}

function markAllNotificationsRead($dashboard) {
    echo json_encode(['success' => $dashboard->markAllNotificationsAsRead()]);
}

function removeNotification($dashboard) {
    require_once 'notifications.php';
    $manager = new NotificationManager($dashboard->conn);
    echo json_encode(['success' => $manager->deleteNotification(intval($_POST['notification_id']))]);
}

function getUnreadCount($dashboard) {
    echo json_encode(['success' => true, 'count' => $dashboard->getUnreadNotificationCount()]);
}

function saveSettings($dashboard) {
    $input = json_decode(file_get_contents('php://input'), true);

    $settings = [
        'admin_email' => $input['admin_email'] ?? '',
        'site_title' => $input['site_title'] ?? '',
        'ecosystem_heading' => $input['ecosystem_heading'] ?? '',
        'maintenance_mode' => isset($input['maintenance_mode']) ? '1' : '0'
    ];

    foreach ($settings as $key => $value) {
        $stmt = $dashboard->getConn()->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->bind_param("sss", $key, $value, $value);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['success' => true, 'message' => 'Settings saved successfully']);
}
