<?php
// Run this script once to create an admin and doctor test accounts.
include 'config.php';

function create_user($conn, $username, $email, $password, $role) {
    $exists = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email='" . mysqli_real_escape_string($conn,$email) . "'"));
    if ($exists) return false;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('" . mysqli_real_escape_string($conn,$username) . "','" . mysqli_real_escape_string($conn,$email) . "','" . mysqli_real_escape_string($conn,$hash) . "','" . mysqli_real_escape_string($conn,$role) . "')";
    return mysqli_query($conn, $sql);
}

$createdAdmin = create_user($conn, 'Admin User', 'admin@example.com', 'Admin@123', 'admin');
$createdDoctor = create_user($conn, 'Dr. Smith', 'doc@example.com', 'Doctor@123', 'doctor');

echo "Create admin: " . ($createdAdmin ? 'OK' : 'Already exists or failed') . "<br>";
echo "Create doctor: " . ($createdDoctor ? 'OK' : 'Already exists or failed') . "<br>";
echo "\nAfter running, you can log in as admin@example.com / Admin@123 and doc@example.com / Doctor@123.\n";

?>
