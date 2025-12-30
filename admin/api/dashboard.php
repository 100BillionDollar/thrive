<?php
require_once 'notifications.php';

class Dashboard {
    private $conn;
    private $notificationManager;
    private $activityManager;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->notificationManager = new NotificationManager($conn);
        $this->activityManager = new ActivityManager($conn);
    }

    public function getDashboardData() {
        $data = [];
        
        // Get Who We Are data
        $data['who_we_are'] = $this->getWhoWeAreData();
        
        // Get banner data
        $data['banners'] = $this->getBannerData();
        
        // Get ecosystem data
        $data['ecosystem'] = $this->getEcosystemData();
        
        // Get newsletter subscribers count
        $data['newsletter_count'] = $this->getNewsletterCount();
        
        // Get recent activities
        $data['recent_activities'] = $this->activityManager->getRecentActivities(5);
        
        // Get notifications
        $data['notifications'] = $this->notificationManager->getNotifications(5);
        $data['unread_notifications'] = $this->notificationManager->getUnreadCount();
        
        return $data;
    }

    private function getWhoWeAreData() {
        $sql = "SELECT title, content, image_path FROM who_we_are WHERE status = 'active' LIMIT 1";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return [
            'title' => 'Building Tomorrow\'s Solutions Today',
            'content' => 'We are a team of passionate professionals dedicated to creating innovative solutions that transform businesses and improve lives.',
            'image_path' => 'assets/images/who-we-are.jpg'
        ];
    }

    private function getBannerData() {
        $sql = "SELECT * FROM banner WHERE status = 'active' ORDER BY position ASC";
        $result = $this->conn->query($sql);
        
        $banners = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $banners[] = $row;
            }
        }
        
        return $banners;
    }

    private function getEcosystemData() {
        $sql = "SELECT * FROM ecosystem WHERE status = 'active' ORDER BY id ASC";
        $result = $this->conn->query($sql);
        
        $ecosystem = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $ecosystem[] = $row;
            }
        }
        
        return $ecosystem;
    }

    private function getNewsletterCount() {
        $sql = "SELECT COUNT(*) as count FROM newsletter_subscribers WHERE status = 'active'";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        
        return 0;
    }

    private function getRecentActivities() {
        return $this->activityManager->getRecentActivities(5);
    }

    public function addNewsletterSubscriber($email) {
        // Check if email already exists
        $check_sql = "SELECT id FROM newsletter_subscribers WHERE email = ?";
        $stmt = $this->conn->prepare($check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return ['success' => false, 'message' => 'Email already subscribed!'];
        }
        
        // Insert new subscriber
        $sql = "INSERT INTO newsletter_subscribers (email, status, created_at) VALUES (?, 'active', NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            // Log activity
            $this->activityManager->logActivity("New newsletter subscription: " . $email, "New user subscribed to newsletter", "newsletter");
            
            // Create notification
            $this->notificationManager->createNotification(
                "New Newsletter Subscriber", 
                "A new user has subscribed to your newsletter.", 
                "info"
            );
            
            return ['success' => true, 'message' => 'Successfully subscribed!'];
        } else {
            return ['success' => false, 'message' => 'Subscription failed. Please try again.'];
        }
    }

    public function updateWhoWeAre($title, $content, $image_path = null) {
        $sql = "UPDATE who_we_are SET title = ?, content = ?";
        $params = "ss";
        $bind_params = [$title, $content];
        
        if ($image_path) {
            $sql .= ", image_path = ?";
            $params .= "s";
            $bind_params[] = $image_path;
        }
        
        $sql .= ", updated_at = NOW() WHERE id = 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($params, ...$bind_params);
        
        if ($stmt->execute()) {
            $this->activityManager->logActivity("Who We Are section updated", "Content was modified in Who We Are section", "admin");
            
            $this->notificationManager->createNotification(
                "Content Updated", 
                "Who We Are section has been updated.", 
                "success"
            );
            
            return ['success' => true, 'message' => 'Updated successfully!'];
        } else {
            return ['success' => false, 'message' => 'Update failed!'];
        }
    }

    // Banner management methods
    public function addBanner($title, $content, $image_path, $position) {
        $sql = "INSERT INTO banner (title, content, image_path, position, status) VALUES (?, ?, ?, ?, 'active')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $content, $image_path, $position);
        
        if ($stmt->execute()) {
            $this->activityManager->logActivity("New banner added: " . $title, "Banner item was added", "admin");
            return ['success' => true, 'message' => 'Banner added successfully!'];
        } else {
            return ['success' => false, 'message' => 'Failed to add banner!'];
        }
    }

    public function updateBanner($id, $title, $content, $image_path = null, $position = null) {
        $sql = "UPDATE banner SET title = ?, content = ?";
        $params = "si";
        $bind_params = [$title, $id];
        
        if ($image_path) {
            $sql .= ", image_path = ?";
            $params .= "s";
            array_unshift($bind_params, $image_path);
        }
        
        if ($position !== null) {
            $sql .= ", position = ?";
            $params .= "i";
            if ($image_path) {
                $bind_params[] = $position;
            } else {
                array_unshift($bind_params, $position);
            }
        }
        
        $sql .= ", updated_at = NOW() WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($params, ...$bind_params);
        
        if ($stmt->execute()) {
            $this->activityManager->logActivity("Banner updated: " . $title, "Banner item was modified", "admin");
            return ['success' => true, 'message' => 'Banner updated successfully!'];
        } else {
            return ['success' => false, 'message' => 'Failed to update banner!'];
        }
    }

    public function deleteBanner($id) {
        $sql = "UPDATE banner SET status = 'inactive' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $this->activityManager->logActivity("Banner deleted", "Banner item was removed", "admin");
            return ['success' => true, 'message' => 'Banner deleted successfully!'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete banner!'];
        }
    }

    // Ecosystem management methods
    public function addEcosystemItem($name, $description, $icon) {
        $sql = "INSERT INTO ecosystem (name, description, icon, status) VALUES (?, ?, ?, 'active')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $name, $description, $icon);
        
        if ($stmt->execute()) {
            $this->activityManager->logActivity("New ecosystem item added: " . $name, "Ecosystem item was added", "admin");
            return ['success' => true, 'message' => 'Ecosystem item added successfully!'];
        } else {
            return ['success' => false, 'message' => 'Failed to add ecosystem item!'];
        }
    }

    public function updateEcosystemItem($id, $name, $description, $icon) {
        $sql = "UPDATE ecosystem SET name = ?, description = ?, icon = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $description, $icon, $id);
        
        if ($stmt->execute()) {
            $this->activityManager->logActivity("Ecosystem item updated: " . $name, "Ecosystem item was modified", "admin");
            return ['success' => true, 'message' => 'Ecosystem item updated successfully!'];
        } else {
            return ['success' => false, 'message' => 'Failed to update ecosystem item!'];
        }
    }

    public function deleteEcosystemItem($id) {
        $sql = "UPDATE ecosystem SET status = 'inactive' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $this->activityManager->logActivity("Ecosystem item deleted", "Ecosystem item was removed", "admin");
            return ['success' => true, 'message' => 'Ecosystem item deleted successfully!'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete ecosystem item!'];
        }
    }

    // Notification methods
    public function getNotifications($limit = 10, $unread_only = false) {
        return $this->notificationManager->getNotifications($limit, $unread_only);
    }

    public function markNotificationAsRead($notification_id) {
        return $this->notificationManager->markAsRead($notification_id);
    }

    public function markAllNotificationsAsRead() {
        return $this->notificationManager->markAllAsRead();
    }

    public function getUnreadNotificationCount() {
        return $this->notificationManager->getUnreadCount();
    }

    public function createNotification($title, $message, $type = 'info') {
        return $this->notificationManager->createNotification($title, $message, $type);
    }

    // Activity methods
    public function logActivity($activity, $description = '', $type = 'system') {
        return $this->activityManager->logActivity($activity, $description, $type);
    }

    public function getAnalytics() {
        $analytics = [];
        
        // Get visitor stats (example)
        $analytics['total_visitors'] = $this->getTotalVisitors();
        $analytics['newsletter_growth'] = $this->getNewsletterGrowth();
        $analytics['page_views'] = $this->getPageViews();
        
        return $analytics;
    }

    private function getTotalVisitors() {
        $sql = "SELECT COUNT(*) as count FROM visitors WHERE DATE(created_at) = CURDATE()";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        
        return 0;
    }

    private function getNewsletterGrowth() {
        $sql = "SELECT COUNT(*) as count FROM newsletter_subscribers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        
        return 0;
    }

    private function getPageViews() {
        $sql = "SELECT COUNT(*) as count FROM page_views WHERE DATE(created_at) = CURDATE()";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        
        return 0;
    }
}
?>
