<?php
session_start();
require_once '../config/database.php';
require_once '../api/dashboard.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Get dashboard data
$dashboard = new Dashboard($conn);
$data = $dashboard->getDashboardData();
$analytics = $dashboard->getAnalytics();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrive Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="../assets/images/logo-white-1.png" width="150" alt="Logo">
                </div>
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list p-0">
                    <li class="nav-item active">
                        <a href="#dashboard" class="nav-link" onclick="showSection('dashboard')">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#content" class="nav-link" onclick="showSection('content')">
                            <i class="fas fa-edit"></i>
                            <span>Content Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#newsletter" class="nav-link" onclick="showSection('newsletter')">
                            <i class="fas fa-envelope"></i>
                            <span>Newsletter</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#ecosystem" class="nav-link" onclick="showSection('ecosystem')">
                            <i class="fas fa-globe"></i>
                            <span>Ecosystem</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#analytics" class="nav-link" onclick="showSection('analytics')">
                            <i class="fas fa-chart-line"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#settings" class="nav-link" onclick="showSection('settings')">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <div class="admin-profile">
                    <div class="profile-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">Admin</div>
                        <div class="profile-role">Administrator</div>
                    </div>
                </div>
                <button class="logout-btn" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h1 class="page-title">Dashboard Overview</h1>
                    <p class="page-subtitle">Welcome back! Here's what's happening with your website.</p>
                </div>
                <div class="header-right">
                    <div class="date-time" id="dateTime"></div>
                    <button class="notification-btn" onclick="toggleNotifications()">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" id="notificationBadge"><?php echo $data['unread_notifications']; ?></span>
                    </button>
                </div>
            </header>

            <!-- Notifications Dropdown -->
            <div id="notificationsDropdown" class="notifications-dropdown">
                <div class="notifications-header">
                    <h4>Notifications</h4>
                    <button class="btn btn-sm btn-outline" onclick="markAllNotificationsAsRead()">Mark all as read</button>
                </div>
                <div class="notifications-list" id="notificationsList">
                    <?php foreach ($data['notifications'] as $notification): ?>
                    <div class="notification-item <?php echo $notification['is_read'] ? 'read' : 'unread'; ?>" data-id="<?php echo $notification['id']; ?>">
                        <div class="notification-icon">
                            <i class="fas fa-<?php echo $notification['type'] === 'success' ? 'check-circle text-success' : 
                                                 ($notification['type'] === 'warning' ? 'exclamation-triangle text-warning' : 
                                                 ($notification['type'] === 'error' ? 'times-circle text-danger' : 'info-circle text-info')); ?>"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title"><?php echo htmlspecialchars($notification['title']); ?></div>
                            <div class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></div>
                            <div class="notification-time"><?php echo date('M j, Y g:i A', strtotime($notification['created_at'])); ?></div>
                        </div>
                        <button class="notification-close" onclick="removeNotification(<?php echo $notification['id']; ?>)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="notifications-footer">
                    <a href="#" class="btn btn-sm btn-primary">View All Notifications</a>
                </div>
            </div>

            <!-- Dashboard Section -->
            <section id="dashboard-section" class="content-section active">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Total Visitors</h3>
                            <div class="stat-number"><?php echo number_format($analytics['total_visitors']); ?></div>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>12% from yesterday</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Newsletter Subscribers</h3>
                            <div class="stat-number"><?php echo number_format($data['newsletter_count']); ?></div>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span><?php echo $analytics['newsletter_growth']; ?> new this month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Page Views</h3>
                            <div class="stat-number"><?php echo number_format($analytics['page_views']); ?></div>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>8% from yesterday</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Growth Rate</h3>
                            <div class="stat-number">24.5%</div>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>3.2% from last week</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Quick Actions -->
                <div class="dashboard-grid">
                    <div class="card">
                        <div class="card-header">
                            <h3>Recent Activity</h3>
                            <button class="btn btn-sm btn-outline">View All</button>
                        </div>
                        <div class="card-content">
                            <div class="activity-list">
                                <?php foreach ($data['recent_activities'] as $activity): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-<?php echo $activity['type'] === 'admin' ? 'user-shield text-primary' : 
                                                             ($activity['type'] === 'newsletter' ? 'envelope text-success' : 
                                                             ($activity['type'] === 'user' ? 'user text-info' : 'cog text-secondary')); ?>"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text"><?php echo htmlspecialchars($activity['activity']); ?></div>
                                        <?php if (!empty($activity['description'])): ?>
                                        <div class="activity-description"><?php echo htmlspecialchars($activity['description']); ?></div>
                                        <?php endif; ?>
                                        <div class="activity-time"><?php echo date('M j, Y g:i A', strtotime($activity['created_at'])); ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3>Quick Actions</h3>
                        </div>
                        <div class="card-content">
                            <div class="quick-actions">
                                <button class="quick-action-btn" onclick="showSection('content')">
                                    <i class="fas fa-plus"></i>
                                    <span>Add New Content</span>
                                </button>
                                <button class="quick-action-btn" onclick="showSection('newsletter')">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Send Newsletter</span>
                                </button>
                                <button class="quick-action-btn" onclick="showSection('ecosystem')">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Add Ecosystem Item</span>
                                </button>
                                <button class="quick-action-btn" onclick="showSection('analytics')">
                                    <i class="fas fa-download"></i>
                                    <span>Export Report</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Content Management Section -->
            <section id="content-section" class="content-section">
                <!-- Who We Are Section -->
                <div class="card">
                    <div class="card-header">
                        <h3>Who We Are Section</h3>
                        <button class="btn btn-primary" onclick="editWhoWeAre()">Edit Content</button>
                    </div>
                    <div class="card-content">
                        <div class="content-preview">
                            <h4 id="whoWeAreTitle"><?php echo htmlspecialchars($data['who_we_are']['title']); ?></h4>
                            <p id="whoWeAreContent"><?php echo htmlspecialchars($data['who_we_are']['content']); ?></p>
                            <?php if (!empty($data['who_we_are']['image_path'])): ?>
                                <div class="content-image">
                                    <img src="../<?php echo htmlspecialchars($data['who_we_are']['image_path']); ?>" alt="Who We Are">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Banner Management -->
                <div class="card">
                    <div class="card-header">
                        <h3>Banner Management</h3>
                        <button class="btn btn-primary" onclick="addBanner()">Add New Banner</button>
                    </div>
                    <div class="card-content">
                        <div class="banner-grid" id="bannerGrid">
                            <?php foreach ($data['banners'] as $banner): ?>
                                <div class="banner-item-admin">
                                    <div class="banner-preview">
                                        <img src="../<?php echo htmlspecialchars($banner['image_path']); ?>" alt="<?php echo htmlspecialchars($banner['title']); ?>">
                                    </div>
                                    <div class="banner-info">
                                        <h4><?php echo htmlspecialchars($banner['title']); ?></h4>
                                        <p><?php echo htmlspecialchars($banner['content']); ?></p>
                                        <div class="banner-actions">
                                            <button class="btn btn-sm btn-outline" onclick="editBanner(<?php echo $banner['id']; ?>)">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteBanner(<?php echo $banner['id']; ?>)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Newsletter Section -->
            <section id="newsletter-section" class="content-section">
                <div class="card">
                    <div class="card-header">
                        <h3>Newsletter Subscribers</h3>
                        <div class="header-actions">
                            <input type="text" class="search-input" placeholder="Search subscribers..." id="subscriberSearch">
                            <button class="btn btn-primary" onclick="exportSubscribers()">Export</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="table-container">
                            <table class="data-table" id="subscribersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Subscribed</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="subscribersList">
                                    <!-- Will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Ecosystem Section -->
            <section id="ecosystem-section" class="content-section">
                <div class="card">
                    <div class="card-header">
                        <h3>ThriveHQ Ecosystem</h3>
                        <button class="btn btn-primary" onclick="addEcosystemItem()">Add New Item</button>
                    </div>
                    <div class="card-content">
                        <div class="ecosystem-grid" id="ecosystemGrid">
                            <?php foreach ($data['ecosystem'] as $item): ?>
                                <div class="ecosystem-item">
                                    <div class="ecosystem-icon">
                                        <i class="fas <?php echo htmlspecialchars($item['icon']); ?>"></i>
                                    </div>
                                    <div class="ecosystem-info">
                                        <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                                        <div class="ecosystem-actions">
                                            <button class="btn btn-sm btn-outline" onclick="editEcosystemItem(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['name']); ?>', '<?php echo htmlspecialchars($item['description']); ?>', '<?php echo htmlspecialchars($item['icon']); ?>')">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteEcosystemItem(<?php echo $item['id']; ?>)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Analytics Section -->
            <section id="analytics-section" class="content-section">
                <div class="analytics-grid">
                    <div class="card">
                        <div class="card-header">
                            <h3>Visitor Analytics</h3>
                            <select class="date-filter">
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 3 months</option>
                            </select>
                        </div>
                        <div class="card-content">
                            <canvas id="visitorChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3>Newsletter Growth</h3>
                        </div>
                        <div class="card-content">
                            <canvas id="newsletterChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Settings Section -->
            <section id="settings-section" class="content-section">
                <div class="card">
                    <div class="card-header">
                        <h3>Admin Settings</h3>
                    </div>
                    <div class="card-content">
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Admin Email</label>
                                <input type="email" value="admin@thrive.com" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Site Title</label>
                                <input type="text" value="Thrive" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Maintenance Mode</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="maintenanceMode">
                                    <label for="maintenanceMode"></label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal for editing content -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Edit Content</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editType" value="">
                    <input type="hidden" id="editId" value="">
                    
                    <!-- Who We Are Fields -->
                    <div id="whoWeAreFields" class="form-fields" style="display: none;">
                        <div class="form-group">
                            <label for="editTitle">Title</label>
                            <input type="text" id="editTitle" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editContent">Content</label>
                            <textarea id="editContent" class="form-control" rows="6"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editImage">Image Path</label>
                            <input type="text" id="editImage" class="form-control" placeholder="assets/images/who-we-are.jpg">
                        </div>
                    </div>
                    
                    <!-- Banner Fields -->
                    <div id="bannerFields" class="form-fields" style="display: none;">
                        <div class="form-group">
                            <label for="editTitle">Title</label>
                            <input type="text" id="editTitle" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editContent">Content</label>
                            <textarea id="editContent" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editImage">Image Path</label>
                            <input type="text" id="editImage" class="form-control" placeholder="assets/images/banner1.jpg">
                        </div>
                        <div class="form-group">
                            <label for="editPosition">Position</label>
                            <input type="number" id="editPosition" class="form-control" min="1" max="3">
                        </div>
                    </div>
                    
                    <!-- Ecosystem Fields -->
                    <div id="ecosystemFields" class="form-fields" style="display: none;">
                        <div class="form-group">
                            <label for="editTitle">Name</label>
                            <input type="text" id="editTitle" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editContent">Description</label>
                            <textarea id="editContent" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editIcon">Icon (FontAwesome class)</label>
                            <input type="text" id="editIcon" class="form-control" placeholder="fa-baby">
                        </div>
                    </div>
                    
                    <div class="modal-actions">
                        <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
