<?php
include "config.php";
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'Invalid CSRF token.';
    } else {
        $medicine_id = (int)$_POST["medicine_id"];
        $qty = (int)$_POST["qty"];
        $address = mysqli_real_escape_string($conn, $_POST["address"]);

        $m = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM medicines WHERE id=$medicine_id"));
        $total = $m["price"] * $qty;

        $sql = "INSERT INTO orders (user_id, medicine_id, quantity, total, address)
                VALUES ('$user_id', '$medicine_id', '$qty', '$total', '$address')";
        mysqli_query($conn, $sql);

        $success = "Order Placed!";
    }
}

$meds = mysqli_query($conn, "SELECT * FROM medicines");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Medicine</title>

<style>
/* COMMON DASHBOARD STYLES */
body {

    font-family: Arial, sans-serif;
    margin: 0;
    display: flex;
    background: #f6f9fc;
}

.sidebar {
    width: 230px;
    padding: 20px;
    background: white;
    height: 100vh;
    border-right: 1px solid #eee;
}

.sidebar ul { list-style: none; padding: 0; }
.sidebar ul li {
    padding: 12px;
    margin: 8px 0;
    cursor: pointer;
}
.sidebar ul .active {
    background: #eef5ff;
    border-radius: 8px;
}

.settings { margin-top: 40px; }
.logout { color: red; cursor: pointer; }

.main {
    flex: 1;
    padding: 30px;
}

.box {
    background: white;
    padding: 25px;
    border-radius: 12px;
    max-width: 600px;
}

.box h2 {
    margin-top: 0;
    margin-bottom: 20px;
}

input, select, textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 8px;
}

button {
    background: #6a4df5;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}
button:hover {
    background: #533ada;
}

.success-box {
    background: #e7f8ec;
    border-left: 5px solid #46b96d;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 8px;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Medicare</h2>
    <ul>
        <li onclick="window.location='dashboard.php'">Dashboard</li>
        <li onclick="window.location='appointment.php'">Appointments</li>
        <li class="active">Pharmacy</li>
        <li onclick="window.location='reports.php'">Reports</li>
        <li onclick="window.location='ai_checker.php'">AI Analysis</li>
    </ul>

    <div class="settings">
        <p onclick="window.location='profile.php'">Profile</p>
        <p class="logout" onclick="window.location='logout.php'">Logout</p>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="box">

        <?php if (!empty($success)): ?>
            <div class="success-box"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <h2>Order Medicine</h2>

        <form method="POST">
            <label>Medicine</label>
            <select name="medicine_id">
                <?php while ($m = mysqli_fetch_assoc($meds)) { ?>
                    <option value="<?= $m['id'] ?>"><?= $m['name'] ?> (₹<?= $m['price'] ?>)</option>
                <?php } ?>
            </select>

            <label>Quantity</label>
            <input type="number" name="qty" min="1" required>

            <label>Delivery Address</label>
            <textarea name="address" required></textarea>

            <button type="submit">Place Order</button>
        </form>

    </div>

</div>

</body>
</html>
