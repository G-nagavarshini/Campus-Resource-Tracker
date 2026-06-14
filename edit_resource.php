<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

requireLogin();

if ($_SESSION['role'] !== 'Admin') {
    header("Location: user_dashboard.php");
    exit();
}

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM resources WHERE id=$id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    $stmt = $conn->prepare(
        "UPDATE resources 
         SET name=?, type=?, location=?, status=? 
         WHERE id=?"
    );

    $stmt->bind_param("ssssi", $name, $type, $location, $status, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=updated");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Resource</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-page">

<div class="login-box">

    <h2>Edit Resource</h2>

    <form method="POST">

        <input type="text" name="name" value="<?php echo $data['name']; ?>" class="form-control"><br>
        <input type="text" name="type" value="<?php echo $data['type']; ?>" class="form-control"><br>
        <input type="text" name="location" value="<?php echo $data['location']; ?>" class="form-control"><br>

        <select name="status" class="form-control">
            <option <?php if($data['status']=='Available') echo 'selected'; ?>>Available</option>
            <option <?php if($data['status']=='In Use') echo 'selected'; ?>>In Use</option>
            <option <?php if($data['status']=='Maintenance') echo 'selected'; ?>>Maintenance</option>
        </select><br>

        <button class="btn btn-primary">Update</button>

    </form>

</div>

</body>
</html>