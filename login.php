<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'includes/config.php';

$error = "";

if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] === 'Admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }

    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT id, username, password, role
         FROM users
         WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            // ✅ SESSION (VERY IMPORTANT)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // ROLE REDIRECT
            if ($user['role'] === 'Admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }

            exit();

        } else {
            $error = "Wrong password!";
        }

    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-page">

<div class="login-box">

    <div class="login-logo">
        <span class="icon">🏫</span>
        <h1>Campus Resource Tracker</h1>
        <p>Login to continue</p>
    </div>

    <?php if(!empty($error)): ?>
        <div class="alert alert-error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-full">
            Login →
        </button>

    </form>

    <p style="text-align:center;margin-top:15px;">
        New User? <a href="register.php">Register</a>
    </p>

</div>

</body>
</html>