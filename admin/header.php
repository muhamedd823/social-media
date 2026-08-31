<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YESEFERSEW</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6">
                <h1 class="text-xl font-bold tracking-wider">YESEFERSEW</h1>
                <p class="text-xs text-indigo-300 mt-1 uppercase">Admin Portal</p>
            </div>
            <nav class="flex-grow">
                <ul class="space-y-1 px-4">
                    <li>
                        <a href="index.php" class="flex items-center p-3 rounded hover:bg-indigo-800 transition <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-indigo-800' : ''; ?>">
                            <i class="fas fa-home mr-3 w-5"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="articles.php" class="flex items-center p-3 rounded hover:bg-indigo-800 transition <?php echo basename($_SERVER['PHP_SELF']) == 'articles.php' ? 'bg-indigo-800' : ''; ?>">
                            <i class="fas fa-newspaper mr-3 w-5"></i> Articles
                        </a>
                    </li>
                    <li>
                        <a href="calls.php" class="flex items-center p-3 rounded hover:bg-indigo-800 transition <?php echo basename($_SERVER['PHP_SELF']) == 'calls.php' ? 'bg-indigo-800' : ''; ?>">
                            <i class="fas fa-file-contract mr-3 w-5"></i> Call for Papers
                        </a>
                    </li>
                    <li>
                        <a href="memberships.php" class="flex items-center p-3 rounded hover:bg-indigo-800 transition <?php echo basename($_SERVER['PHP_SELF']) == 'memberships.php' ? 'bg-indigo-800' : ''; ?>">
                            <i class="fas fa-users mr-3 w-5"></i> Memberships
                        </a>
                    </li>
                    <li>
                        <a href="subscribers.php" class="flex items-center p-3 rounded hover:bg-indigo-800 transition <?php echo basename($_SERVER['PHP_SELF']) == 'subscribers.php' ? 'bg-indigo-800' : ''; ?>">
                            <i class="fas fa-envelope mr-3 w-5"></i> Subscribers
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-4 border-t border-indigo-800">
                <a href="logout.php" class="flex items-center p-3 rounded hover:bg-red-800 transition text-red-200">
                    <i class="fas fa-sign-out-alt mr-3 w-5"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow overflow-y-auto">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center md:hidden">
                 <h1 class="text-xl font-bold text-indigo-900">YESEFERSEW</h1>
                 <button class="text-gray-500 focus:outline-none">
                     <i class="fas fa-bars text-2xl"></i>
                 </button>
            </header>

            <div class="p-8">
