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
    <title>Ecosystem Management - Thrive Admin</title>
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
                    <li class="nav-item active">
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
                    <h1 class="page-title">Ecosystem Management</h1>
                    <p class="page-subtitle">Manage the ThriveHQ ecosystem components</p>
                </div>
                <div class="header-right">
                    <div class="date-time" id="dateTime"></div>
                </div>
            </header>

            <!-- Ecosystem Section -->
            <section id="ecosystem-section" class="content-section active">
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
                                            <button class="btn btn-sm btn-outline" onclick="editEcosystemItem(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['name']); ?>', '<?php echo htmlspecialchars($item['description']); ?>', '<?php echo htmlspecialchars($item['icon']); ?>', '<?php echo htmlspecialchars($item['category']); ?>')">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteEcosystemItem(<?php echo $item['id']; ?>)">Delete</button>
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

    <!-- Modal for editing content -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Edit Ecosystem Item</h3>
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
                            <option value="ecosystem" selected>Ecosystem Item</option>
                        </select>
                    </div>

                    <!-- Ecosystem Fields -->
                    <div id="ecosystemFields" class="form-fields" style="display: block;">
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
</body>
</html>