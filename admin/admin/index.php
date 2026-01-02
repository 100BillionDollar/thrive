

<?php include_once 'includes/header.php'; ?>

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

      








<?php include_once 'includes/footer.php'; ?>

