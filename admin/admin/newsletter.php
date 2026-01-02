<?php include_once 'includes/header.php'; ?>
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
            <?php include_once 'includes/footer.php'; ?>