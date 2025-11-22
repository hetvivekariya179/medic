<?php
session_start();
session_destroy();
include 'header.php';
?>
<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 text-center">
	<h2 class="text-2xl font-semibold mb-6 text-gray-800">You have been logged out.</h2>
	<a href="login.php" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Login Again</a>
</div>
<?php include 'footer.php'; ?>
