<?php
require_once 'includes/config.php';

$username = 'admin';
$password = 'admin123';

// FIX: use users table (not admin)
$conn->query("DELETE FROM users WHERE username = 'admin'");

$hash = password_hash($password, PASSWORD_DEFAULT);

$role = "Admin";

$stmt = $conn->prepare(
    "INSERT INTO users (username, password, role) VALUES (?, ?, ?)"
);

$stmt->bind_param("sss", $username, $hash, $role);

if ($stmt->execute()) {
    echo "Setup complete. Admin created successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>