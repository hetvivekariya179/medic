<?php
include "config.php";
include 'auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'Invalid CSRF token.';
    } else {

        $role = $_POST["role"];  // patient or doctor
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        if ($role === "patient") {

            // INSERT INTO USERS TABLE
            $sql = "INSERT INTO users (username, email, password, role) 
                    VALUES ('$username', '$email', '$password', 'patient')";

            if (mysqli_query($conn, $sql)) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $error = mysqli_error($conn);
            }

        } elseif ($role === "doctor") {

            // INSERT INTO DOCTORS TABLE
            $sql = "INSERT INTO doctors (name, email, password) 
                    VALUES ('$username', '$email', '$password')";

            if (mysqli_query($conn, $sql)) {
                header("Location: doctor_panel.php?registered=1");
                exit;
            } else {
                $error = mysqli_error($conn);
            }

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register – Medicare</title>

<style>
body {
    background: #f6f9fc;
    font-family: Arial, sans-serif;
    margin: 0;
}

.container {
    width: 380px;
    margin: 60px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

h2 {
    margin-bottom: 20px;
    color: #1e293b;
    font-size: 24px;
}

input, select {
    width: 100%;
    padding: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    margin-bottom: 18px;
}

button {
    width: 100%;
    padding: 12px;
    background: #2563eb;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #1d4ed8;
}

.alert-error {
    background: #fde7e9;
    padding: 10px;
    border-left: 4px solid #ef4444;
    margin-bottom: 15px;
    border-radius: 6px;
}

a {
    color: #2563eb;
    text-decoration: none;
    font-size: 14px;
}
a:hover { text-decoration: underline; }
</style>

</head>

<body>

<div class="container">

<?php if (!empty($error)): ?>
    <div class="alert-error">
        Error: <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<h2>Create Account</h2>

<form method="POST">

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">

    <!-- USERNAME -->
    <input name="username" placeholder="Username" required>

    <!-- EMAIL -->
    <input name="email" type="email" placeholder="Email address" required>

    <!-- PASSWORD -->
    <input type="password" name="password" placeholder="Password" required>

    <!-- ROLE SELECTION -->
    <select name="role" required>
        <option value="">Select Role</option>
        <option value="patient">Register as Patient</option>
        <option value="doctor">Register as Doctor</option>
    </select>

    <button type="submit">Register</button>

</form>

<p style="margin-top: 10px; text-align:center;">
    Already have an account? <a href="login.php">Login</a>
</p>

</div>

</body>
</html>
