<?php
include "config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $role = $_POST["role"]; 
    $email = $_POST["email"];
    $password = $_POST["password"];

    // --------------------------------------------------------
    // 🔥 LOGIN FOR DOCTOR
    // --------------------------------------------------------
    if ($role === "doctor") {

        $query = mysqli_query($conn, "SELECT * FROM doctors WHERE email='$email'");
        $doctor = mysqli_fetch_assoc($query);

        if ($doctor && password_verify($password, $doctor["password"])) {
            $_SESSION["doctor_id"] = $doctor["id"];
            $_SESSION["role"] = "doctor";

            header("Location: doctor_panel.php");
            exit;
        } else {
            $error = "Invalid doctor login!";
        }

    }
    // --------------------------------------------------------
    // 🔥 LOGIN FOR PATIENT & ADMIN
    // --------------------------------------------------------
    else {

        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $user = mysqli_fetch_assoc($query);

        if ($user && password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] === "admin") {
                header("Location: admin_panel.php");
            } elseif ($user["role"] === "patient") {
                header("Location: dashboard.php");
            }

            exit;
        } 
        else {
            $error = "Invalid login details!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medic | Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* LEFT SIDE */
        .left {
            flex: 1;
            background: url('p2.jpg') center/cover no-repeat;
            position: relative;
        }

        .left::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 110, 255, 0.75);
        }

        .left-content {
            position: absolute;
            top: 50%;
            left: 50px;
            transform: translateY(-50%);
            color: white;
            width: 60%;
        }

        .left-content h1 {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .left-content p {
            font-size: 15px;
            line-height: 1.6;
        }

        /* RIGHT SIDE */
        .right {
            flex: 1;
            background: #fff;
            padding: 60px;
            display: flex;
            align-items: center;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            margin: auto;
        }

        h2 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        p.subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        /* ROLE TABS */
        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .tabs div {
            cursor: pointer;
            font-weight: 500;
            padding-bottom: 6px;
            color: #666;
        }

        .active-tab {
            border-bottom: 3px solid #007bff;
            color: #007bff;
        }

        /* INPUTS */
        input {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
        }

        /* BUTTON */
        .btn {
            width: 100%;
            padding: 14px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 18px;
            cursor: pointer;
        }

        .btn:hover {
            background: #0066e6;
        }

        /* SOCIAL LOGIN */
        .social-login {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .social-btn {
            width: 48%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            background: white;
            cursor: pointer;
        }

        .footer-links {
            text-align: center;
            font-size: 13px;
            margin-top: 20px;
        }

        .error-box {
            background: #ffe5e5;
            padding: 12px;
            color: #cc0000;
            border-radius: 8px;
            border: 1px solid #ffb3b3;
            margin-bottom: 15px;
        }
    </style>

    <script>
        function switchTab(role) {
            document.getElementById("roleType").value = role;

            document.getElementById("tab-admin").classList.remove("active-tab");
            document.getElementById("tab-doctor").classList.remove("active-tab");
            document.getElementById("tab-patient").classList.remove("active-tab");

            document.getElementById("tab-" + role).classList.add("active-tab");
        }
    </script>
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="left-content">
            <h1>Streamlining<br>Healthcare<br>Management</h1>
            <p>
                Sign in to access your personalized medical dashboard — appointments,
                medicines, doctor tools, and AI health assistant.
            </p>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="login-box">

            <h2>Welcome Back</h2>
            <p class="subtitle">Please enter your details to access your dashboard.</p>

            <!-- ERROR MESSAGE -->
            <?php if (!empty($error)): ?>
                <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- TABS -->
            <div class="tabs">
                <div id="tab-admin" class="active-tab" onclick="switchTab('admin')">Admin</div>
                <div id="tab-doctor" onclick="switchTab('doctor')">Doctor</div>
                <div id="tab-patient" onclick="switchTab('patient')">Patient</div>
            </div>

            <form method="POST">
                <input type="hidden" name="role" id="roleType" value="admin">

                <input type="email" name="email" placeholder="Email address" required>

                <input type="password" name="password" placeholder="Password" required>

                <button class="btn" type="submit">Log In</button>
            </form>

            <div class="social-login">
                <div class="social-btn">Microsoft</div>
                <div class="social-btn">Google</div>
            </div>

            <div class="footer-links">
                Don’t have an account? <a href="register.php">Create one</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
