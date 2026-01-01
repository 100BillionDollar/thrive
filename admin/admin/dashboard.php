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
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <!-- Dashboard Section -->
            <section id="dashboard-section" class="content-section active">
                <div class="section-header">
                    <h2>Dashboard Overview</h2>
                    <div class="header-actions">
                        <select class="date-filter">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                        </select>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $analytics['total_subscribers'] ?? 0; ?></h3>
                            <p>Total Subscribers</p>
                            <span class="stat-change positive">+12%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($analytics['total_views'] ?? 0); ?></h3>
                            <p>Total Views</p>
                            <span class="stat-change positive">+8%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-envelope-open"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $analytics['open_rate'] ?? 0; ?>%</h3>
                            <p>Open Rate</p>
                            <span class="stat-change positive">+5%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-mouse-pointer"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $analytics['click_rate'] ?? 0; ?>%</h3>
                            <p>Click Rate</p>
                            <span class="stat-change negative">-2%</span>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="charts-row">
                    <div class="chart-card">
                        <div class="card-header">
                            <h3>Subscriber Growth</h3>
                        </div>
                        <div class="card-content">
                            <canvas id="subscriberChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-card">
                        <div class="card-header">
                            <h3>Newsletter Performance</h3>
                        </div>
                        <div class="card-content">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="activity-card">
                    <div class="card-header">
                        <h3>Recent Activity</h3>
                    </div>
                    <div class="card-content">
                        <div class="activity-list">
                            <?php if (!empty($data['recent_activities'])): ?>
                                <?php foreach ($data['recent_activities'] as $activity): ?>
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-circle"></i>
                                        </div>
                                        <div class="activity-content">
                                            <p><?php echo htmlspecialchars($activity['activity']); ?></p>
                                            <span><?php echo date('M j, H:i', strtotime($activity['created_at'])); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="no-activity">No recent activity</p>
                            <?php endif; ?>
                        </div>
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
                    
                    <!-- Content Type Selector -->
                    <div class="form-group">
                        <label for="contentTypeSelect">Content Type</label>
                        <select id="contentTypeSelect" class="form-control" onchange="changeContentType()">
                            <option value="">Select Content Type</option>
                            <option value="who_we_are">Who We Are</option>
                            <option value="heart_of_mission">Heart of Mission</option>
                            <option value="banner">Banner</option>
                        </select>
                    </div>

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

                    <!-- Heart of Mission Fields -->
                    <div id="heartOfMissionFields" class="form-fields" style="display: none;">
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
                            <input type="text" id="editImage" class="form-control" placeholder="assets/images/heart-of-mission.jpg">
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select id="editStatus" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
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
                            <label>Image</label>
                            <div id="currentImagePreview" style="display: none; margin-bottom: 10px;">
                                <p><strong>Current Image:</strong></p>
                                <img id="currentImage" src="" style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                            </div>
                            <form action="upload.php" class="dropzone" id="bannerModalDropzone"></form>
                            <input type="hidden" id="editImage" class="form-control">
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
                            <label for="editIcon">Icon</label>
                            <select id="editIcon" class="form-control">
                                <option value="fa-baby">Baby (fa-baby)</option>
                                <option value="fa-heart">Heart (fa-heart)</option>
                                <option value="fa-lightbulb">Lightbulb (fa-lightbulb)</option>
                                <option value="fa-users">Users (fa-users)</option>
                                <option value="fa-home">Home (fa-home)</option>
                                <option value="fa-graduation-cap">Graduation Cap (fa-graduation-cap)</option>
                                <option value="fa-briefcase">Briefcase (fa-briefcase)</option>
                                <option value="fa-handshake">Handshake (fa-handshake)</option>
                                <option value="fa-star">Star (fa-star)</option>
                                <option value="fa-shield-alt">Shield (fa-shield-alt)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editCategory">Category</label>
                            <select id="editCategory" class="form-control">
                                <option value="platform">Platform</option>
                                <option value="service">Service</option>
                                <option value="resource">Resource</option>
                                <option value="community">Community</option>
                            </select>
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
    <script>
        // Initialize Dropzone for banner uploads
        Dropzone.options.bannerDropzone = {
            maxFilesize: 5, // MB
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictDefaultMessage: 'Drop images here or click to upload',
            dictRemoveFile: 'Remove file',
            init: function() {
                this.on('success', function(file, response) {
                    try {
                        const data = typeof response === 'string' ? JSON.parse(response) : response;
                        if (data.success) {
                            // Refresh the page after successful upload
                            location.reload();
                        } else {
                            alert('Upload failed: ' + (data.message || response));
                        }
                    } catch (e) {
                        // Fallback for old response format
                        if (response === 'Upload successful') {
                            location.reload();
                        } else {
                            alert('Upload failed: ' + response);
                        }
                    }
                });
                this.on('error', function(file, response) {
                    try {
                        const data = typeof response === 'string' ? JSON.parse(response) : response;
                        alert('Upload failed: ' + (data.message || response));
                    } catch (e) {
                        alert('Upload failed: ' + response);
                    }
                });
            }
        };
    </script>
</body>
</html>