<?php
require_once 'includes/config.php';

$message = ""; // IMPORTANT FIX

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // check user
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Username already exists!";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO users (username, password, role)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            $message = "Registration successful! You can login now.";
        } else {
            $message = "Registration failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-page">

<div class="login-box">

    <div class="login-logo">
        <span class="icon">🎓</span>
        <h1>Create Account</h1>
        <p>Student / Teacher Registration</p>
    </div>

    <?php if(!empty($message)): ?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="form-group">
            <select name="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="Student">Student</option>
                <option value="Teacher">Teacher</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Register →
        </button>

    </form>

    <p style="text-align:center;margin-top:15px;font-size:13px;">
        Already have an account? <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>