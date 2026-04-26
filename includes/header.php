<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YESEFERSEW Journal | Contemporary Art & Discourse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-white text-gray-900">
    <!-- Navigation -->
    <nav class="border-b sticky top-0 bg-white z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold tracking-tighter serif">YESEFERSEW</a>

            <div class="hidden md:flex space-x-8 text-sm uppercase tracking-widest font-semibold">
                <a href="sections.php?slug=essays" class="hover:text-indigo-600 transition">Essays</a>
                <a href="sections.php?slug=interviews" class="hover:text-indigo-600 transition">Interviews</a>
                <a href="sections.php?slug=curatorial" class="hover:text-indigo-600 transition">Curatorial</a>
                <a href="calls.php" class="hover:text-indigo-600 transition">Calls</a>
                <a href="membership.php" class="hover:text-indigo-600 transition">Network</a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="admin/login.php" class="text-xs text-gray-400 hover:text-gray-600">Admin</a>
                <button class="md:hidden"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </nav>
