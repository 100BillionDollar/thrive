<?php
class NotificationManager {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    // Create a new notification
    public function createNotification($title, $message, $type = 'info') {
        $stmt = $this->conn->prepare("INSERT INTO notifications (title, message, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $message, $type);
        return $stmt->execute();
    }
    
    // Get all notifications
    public function getNotifications($limit = 10, $unread_only = false) {
        $sql = "SELECT * FROM notifications";
        if ($unread_only) {
            $sql .= " WHERE is_read = FALSE";
        }
        $sql .= " ORDER BY created_at DESC LIMIT ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    // Mark notification as read
    public function markAsRead($notification_id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = TRUE WHERE id = ?");
        $stmt->bind_param("i", $notification_id);
        return $stmt->execute();
    }
    
    // Mark all notifications as read
    public function markAllAsRead() {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = TRUE WHERE is_read = FALSE");
        return $stmt->execute();
    }
    
    // Get unread count
    public function getUnreadCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM notifications WHERE is_read = FALSE");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }
    
    // Delete notification
    public function deleteNotification($notification_id) {
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $notification_id);
        return $stmt->execute();
    }
}

class ActivityManager {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    // Log a new activity
    public function logActivity($activity, $description = '', $type = 'system') {
        $stmt = $this->conn->prepare("INSERT INTO activities (activity, description, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $activity, $description, $type);
        return $stmt->execute();
    }
    
    // Get recent activities
    public function getRecentActivities($limit = 10) {
        $stmt = $this->conn->prepare("SELECT * FROM activities ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get activities by type
    public function getActivitiesByType($type, $limit = 10) {
        $stmt = $this->conn->prepare("SELECT * FROM activities WHERE type = ? ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("si", $type, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    // Clean old activities (older than specified days)
    public function cleanOldActivities($days = 30) {
        $stmt = $this->conn->prepare("DELETE FROM activities WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)");
        $stmt->bind_param("i", $days);
        return $stmt->execute();
    }
}
?>
