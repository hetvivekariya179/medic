<?php
include 'config.php';
session_start();
// allow access when role is 'doctor' and either `user_id` (users table) or `doctor_id` (doctors table) is present
if (($_SESSION['role'] ?? '') !== 'doctor' || (empty($_SESSION['user_id']) && empty($_SESSION['doctor_id']))) {
    header('Location: login.php');
    exit;
}

// list patients
$patients = mysqli_query($conn, "SELECT id, username, email FROM users WHERE role='patient' ORDER BY username");

?>
<?php include 'header.php'; ?>

<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Doctor Panel</h2>
    <p class="mb-4 text-sm text-gray-600">View patients and their appointments.</p>

    <div class="space-y-4">
        <?php while ($p = mysqli_fetch_assoc($patients)) { ?>
            <div class="border rounded p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="font-semibold"><?= htmlspecialchars($p['username']) ?></div>
                        <div class="text-sm text-gray-600"><?= htmlspecialchars($p['email']) ?></div>
                    </div>
                    <div>
                        <a class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded" href="doctor_view_patient.php?id=<?= $p['id'] ?>">View</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include 'footer.php'; ?>
