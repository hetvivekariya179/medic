<?php
include "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// --- Doctor List (STATIC) ---
$doctors = [
    ['name' => 'Dr. A. Singh', 'specialty' => 'Cardiologist', 'img' => 'dr_singh.jpg'],
    ['name' => 'Dr. S. Khan', 'specialty' => 'Pediatrician', 'img' => 'dr_khan.jpg'],
    ['name' => 'Dr. R. Mehta', 'specialty' => 'Orthopedic Surgeon', 'img' => 'dr_mehta.jpg'],
];

// Submit Appointment Form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor = $_POST["doctor"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $symptoms = $_POST["symptoms"];

    $sql = "INSERT INTO appointments (user_id, doctor, date, time, symptoms)
            VALUES ('$user_id', '$doctor', '$date', '$time', '$symptoms')";

    if (mysqli_query($conn, $sql)) {
        $success = "Appointment Booked Successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Appointment – Medicare</title>

<style>
body {
    font-family: Inter, Arial, sans-serif;
    margin: 0;
    display: flex;
    background: #f4f7fb;
}

/* SIDEBAR */
.sidebar {
    width: 230px;
    padding: 20px;
    background: white;
    height: 100vh;
    border-right: 1px solid #eee;
}
.sidebar h2 { margin-bottom: 20px; }
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

.settings { margin-top: 50px; }
.logout { color: red; }

/* MAIN SECTION */
.main {
    flex: 1;
    padding: 30px;
}

h3 { margin: 0; }

.grid {
    display: grid;
    grid-template-columns: 1fr 330px;
    gap: 20px;
    margin-top: 20px;
}

/* CARD STYLE */
.card {
    background: white;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

input, select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #d6d9e0;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 14px;
}

button {
    padding: 12px 22px;
    border: none;
    background: #2d89ff;
    color: white;
    font-size: 15px;
    border-radius: 8px;
    cursor: pointer;
}

/* SUCCESS BOX */
.success-box {
    background: #e6ffed;
    border-left: 4px solid #28c76f;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
}

/* DOCTOR CARDS */
.doctors {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.doc-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    padding: 14px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.doc-card img {
    width: 62px;
    height: 62px;
    border-radius: 10px;
    object-fit: cover;
}
.doc-card h4 { margin: 0; font-size: 16px; }
.doc-card p { margin: 0; font-size: 13px; color: #6b7280; }

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Medicare</h2>

    <ul>
        <li onclick="window.location='dashboard.php'">Dashboard</li>
        <li class="active">Appointments</li>
        <li onclick="window.location='order_medicine.php'">Pharmacy</li>
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

    <header>
        <h3>Book Appointment</h3>
        <small>Find the right specialist and schedule a visit.</small>
    </header>

    <?php if (!empty($success)): ?>
        <div class="success-box"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="grid">

        <!-- LEFT: APPOINTMENT FORM -->
        <div class="card">
            <h2>Appointment Form</h2>
            <p style="color:#6b7280;font-size:14px;margin-top:-5px;">Fill in your symptoms & select a doctor.</p>

            <form method="POST">
                <label>Choose Doctor</label>
                <select name="doctor" required>
                    <option value="">-- Select Doctor --</option>
                    <?php foreach($doctors as $d): ?>
                        <option value="<?= $d['name'] ?>"><?= $d['name'] ?> — <?= $d['specialty'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Select Date</label>
                <input type="date" name="date" required>

                <label>Select Time</label>
                <input type="time" name="time" required>

                <label>Symptoms</label>
                <textarea name="symptoms" placeholder="Describe your symptoms..." required></textarea>

                <button type="submit">Book Appointment</button>
            </form>
        </div>

        <!-- RIGHT: DOCTOR LIST -->
        <aside class="card">
            <h3>Available Doctors</h3>
            <div class="doctors">
                <?php foreach($doctors as $d): ?>
                    <div class="doc-card">
                        <img src="<?= $d['img'] ?>" alt="doctor">
                        <div>
                            <h4><?= $d['name'] ?></h4>
                            <p><?= $d['specialty'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </aside>

    </div>
</div>

</body>
</html>
