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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Management - Thrive Admin</title>
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
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="content.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Content Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="whoweare.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Who We Are</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="banner.php" class="nav-link">
                            <i class="fas fa-image"></i>
                            <span>Banner Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="newsletter.php" class="nav-link">
                            <i class="fas fa-envelope"></i>
                            <span>Newsletter</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ecosystem.php" class="nav-link">
                            <i class="fas fa-globe"></i>
                            <span>Ecosystem</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analytics.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link">
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
                    <h1 class="page-title">Newsletter Management</h1>
                    <p class="page-subtitle">Manage your newsletter subscribers and campaigns</p>
                </div>
                <div class="header-right">
                    <div class="date-time" id="dateTime"></div>
                </div>
            </header>

            <!-- Newsletter Section -->
            <section id="newsletter-section" class="content-section active">
                <!-- Newsletter Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $data['newsletter_count']; ?></h3>
                            <p>Total Subscribers</p>
                            <span class="stat-change positive">+5.2%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="stat-content">
                            <h3>24</h3>
                            <p>Campaigns Sent</p>
                            <span class="stat-change positive">+2 this month</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <h3>68.5%</h3>
                            <p>Open Rate</p>
                            <span class="stat-change positive">+3.1%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-mouse-pointer"></i>
                        </div>
                        <div class="stat-content">
                            <h3>24.3%</h3>
                            <p>Click Rate</p>
                            <span class="stat-change negative">-1.2%</span>
                        </div>
                    </div>
                </div>

                <!-- Newsletter Subscribers -->
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

                <!-- Send Newsletter -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h3>Send Newsletter</h3>
                    </div>
                    <div class="card-content">
                        <form id="newsletterForm">
                            <div class="form-group">
                                <label for="newsletterSubject">Subject</label>
                                <input type="text" id="newsletterSubject" class="form-control" placeholder="Enter newsletter subject">
                            </div>
                            <div class="form-group">
                                <label for="newsletterContent">Content</label>
                                <textarea id="newsletterContent" class="form-control" rows="10" placeholder="Enter newsletter content"></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline" onclick="previewNewsletter()">Preview</button>
                                <button type="submit" class="btn btn-primary">Send Newsletter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/admin.js"></script>
</body>
</html>