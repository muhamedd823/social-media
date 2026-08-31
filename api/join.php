<?php
require_once '../includes/db.php';
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? 'Artist';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $details = $_POST['details'] ?? '';

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $db->prepare("INSERT INTO memberships (type, name, email, details) VALUES (?, ?, ?, ?)");
            $stmt->execute([$type, $name, $email, $details]);
            $msg = "Application submitted successfully!";
            $sub = "Our team will review your information and get back to you soon.";
        } catch (PDOException $e) {
            $msg = "An error occurred.";
            $sub = "Please try again later.";
        }
    } else {
        $msg = "Incomplete information.";
        $sub = "Please fill out all required fields.";
    }
} else {
    header("Location: ../membership.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-12 rounded-3xl shadow-xl text-center max-w-md">
        <div class="text-green-500 text-6xl mb-6">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="text-3xl font-bold mb-4"><?php echo $msg; ?></h1>
        <p class="text-gray-600"><?php echo $sub; ?></p>
        <a href="../membership.php" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold mt-8">Return to Networks</a>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
