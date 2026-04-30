<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'xtreme4x4_db');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
echo "Database connection successful\n";
$conn->close();
?>