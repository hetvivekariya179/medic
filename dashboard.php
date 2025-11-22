<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Example backend data (replace with DB queries)
$doctorName = "Welcome User";
$reports = [
    ["name" => "vishva parmar", "date" => "Oct 24, 2023", "type" => "Blood Test", "status" => "Normal"],
    ["name" => "krishna gondaliya", "date" => "Oct 23, 2023", "type" => "X-Ray", "status" => "Pending"],
    ["name" => "khushi undhiya", "date" => "Oct 22, 2023", "type" => "MRI Scan", "status" => "Critical"],
];

$upcoming = [
    ["date" => "OCT 25", "title" => "Dr. smit joshi", "desc" => "General Checkup • 09:00 AM"],
    ["date" => "OCT 25", "title" => "Dr. priya desai", "desc" => "Dental Surgery • 11:30 AM"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medicare Dashboard</title>

<style>
/* ======================= GENERAL ========================== */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
:root{
  --bg:#f6f9fc;
  --card:#ffffff;
  --muted:#6b7280;
  --accent:#4f46e5;
}
body {
    font-family: 'Inter', system-ui, Arial, sans-serif;
    margin: 0;
    display: flex;
    background: var(--bg);
    color: #111827;
}

/* ======================= SIDEBAR ========================== */
.sidebar {
    width: 260px;
    padding: 28px 20px;
    background: var(--card);
    height: 100vh;
    border-right: 1px solid #eef2f7;
    box-shadow: 0 4px 18px rgba(15,23,42,0.03);
    position: sticky;
    top: 0;
}
.sidebar h2{ font-size:20px; margin-bottom:14px; }
.sidebar ul { list-style: none; padding: 0; margin: 0; }
.sidebar ul li {
    padding: 12px 14px;
    margin: 8px 0;
    cursor: pointer;
    border-radius: 8px;
    color: var(--muted);
    display:flex; align-items:center; gap:10px;
    transition: all .15s ease-in-out;
}
.sidebar ul li:hover{ background:#f3f6ff; transform:translateY(-2px); color:var(--accent); }
.sidebar ul .active { background: linear-gradient(90deg, rgba(79,70,229,0.08), rgba(79,70,229,0.02)); color:var(--accent); font-weight:600; }
.sidebar .logo { font-weight:700; color:var(--accent); margin-bottom:8px; }
.settings { margin-top: 46px; }
.settings p { padding: 10px 0; cursor: pointer; color:var(--muted); }
.logout { color: #ef4444; }

/* ======================= MAIN DASHBOARD AREA ========================== */
.main { flex: 1; padding: 28px; min-height:100vh; }
header h3{ margin:0; font-size:20px; }
header small{ color:var(--muted); }

.cards{ display:flex; gap:18px; margin:18px 0; flex-wrap:wrap; }
.card{ background:var(--card); padding:18px; border-radius:12px; flex:1; text-align:center; font-weight:600; cursor:pointer; box-shadow:0 6px 18px rgba(15,23,42,0.04); transition:transform .15s ease, box-shadow .15s ease; }
.card:hover{ transform:translateY(-6px); box-shadow:0 12px 30px rgba(15,23,42,0.08); }
.card .muted{ color:var(--muted); font-weight:500; font-size:13px; }
.card.highlight{ background: linear-gradient(45deg,#6a4df5,#7d63ff); color:white; }

/* ======================= TABLE ========================== */
table{ width:100%; border-collapse:collapse; margin-top:14px; background:transparent; }
table th, table td{ padding:12px 14px; border-bottom:1px solid #f1f5f9; text-align:left; }
table thead th{ color:var(--muted); font-weight:600; font-size:13px; }
table tbody tr:hover{ background:#fff; }
.status-badge{ display:inline-block; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:600; }
.normal{ background:#ecfdf5; color:#059669; }
.pending{ background:#fffbeb; color:#d97706; }
.critical{ background:#fff1f2; color:#dc2626; }

/* ======================= UPCOMING EVENTS ========================== */
.upcoming .event{ display:flex; margin:14px 0; align-items:center; }
.upcoming .date{ background:#eef2ff; padding:10px 12px; border-radius:10px; margin-right:12px; font-weight:700; color:var(--accent); }

/* RESPONSIVE */
@media (max-width: 900px){
  .sidebar{ display:none; }
  body{ display:block; }
  .main{ padding:18px; }
  .cards{ grid-template-columns: 1fr; }
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Medicare</h2>
    <ul>
        <li class="active">Dashboard</li>
        <li onclick="window.location='appointment.php'">Appointments</li>
        <li onclick="window.location='order_medicine.php'">Pharmacy</li>
        <li>Reports</li>
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
        <h3>Hello, <?= $doctorName ?> 👋</h3>
        <small>Your health management dashboard.</small>
    </header>

    <!-- ACTION CARDS -->
    <div class="cards">
        <div class="card" onclick="window.location='appointment.php'">Book Appointment</div>
        <div class="card" onclick="window.location='order_medicine.php'">Order Medicine</div>
        <div class="card" onclick="window.location='reports.php'">Report Record</div>
        <div class="card highlight" onclick="window.location='ai_checker.php'">AI Prediction</div>
    </div>

    <!-- RECENT REPORTS -->
    <h4>Recent Reports</h4>
    <table>
        <tr>
            <th>Patient</th>
            <th>Date</th>
            <th>Type</th>
            <th>Status</th>
        </tr>

        <?php foreach ($reports as $r): ?>
        <tr>
            <td><?= $r["name"] ?></td>
            <td><?= $r["date"] ?></td>
            <td><?= $r["type"] ?></td>
            <td class="<?= strtolower($r["status"]) ?>"><?= $r["status"] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- UPCOMING -->
    <div class="upcoming">
        <h4>Upcoming</h4>
        <?php foreach ($upcoming as $u): ?>
            <div class="event">
                <span class="date"><?= $u["date"] ?></span>
                <div class="desc">
                    <strong><?= $u["title"] ?></strong><br>
                    <?= $u["desc"] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>
