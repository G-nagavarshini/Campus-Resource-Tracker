<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

requireLogin();

if ($_SESSION['role'] !== 'Admin') {
    header("Location: user_dashboard.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM resources WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin_dashboard.php?msg=deleted");
} else {
    echo "Delete failed";
}