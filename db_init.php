<?php
$db = new PDO('sqlite:yesefersew.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = file_get_contents('schema.sql');
$db->exec($schema);

// Seed Admin User
$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT OR IGNORE INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Database initialized successfully.\n";
echo "Default credentials: admin / admin123\n";
?>
