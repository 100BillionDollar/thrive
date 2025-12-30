<?php
require_once 'config/database.php';

// Create database if it doesn't exist
$createDatabaseSQL = "CREATE DATABASE IF NOT EXISTS dashboard_db";
if ($conn->query($createDatabaseSQL) === TRUE) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("dashboard_db");

// Create who_we_are table
$whoWeAreSQL = "CREATE TABLE IF NOT EXISTS who_we_are (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($whoWeAreSQL) === TRUE) {
    echo "Table 'who_we_are' created successfully<br>";
} else {
    echo "Error creating table 'who_we_are': " . $conn->error . "<br>";
}

// Create newsletter_subscribers table
$newsletterSQL = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    status ENUM('active', 'inactive', 'unsubscribed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($newsletterSQL) === TRUE) {
    echo "Table 'newsletter_subscribers' created successfully<br>";
} else {
    echo "Error creating table 'newsletter_subscribers': " . $conn->error . "<br>";
}

// Create activities table
$activitiesSQL = "CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($activitiesSQL) === TRUE) {
    echo "Table 'activities' created successfully<br>";
} else {
    echo "Error creating table 'activities': " . $conn->error . "<br>";
}

// Create visitors table
$visitorsSQL = "CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45),
    user_agent TEXT,
    page_visited VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($visitorsSQL) === TRUE) {
    echo "Table 'visitors' created successfully<br>";
} else {
    echo "Error creating table 'visitors': " . $conn->error . "<br>";
}

// Create page_views table
$pageViewsSQL = "CREATE TABLE IF NOT EXISTS page_views (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($pageViewsSQL) === TRUE) {
    echo "Table 'page_views' created successfully<br>";
} else {
    echo "Error creating table 'page_views': " . $conn->error . "<br>";
}

// Create banner table
$bannerSQL = "CREATE TABLE IF NOT EXISTS banner (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_path VARCHAR(500) NOT NULL,
    position INT NOT NULL DEFAULT 1,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($bannerSQL) === TRUE) {
    echo "Table 'banner' created successfully<br>";
} else {
    echo "Error creating table 'banner': " . $conn->error . "<br>";
}

// Create ecosystem table
$ecosystemSQL = "CREATE TABLE IF NOT EXISTS ecosystem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($ecosystemSQL) === TRUE) {
    echo "Table 'ecosystem' created successfully<br>";
} else {
    echo "Error creating table 'ecosystem': " . $conn->error . "<br>";
}

// Update who_we_are table to include image
$alterWhoWeAreSQL = "ALTER TABLE who_we_are ADD COLUMN image_path VARCHAR(500) AFTER content";
if ($conn->query($alterWhoWeAreSQL) === TRUE) {
    echo "Column 'image_path' added to 'who_we_are' table<br>";
} else {
    echo "Note: Column 'image_path' may already exist in 'who_we_are' table<br>";
}

// Insert default data for who_we_are if table is empty
$checkDataSQL = "SELECT COUNT(*) as count FROM who_we_are";
$result = $conn->query($checkDataSQL);
if ($result && $result->fetch_assoc()['count'] == 0) {
    $insertSQL = "INSERT INTO who_we_are (title, content, status) VALUES (?, ?, 'active')";
    $stmt = $conn->prepare($insertSQL);
    
    $title = "Building Tomorrow's Solutions Today";
    $content = "We are a team of passionate professionals dedicated to creating innovative solutions that transform businesses and improve lives. With years of experience and a commitment to excellence, we strive to deliver exceptional results that exceed expectations. Our expertise spans across various domains, and we pride ourselves on our ability to adapt and innovate in an ever-changing technological landscape.";
    
    $stmt->bind_param("ss", $title, $content);
    
    if ($stmt->execute()) {
        echo "Default data inserted into 'who_we_are' table<br>";
    } else {
        echo "Error inserting default data: " . $stmt->error . "<br>";
    }
    
    $stmt->close();
}

