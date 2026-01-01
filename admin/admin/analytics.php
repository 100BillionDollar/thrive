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
    <title>Analytics - Thrive Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                    <li class="nav-item active">
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
                    <h1 class="page-title">Analytics</h1>
                    <p class="page-subtitle">Track your website performance and user engagement</p>
                </div>
                <div class="header-right">
                    <div class="date-time" id="dateTime"></div>
                </div>
            </header>

            <!-- Analytics Section -->
            <section id="analytics-section" class="content-section active">
                <!-- Analytics Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($analytics['total_visitors'] ?? 0); ?></h3>
                            <p>Total Visitors</p>
                            <span class="stat-change positive">+12% from last month</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($analytics['page_views'] ?? 0); ?></h3>
                            <p>Page Views</p>
                            <span class="stat-change positive">+8% from last month</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($analytics['avg_session_duration'] ?? 0, 1); ?>m</h3>
                            <p>Avg. Session Duration</p>
                            <span class="stat-change positive">+15% from last month</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-mouse-pointer"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($analytics['bounce_rate'] ?? 0, 1); ?>%</h3>
                            <p>Bounce Rate</p>
                            <span class="stat-change negative">-3% from last month</span>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="charts-row">
                    <div class="chart-card">
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

                    <div class="chart-card">
                        <div class="card-header">
                            <h3>Newsletter Growth</h3>
                        </div>
                        <div class="card-content">
                            <canvas id="newsletterChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Traffic Sources -->
                <div class="card">
                    <div class="card-header">
                        <h3>Traffic Sources</h3>
                    </div>
                    <div class="card-content">
                        <div class="traffic-sources">
                            <div class="traffic-item">
                                <div class="traffic-info">
                                    <span class="traffic-label">Organic Search</span>
                                    <span class="traffic-value">45.2%</span>
                                </div>
                                <div class="traffic-bar">
                                    <div class="traffic-fill" style="width: 45.2%"></div>
                                </div>
                            </div>
                            <div class="traffic-item">
                                <div class="traffic-info">
                                    <span class="traffic-label">Direct</span>
                                    <span class="traffic-value">28.7%</span>
                                </div>
                                <div class="traffic-bar">
                                    <div class="traffic-fill" style="width: 28.7%"></div>
                                </div>
                            </div>
                            <div class="traffic-item">
                                <div class="traffic-info">
                                    <span class="traffic-label">Social Media</span>
                                    <span class="traffic-value">15.3%</span>
                                </div>
                                <div class="traffic-bar">
                                    <div class="traffic-fill" style="width: 15.3%"></div>
                                </div>
                            </div>
                            <div class="traffic-item">
                                <div class="traffic-info">
                                    <span class="traffic-label">Referral</span>
                                    <span class="traffic-value">10.8%</span>
                                </div>
                                <div class="traffic-bar">
                                    <div class="traffic-fill" style="width: 10.8%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/admin.js"></script>
    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        function initializeCharts() {
            // Visitor Chart
            const visitorCtx = document.getElementById('visitorChart');
            if (visitorCtx) {
                new Chart(visitorCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Visitors',
                            data: [1200, 1350, 1180, 1420, 1380, 1650],
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Newsletter Chart
            const newsletterCtx = document.getElementById('newsletterChart');
            if (newsletterCtx) {
                new Chart(newsletterCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Subscribers',
                            data: [450, 520, 480, 610, 580, 720],
                            backgroundColor: '#10b981'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>