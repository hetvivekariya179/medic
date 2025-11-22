<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Medic2</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-white shadow">
  <div class="max-w-7xl mx-auto px-4 py-4">
    <a href="dashboard.php" class="text-xl font-semibold text-indigo-600">Medic2</a>
  </div>
</nav>
<main class="<?php echo isset($main_class) ? $main_class : 'max-w-md mx-auto mt-10 p-6'; ?>">
