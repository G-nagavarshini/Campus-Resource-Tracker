<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

requireLogin();

// OPTIONAL SAFETY (only admin can add/edit/delete)
$isAdmin = ($_SESSION['role'] ?? '') === 'Admin';

// ADD RESOURCE (ADMIN ONLY)
if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    $stmt = $conn->prepare(
        "INSERT INTO resources (name,type,location,quantity,status,description)
         VALUES (?,?,?,?,?,?)"
    );

    $stmt->bind_param("sssiss",
        $name, $type, $location, $quantity, $status, $description
    );

    $stmt->execute();

    header("Location: resources.php");
    exit;
}

// FETCH
$resources = $conn->query("SELECT * FROM resources ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Resources</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="navbar-brand">🏫 Campus Resources</div>

    <div class="navbar-right">
        <a href="dashboard.php">Dashboard</a>
        <a href="resources.php">Resources</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="page-wrapper">

    <div class="page-header">
        <h2>Resources List</h2>

        <?php if($isAdmin): ?>
            <button onclick="openModal()" class="btn btn-primary">+ Add Resource</button>
        <?php endif; ?>
    </div>

    <div class="table-box">

        <table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Description</th>
                <?php if($isAdmin): ?><th>Action</th><?php endif; ?>
            </tr>

            <?php while($row = $resources->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>

                <?php if($isAdmin): ?>
                <td>
                    <a href="edit_resource.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete_resource.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Delete this resource?')"
                       style="color:red;">Delete</a>
                </td>
                <?php endif; ?>

            </tr>
            <?php endwhile; ?>

        </table>

    </div>
</div>

<!-- MODAL -->
<div class="modal-overlay" id="modal">

    <div class="modal-box">

        <h3>Add Resource</h3>

        <form method="POST">

            <input type="text" name="name" placeholder="Name" required><br><br>
            <input type="text" name="type" placeholder="Type" required><br><br>
            <input type="text" name="location" placeholder="Location" required><br><br>
            <input type="number" name="quantity" value="1"><br><br>

            <select name="status">
                <option>Available</option>
                <option>In Use</option>
                <option>Maintenance</option>
            </select><br><br>

            <textarea name="description" placeholder="Description"></textarea><br><br>

            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" onclick="closeModal()">Cancel</button>

        </form>

    </div>
</div>

<script>
function openModal(){
    document.getElementById("modal").style.display="flex";
}
function closeModal(){
    document.getElementById("modal").style.display="none";
}
</script>

</body>
</html>