<?php include_once 'includes/header.php'; ?>
<?php
$adminEmail = $dashboard->getSetting('admin_email') ?: 'admin@thrive.com';
$siteTitle = $dashboard->getSetting('site_title') ?: 'Thrive';
$maintenanceMode = $dashboard->getSetting('maintenance_mode') ?: '0';
$ecosystemHeading = $dashboard->getSetting('ecosystem_heading') ?: 'ThriveHQ Ecosystem';
?>
<!-- Settings Section -->
            <section id="settings-section" class="content-section">
                <div class="card">
                    <div class="card-header">
                        <h3>Admin Settings</h3>
                    </div>
                    <div class="card-content">
                        <form class="settings-form" id="settingsForm">
                            <div class="form-group">
                                <label>Admin Email</label>
                                <input type="email" name="admin_email" value="<?php echo htmlspecialchars($adminEmail); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Site Title</label>
                                <input type="text" name="site_title" value="<?php echo htmlspecialchars($siteTitle); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ecosystem Page Heading</label>
                                <input type="text" name="ecosystem_heading" value="<?php echo htmlspecialchars($ecosystemHeading); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Maintenance Mode</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="maintenanceMode" name="maintenance_mode" <?php echo $maintenanceMode == '1' ? 'checked' : ''; ?>>
                                    <label for="maintenanceMode"></label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </section>

        <?php include_once 'includes/footer.php'; ?>