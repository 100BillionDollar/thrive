-- Notifications table
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Activities table for recent activity tracking
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('user', 'admin', 'system', 'newsletter') DEFAULT 'system',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample notifications
INSERT INTO notifications (title, message, type) VALUES
('Welcome to Thrive Admin', 'You have successfully logged into the admin dashboard.', 'success'),
('New Newsletter Subscriber', 'A new user has subscribed to your newsletter.', 'info'),
('System Update', 'The system has been updated to the latest version.', 'warning');

-- Insert some sample activities
INSERT INTO activities (activity, description, type) VALUES
('Admin Login', 'Administrator logged into the dashboard', 'admin'),
('New Subscriber', 'New newsletter subscription received', 'newsletter'),
('Content Updated', 'Who We Are section was updated', 'admin'),
('System Check', 'Daily system health check completed', 'system');