// Insert sample banner data
$checkBannerSQL = "SELECT COUNT(*) as count FROM banner";
$result = $conn->query($checkBannerSQL);
if ($result && $result->fetch_assoc()['count'] == 0) {
    $bannerItems = [
        [
            'title' => 'Empowering Families',
            'content' => 'Discover comprehensive resources and support for every stage of your parenting journey.',
            'image_path' => 'assets/images/banner1.jpg',
            'position' => 1
        ],
        [
            'title' => 'Building Strong Communities',
            'content' => 'Join a thriving community of parents and experts dedicated to family wellness.',
            'image_path' => 'assets/images/banner2.jpg',
            'position' => 2
        ],
        [
            'title' => 'Innovative Solutions',
            'content' => 'Access cutting-edge tools and technologies designed to make family life easier.',
            'image_path' => 'assets/images/banner3.jpg',
            'position' => 3
        ]
    ];
    
    foreach ($bannerItems as $item) {
        $insertBannerSQL = "INSERT INTO banner (title, content, image_path, position, status) VALUES (?, ?, ?, ?, 'active')";
        $stmt = $conn->prepare($insertBannerSQL);
        $stmt->bind_param("sssi", $item['title'], $item['content'], $item['image_path'], $item['position']);
        $stmt->execute();
        $stmt->close();
    }
    echo "Sample banner data inserted<br>";
}

// Insert sample ecosystem data
$checkEcosystemSQL = "SELECT COUNT(*) as count FROM ecosystem";
$result = $conn->query($checkEcosystemSQL);
if ($result && $result->fetch_assoc()['count'] == 0) {
    $ecosystemItems = [
        [
            'name' => 'Parenting360',
            'description' => 'Comprehensive parenting resources, expert advice, and support for every stage of your parenting journey.',
            'icon' => 'fa-baby'
        ],
        [
            'name' => 'MomsHQ',
            'description' => 'Empowering mothers with knowledge, community support, and wellness resources for modern motherhood.',
            'icon' => 'fa-heart'
        ],
        [
            'name' => 'Diyaa',
            'description' => 'Innovative solutions and tools designed to make family life easier, more organized, and more joyful.',
            'icon' => 'fa-lightbulb'
        ]
    ];
    
    foreach ($ecosystemItems as $item) {
        $insertEcosystemSQL = "INSERT INTO ecosystem (name, description, icon, status) VALUES (?, ?, ?, 'active')";
        $stmt = $conn->prepare($insertEcosystemSQL);
        $stmt->bind_param("sss", $item['name'], $item['description'], $item['icon']);
        $stmt->execute();
        $stmt->close();
    }
    echo "Sample ecosystem data inserted<br>";
}

// Create some sample activities
$sampleActivities = [
    "Dashboard initialized",
    "Banner slider activated",
    "Newsletter system ready",
    "Database setup completed"
];

foreach ($sampleActivities as $activity) {
    $insertActivitySQL = "INSERT INTO activities (activity) VALUES (?)";
    $stmt = $conn->prepare($insertActivitySQL);
    $stmt->bind_param("s", $activity);
    $stmt->execute();
    $stmt->close();
}

echo "Sample activities inserted<br>";

// Create .htaccess for pretty URLs (optional)
$htaccessContent = "
RewriteEngine On
RewriteRule ^api/([^/]+)$ api/$1.php [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)$ index.php?page=$1 [L,QSA]
";

file_put_contents('.htaccess', $htaccessContent);
echo ".htaccess file created for pretty URLs<br>";

echo "<h2>Database setup completed successfully!</h2>";
echo "<p>You can now access the dashboard at: <a href='index.php'>index.php</a></p>";
echo "<p>You can access the admin panel at: <a href='admin/login.php'>admin/login.php</a></p>";
echo "<p><strong>Note:</strong> Make sure your XAMPP/Apache server is running and the database credentials in config/database.php are correct.</p>";

$conn->close();
?>
