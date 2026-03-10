<?php
// setup-db.php
// Script to initialize the MySQL table and create directories needed for DYP Notes uploads.

$mysqli = require __DIR__ . "/login/database.php";

// 1. Create notes table
$sql = "CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    subject VARCHAR(128) NOT NULL,
    semester VARCHAR(32) NOT NULL,
    branch VARCHAR(64) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Table 'notes' verified/created successfully.<br>";
} else {
    echo "Error creating table: " . $mysqli->error . "<br>";
}

// 2. Create uploads directory
$uploadDir = __DIR__ . '/uploads/notes';
if (!is_dir($uploadDir)) {
    if (mkdir($uploadDir, 0777, true)) {
        echo "Uploads directory created at: " . $uploadDir . "<br>";
    } else {
        echo "Failed to create uploads directory.<br>";
    }
} else {
    echo "Uploads directory already exists.<br>";
}

echo "<hr>Setup complete. You can now use the Advanced Notes System.";

$mysqli->close();
