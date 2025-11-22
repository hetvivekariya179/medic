<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symptom = strtolower($_POST["symptom"]);
    
    if (str_contains($symptom, "fever")) {
        $result = "You might have viral fever. Stay hydrated.";
    }
    else if (str_contains($symptom, "cough")) {
        $result = "You may have a chest infection. Consult doctor if severe.";
    }
    else {
        $result = "No prediction. Try describing more symptoms.";
    }
}
?>
<?php include 'header.php'; ?>

<form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">AI Health Checker</h2>
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Symptoms</label>
        <textarea name="symptom" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your symptoms"></textarea>
    </div>
    <div class="flex items-center justify-between">
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Check</button>
    </div>
</form>

<?php if (!empty($result)): ?>
  <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded mb-4">AI Result: <?php echo htmlspecialchars($result); ?></div>
<?php endif; ?>

<?php include 'footer.php'; ?>
