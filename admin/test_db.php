<?php
require_once 'config/database.php';
$db = new Database();
$conn = $db->getConnection();
if ($conn->connect_error) {
    echo 'Connection failed: ' . $conn->connect_error;
} else {
    echo 'Database connection successful<br>';
    $result = $conn->query('SHOW TABLES');
    echo 'Tables: ';
    while ($row = $result->fetch_array()) {
        echo $row[0] . ' ';
    }
}
?>