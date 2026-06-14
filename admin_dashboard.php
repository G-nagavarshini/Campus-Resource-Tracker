<?php
require_once 'includes/auth.php';
require_once 'includes/config.php';

requireLogin();

if ($_SESSION['role'] !== 'Admin') {
    header("Location: user_dashboard.php");
    exit();
}

$username = $_SESSION['username'];

$total = $conn->query("SELECT COUNT(*) AS cnt FROM resources")->fetch_assoc()['cnt'];
$available = $conn->query("SELECT COUNT(*) AS cnt FROM resources WHERE status='Available'")->fetch_assoc()['cnt'];
$inuse = $conn->query("SELECT COUNT(*) AS cnt FROM resources WHERE status='In Use'")->fetch_assoc()['cnt'];
$maintenance = $conn->query("SELECT COUNT(*) AS cnt FROM resources WHERE status='Maintenance'")->fetch_assoc()['cnt'];

$recent = $conn->query("SELECT * FROM resources ORDER BY added_on DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="navbar">
    <div class="navbar-brand">🏫 CRT ADMIN</div>
    <div class="navbar-right">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="resources.php">Resources</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="page-wrapper">

    <div class="page-header">
        <h2>Welcome Admin, <?php echo $username; ?></h2>
    </div>

    <div class="insight">
        Total Resources: <b><?php echo $total; ?></b>
    </div>

    <div class="stats">
        <div class="card blue">Total: <?php echo $total; ?></div>
        <div class="card green">Available: <?php echo $available; ?></div>
        <div class="card yellow">In Use: <?php echo $inuse; ?></div>
        <div class="card red">Maintenance: <?php echo $maintenance; ?></div>
    </div>

   <div class="table-box">
    <h3>Recent Resources</h3>

    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Location</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while($r = $recent->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($r['name']); ?></td>
            <td><?php echo htmlspecialchars($r['type']); ?></td>
            <td><?php echo htmlspecialchars($r['location']); ?></td>
            <td><?php echo $r['status']; ?></td>

            <td>
                <a href="edit_resource.php?id=<?php echo $r['id']; ?>" style="color:#38bdf8;">Edit</a>
                |
                <a href="delete_resource.php?id=<?php echo $r['id']; ?>" 
                   onclick="return confirm('Delete this resource?')" 
                   style="color:#ef4444;">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</div>

</body>
</html>