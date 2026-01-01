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
    <title>Banner Management - Thrive Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
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
                    <li class="nav-item active">
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
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h1 class="page-title">Banner Management</h1>
                    <p class="page-subtitle">Manage your website banners and images</p>
                </div>
                <div class="header-right">
                    <div class="date-time" id="dateTime"></div>
                </div>
            </header>
            <!-- Banner Management Section -->
            <section id="banner-section" class="content-section active">
                <div class="card">
                    <div class="card-header">
                        <h3>Banner Management</h3>
                        <button class="btn btn-primary" onclick="addBanner()">Add New Banner</button>
                    </div>
                    <div class="card-content">
                        <!-- Image Upload Dropzone -->
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
        </main>
    </div>

    <!-- Modal for editing banners -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Edit Banner</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                 <div class="mb-4">
                            <form action="upload.php" class="dropzone form-control" id="bannerDropzone"></form>
                        </div>
                <form id="editForm">
                    <input type="hidden" id="editType" value="banner">
                    <input type="hidden" id="editId" value="">

                    <!-- Banner Fields -->
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
  
</body>
</html>