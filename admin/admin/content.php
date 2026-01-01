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
    <title>Content Management - Thrive Admin</title>
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
                    <li class="nav-item active">
                        <a href="content.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Content Management</span>
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
                    <h1 class="page-title">Content Management</h1>
                    <p class="page-subtitle">Manage the Heart of Mission section content</p>
                </div>
                <div class="header-right">
                    <div class="date-time" id="dateTime"></div>
                </div>
            </header>

            <!-- Content Management Section -->
            <section id="content-section" class="content-section active">
                <!-- Heart of Mission Section -->
                <div class="card">
                    <div class="card-header">
                        <h3>Heart of Mission Section</h3>
                        <button class="btn btn-primary" onclick="editHeartOfMission()">Edit Content</button>
                    </div>
                    <div class="card-content">
                        <div class="content-preview">
                            <h4 id="heartOfMissionTitle"><?php echo htmlspecialchars($data['heart_of_mission']['title']); ?></h4>
                            <p id="heartOfMissionContent"><?php echo htmlspecialchars($data['heart_of_mission']['content']); ?></p>
                            <?php if (!empty($data['heart_of_mission']['image_path'])): ?>
                                <div class="content-image">
                                    <img src="../<?php echo htmlspecialchars($data['heart_of_mission']['image_path']); ?>" alt="Heart of Mission">
                                </div>
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
                    <input type="hidden" id="editType" value="heart_of_mission">
                    <input type="hidden" id="editId" value="">

                    <!-- Heart of Mission Fields -->
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" id="editTitle" class="form-control" value="<?php echo htmlspecialchars($data['heart_of_mission']['title']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="editContent">Content</label>
                        <textarea id="editContent" class="form-control" rows="6"><?php echo htmlspecialchars($data['heart_of_mission']['content']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <div id="currentImagePreview" style="display: <?php echo !empty($data['heart_of_mission']['image_path']) ? 'block' : 'none'; ?>; margin-bottom: 10px;">
                            <p><strong>Current Image:</strong></p>
                            <img id="currentImage" src="../<?php echo htmlspecialchars($data['heart_of_mission']['image_path']); ?>" style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                        <form action="upload.php" class="dropzone" id="heartOfMissionDropzone"></form>
                        <input type="hidden" id="editImage" class="form-control" value="<?php echo htmlspecialchars($data['heart_of_mission']['image_path']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <select id="editStatus" class="form-control">
                            <option value="active" <?php echo ($data['heart_of_mission']['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($data['heart_of_mission']['status'] ?? 'active') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
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
    <script>
        // Initialize Dropzone for Heart of Mission image uploads
        let heartOfMissionDropzone;

        document.addEventListener('DOMContentLoaded', function() {
            initializeHeartOfMissionDropzone();
        });

        function initializeHeartOfMissionDropzone() {
            // Remove existing dropzone instance if it exists
            if (heartOfMissionDropzone) {
                heartOfMissionDropzone.destroy();
            }

            // Initialize new dropzone
            heartOfMissionDropzone = new Dropzone('#heartOfMissionDropzone', {
                maxFilesize: 5, // MB
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                dictDefaultMessage: 'Drop new image here or click to upload (replaces current image)',
                dictRemoveFile: 'Remove file',
                maxFiles: 1,
                paramName: 'file',
                params: {
                    action: 'upload_only'
                },
                init: function() {
                    this.on('success', function(file, response) {
                        try {
                            const data = typeof response === 'string' ? JSON.parse(response) : response;
                            // Update hidden input with new image path
                            document.getElementById('editImage').value = data.image_path;

                            // Hide current image preview when new image is uploaded
                            const currentImagePreview = document.getElementById('currentImagePreview');
                            if (currentImagePreview) {
                                currentImagePreview.style.display = 'none';
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                        }
                    });

                    this.on('removedfile', function(file) {
                        // Clear hidden input if file is removed
                        if (this.files.length === 0) {
                            document.getElementById('editImage').value = '';

                            // Show current image preview again if no new file
                            const currentImagePreview = document.getElementById('currentImagePreview');
                            if (currentImagePreview && document.getElementById('editId').value) {
                                currentImagePreview.style.display = 'block';
                            }
                        }
                    });

                    this.on('error', function(file, response) {
                        try {
                            const data = typeof response === 'string' ? JSON.parse(response) : response;
                            showNotification('Upload failed: ' + (data.message || response), 'error');
                        } catch (e) {
                            showNotification('Upload failed: ' + response, 'error');
                        }
                    });
                }
            });
        }

        function editHeartOfMission() {
            document.getElementById('modalTitle').textContent = 'Edit Heart of Mission Content';
            document.getElementById('editType').value = 'heart_of_mission';
            document.getElementById('editId').value = '1'; // Static ID for heart_of_mission
            document.getElementById('editTitle').value = document.getElementById('heartOfMissionTitle').textContent;
            document.getElementById('editContent').value = document.getElementById('heartOfMissionContent').textContent;
            document.getElementById('editImage').value = '<?php echo htmlspecialchars($data['heart_of_mission']['image_path']); ?>';
            document.getElementById('editStatus').value = '<?php echo htmlspecialchars($data['heart_of_mission']['status'] ?? 'active'); ?>';

            // Show current image preview
            const currentImagePreview = document.getElementById('currentImagePreview');
            const currentImage = document.getElementById('currentImage');
            if (currentImagePreview && currentImage && '<?php echo htmlspecialchars($data['heart_of_mission']['image_path']); ?>') {
                currentImage.src = '../<?php echo htmlspecialchars($data['heart_of_mission']['image_path']); ?>';
                currentImagePreview.style.display = 'block';
            }

            openModal();

            // Initialize dropzone after modal is open
            setTimeout(() => initializeHeartOfMissionDropzone(), 200);
        }
    </script>
</body>
</html>