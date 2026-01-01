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
    <title>Settings - Thrive Admin</title>
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
                    <li class="nav-item">
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
                    <li class="nav-item active">
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
                    <h1 class="page-title">Settings</h1>
                    <p class="page-subtitle">Configure your admin preferences and system settings</p>
                </div>
                <div class="header-right">
                    <div class="date-time" id="dateTime"></div>
                </div>
            </header>

            <!-- Settings Section -->
            <section id="settings-section" class="content-section active">
                <!-- General Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3>General Settings</h3>
                    </div>
                    <div class="card-content">
                        <form class="settings-form">
                            <div class="form-group">
                                <label for="adminEmail">Admin Email</label>
                                <input type="email" id="adminEmail" value="admin@thrive.com" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="siteTitle">Site Title</label>
                                <input type="text" id="siteTitle" value="Thrive" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="siteDescription">Site Description</label>
                                <textarea id="siteDescription" class="form-control" rows="3">Empowering Every Human to Thrive</textarea>
                            </div>
                            <div class="form-group">
                                <label for="contactEmail">Contact Email</label>
                                <input type="email" id="contactEmail" value="contact@thrive.com" class="form-control">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- System Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3>System Settings</h3>
                    </div>
                    <div class="card-content">
                        <form class="settings-form">
                            <div class="form-group">
                                <label for="maintenanceMode">Maintenance Mode</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="maintenanceMode">
                                    <label for="maintenanceMode"></label>
                                    <span class="toggle-label">Enable maintenance mode</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="debugMode">Debug Mode</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="debugMode">
                                    <label for="debugMode"></label>
                                    <span class="toggle-label">Enable debug logging</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="emailNotifications">Email Notifications</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="emailNotifications" checked>
                                    <label for="emailNotifications"></label>
                                    <span class="toggle-label">Receive email notifications</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3>Security Settings</h3>
                    </div>
                    <div class="card-content">
                        <form class="settings-form">
                            <div class="form-group">
                                <label for="sessionTimeout">Session Timeout (minutes)</label>
                                <input type="number" id="sessionTimeout" value="60" class="form-control" min="15" max="480">
                            </div>
                            <div class="form-group">
                                <label for="passwordPolicy">Password Policy</label>
                                <select id="passwordPolicy" class="form-control">
                                    <option value="basic">Basic (8+ characters)</option>
                                    <option value="medium" selected>Medium (8+ chars, mixed case)</option>
                                    <option value="strong">Strong (12+ chars, mixed case, numbers, symbols)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="twoFactor">Two-Factor Authentication</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="twoFactor">
                                    <label for="twoFactor"></label>
                                    <span class="toggle-label">Enable 2FA for admin accounts</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="card">
                    <div class="card-content">
                        <button type="button" class="btn btn-primary" onclick="saveSettings()">Save All Settings</button>
                        <button type="button" class="btn btn-outline" onclick="resetSettings()">Reset to Defaults</button>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/admin.js"></script>
</body>
</html>