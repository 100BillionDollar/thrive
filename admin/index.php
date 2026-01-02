<?php
session_start();
require_once 'config/database.php';
require_once 'api/dashboard.php';

// Get dashboard data
$dashboard = new Dashboard($conn);
$data = $dashboard->getDashboardData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrive - Empowering Every Human to Thrive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-brand">
                    <i class="fas fa-rocket"></i>
                    <span>Thrive</span>
                </div>
                <ul class="nav-menu">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#ecosystem">Ecosystem</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="admin/login.php" class="btn btn-primary">Admin</a></li>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Empowering Every Human to Thrive</h1>
                <p class="hero-subtitle">Discover a comprehensive ecosystem designed to support your journey through parenthood, personal growth, and family wellness.</p>
                <div class="hero-actions">
                    <a href="#ecosystem" class="btn btn-primary">Explore Our Ecosystem</a>
                    <a href="#newsletter" class="btn btn-outline">Join Our Community</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    <section id="banner" class="banner">
        <div class="container">
            <div class="banner-slider">
                <?php if (!empty($data['banners']) && count($data['banners']) > 0): ?>
                    <?php foreach ($data['banners'] as $banner): ?>
                        <div class="banner-item">
                            <div class="banner-content">
                                <div class="banner-image">
                                    <img src="<?php echo htmlspecialchars($banner['image_path']); ?>" alt="<?php echo htmlspecialchars($banner['title']); ?>">
                                </div>
                                <div class="banner-text">
                                    <h3><?php echo htmlspecialchars($banner['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($banner['content']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default banner items if no data in database -->
                    <div class="banner-item">
                        <div class="banner-content">
                            <div class="banner-image">
                                <img src="assets/images/banner1.jpg" alt="Empowering Families">
                            </div>
                            <div class="banner-text">
                                <h3>Empowering Families</h3>
                                <p>Discover comprehensive resources and support for every stage of your parenting journey.</p>
                            </div>
                        </div>
                    </div>
                    <div class="banner-item">
                        <div class="banner-content">
                            <div class="banner-image">
                                <img src="assets/images/banner2.jpg" alt="Building Strong Communities">
                            </div>
                            <div class="banner-text">
                                <h3>Building Strong Communities</h3>
                                <p>Join a thriving community of parents and experts dedicated to family wellness.</p>
                            </div>
                        </div>
                    </div>
                    <div class="banner-item">
                        <div class="banner-content">
                            <div class="banner-image">
                                <img src="assets/images/banner3.jpg" alt="Innovative Solutions">
                            </div>
                            <div class="banner-text">
                                <h3>Innovative Solutions</h3>
                                <p>Access cutting-edge tools and technologies designed to make family life easier.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="banner-controls">
                <button class="banner-prev" onclick="changeBanner(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="banner-next" onclick="changeBanner(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="section-header">
                <h2>The Heart of Our Mission</h2>
                <div class="divider"></div>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <h3><?php echo htmlspecialchars($data['who_we_are']['title'] ?? 'Building Tomorrow\'s Solutions Today'); ?></h3>
                    <p><?php echo htmlspecialchars($data['who_we_are']['content'] ?? 'We are a team of passionate professionals dedicated to creating innovative solutions that transform businesses and improve lives. With years of experience and a commitment to excellence, we strive to deliver exceptional results that exceed expectations.'); ?></p>
                    <div class="stats">
                        <div class="stat-item">
                            <span class="stat-number" data-target="500">0</span>
                            <span class="stat-label">Happy Families</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" data-target="1000">0</span>
                            <span class="stat-label">Community Members</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" data-target="50">0</span>
                            <span class="stat-label">Expert Contributors</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="<?php echo htmlspecialchars($data['who_we_are']['image_path'] ?? 'assets/images/who-we-are.jpg'); ?>" alt="Who We Are">
                    <div class="image-overlay"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ecosystem Section -->
    <section id="ecosystem" class="ecosystem">
        <div class="container">
            <div class="section-header">
                <h2>The ThriveHQ Ecosystem</h2>
                <div class="divider"></div>
                <p>Comprehensive platforms designed to support every aspect of your family's journey</p>
            </div>
            <div class="ecosystem-grid">
                <?php if (!empty($data['ecosystem']) && count($data['ecosystem']) > 0): ?>
                    <?php foreach ($data['ecosystem'] as $item): ?>
                        <div class="ecosystem-card">
                            <div class="ecosystem-icon">
                                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            <a href="#" class="btn btn-outline">Learn More</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default ecosystem items if no data in database -->
                    <div class="ecosystem-card">
                        <div class="ecosystem-icon">
                            <i class="fas fa-baby"></i>
                        </div>
                        <h3>Parenting360</h3>
                        <p>Comprehensive parenting resources, expert advice, and support for every stage of your parenting journey.</p>
                        <a href="#" class="btn btn-outline">Learn More</a>
                    </div>
                    
                    <div class="ecosystem-card">
                        <div class="ecosystem-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>MomsHQ</h3>
                        <p>Empowering mothers with knowledge, community support, and wellness resources for modern motherhood.</p>
                        <a href="#" class="btn btn-outline">Learn More</a>
                    </div>
                    
                    <div class="ecosystem-card">
                        <div class="ecosystem-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Diyaa</h3>
                        <p>Innovative solutions and tools designed to make family life easier, more organized, and more joyful.</p>
                        <a href="#" class="btn btn-outline">Learn More</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="newsletter" class="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <h2>Stay Connected</h2>
                <p>Join our community and receive the latest updates, expert tips, and exclusive resources.</p>
                <form class="newsletter-form" id="newsletterForm">
                    <input type="email" id="email" placeholder="Enter your email address" required>
                    <button type="submit">Subscribe</button>
                </form>
                <div class="newsletter-message" id="newsletterMessage"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-brand">
                        <i class="fas fa-rocket"></i>
                        <span>Thrive</span>
                    </div>
                    <p>Empowering every human to thrive through comprehensive support and innovative solutions.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#ecosystem">Ecosystem</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Our Platforms</h3>
                    <ul>
                        <li><a href="#">Parenting360</a></li>
                        <li><a href="#">MomsHQ</a></li>
                        <li><a href="#">Diyaa</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-envelope"></i> info@thrive.com</p>
                    <p><i class="fas fa-phone"></i> +1 234 567 8900</p>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Street, City, Country</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Thrive. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
