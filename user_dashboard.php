<?php
require_once 'includes/auth.php';
require_once 'includes/config.php';

requireLogin();

// Redirect Admins
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') {
    header("Location: admin_dashboard.php");
    exit();
}

$username = $_SESSION['username'] ?? 'User';

// Fetch resources
$resources = $conn->query("SELECT * FROM resources ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            padding: 15px 25px;
            background: #111827;
            position: sticky;
            top: 0;
        }

        .navbar a {
            color: #e2e8f0;
            margin-left: 15px;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #38bdf8;
        }

        .page-wrapper {
            padding: 25px;
            max-width: 1000px;
            margin: auto;
        }

        .page-header {
            margin-bottom: 10px;
        }

        .insight {
            background: #1e293b;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .table-box {
            background: #111827;
            padding: 15px;
            border-radius: 12px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #334155;
            text-align: left;
        }

        th {
            background: #1f2937;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
        }

        .available { background: #16a34a; }
        .unavailable { background: #dc2626; }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="navbar-brand">🏫 CRT USER DASHBOARD</div>

    <div>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="resources.php">Resources</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="page-wrapper">

    <div class="page-header">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?> 👋</h2>
    </div>

    <div class="insight">
        📚 You can view and access all available training resources here.
    </div>

    <div class="table-box">

        <table>
            <thead>
                <tr>
                    <th>Resource Name</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

            <?php if ($resources && $resources->num_rows > 0): ?>

                <?php while ($r = $resources->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r['name']); ?></td>
                        <td><?php echo htmlspecialchars($r['type']); ?></td>
                        <td>
                            <?php if (strtolower($r['status']) === 'available'): ?>
                                <span class="badge available">Available</span>
                            <?php else: ?>
                                <span class="badge unavailable">Unavailable</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="3" style="text-align:center; padding:20px;">
                        No resources available at the moment.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>

</body>
</html>