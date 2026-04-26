<?php
require_once '../includes/db.php';
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $db->prepare("INSERT INTO subscribers (email) VALUES (?)");
            $stmt->execute([$email]);
            $msg = "Success! You have been subscribed.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $msg = "You are already subscribed.";
            } else {
                $msg = "An error occurred. Please try again.";
            }
        }
    } else {
        $msg = "Please provide a valid email address.";
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-12 rounded-3xl shadow-xl text-center max-w-md">
        <div class="text-indigo-600 text-6xl mb-6">
            <i class="fas fa-paper-plane"></i>
        </div>
        <h1 class="text-3xl font-bold mb-4"><?php echo $msg; ?></h1>
        <a href="../index.php" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold mt-6">Back to YESEFERSEW</a>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
