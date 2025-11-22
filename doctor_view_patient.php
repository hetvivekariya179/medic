<?php
include 'config.php';
session_start();
// allow access when role is 'doctor' and either `user_id` (users table) or `doctor_id` (doctors table) is present
if (($_SESSION['role'] ?? '') !== 'doctor' || (empty($_SESSION['user_id']) && empty($_SESSION['doctor_id']))) {
    header('Location: login.php');
    exit;
}

$patient_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$patient = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, username, email FROM users WHERE id=$patient_id AND role='patient'"));
if (!$patient) {
    echo "Patient not found.";
    exit;
}

$appointments = mysqli_query($conn, "SELECT * FROM appointments WHERE user_id=$patient_id ORDER BY date DESC, time DESC");

?>
<?php include 'header.php'; ?>

<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Patient: <?= htmlspecialchars($patient['username']) ?></h2>

    <div class="mb-6">
        <h3 class="font-semibold">Contact</h3>
        <div class="text-sm text-gray-600"><?= htmlspecialchars($patient['email']) ?></div>
    </div>

    <div>
        <h3 class="font-semibold mb-2">Appointments</h3>
        <?php if (mysqli_num_rows($appointments) === 0): ?>
            <div class="text-sm text-gray-600">No appointments found.</div>
        <?php else: ?>
            <ul class="space-y-3">
                <?php while ($a = mysqli_fetch_assoc($appointments)) { ?>
                    <li class="border p-3 rounded">
                        <div class="text-sm text-gray-700"><strong>Date:</strong> <?= htmlspecialchars($a['date']) ?> <strong>Time:</strong> <?= htmlspecialchars($a['time']) ?></div>
                        <div class="text-sm text-gray-600"><strong>Doctor:</strong> <?= htmlspecialchars($a['doctor']) ?></div>
                        <div class="mt-2 text-sm text-gray-700"><strong>Symptoms:</strong> <?= nl2br(htmlspecialchars($a['symptoms'])) ?></div>
                    </li>
                <?php } ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
