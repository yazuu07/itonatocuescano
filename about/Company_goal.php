<?php
session_start();

// Restrict access to only admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/whitemanBLACK/CSS/fonts.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
    background: linear-gradient(to right,rgb(144, 105, 6),rgb(0, 0, 0)); /* Gradient background */
    padding: 1.5rem;
    height: 100vh;
        }
        aside li a:hover {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-stone-900 h-screen p-6 text-white fixed left-0 top-0">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            <nav>
                <ul>
                    <li class="py-3"><a href="/whitemanBLACK/Admin_dashboard.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Home</a></li>
                    <li class="py-3"><a href="Company_mission.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Mission</a></li>
                    <li class="py-3"><a href="Company_vision.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Vision</a></li>
                    <li class="py-3"><a href="Company_goal.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Goal</a></li>
                    <li class="py-3"><a href="logout.php" class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Logout</a></li>
                </ul>
            </nav>
        </aside>

     
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="max-w-4xl mx-auto text-center bg-white text-gray-900 p-10 rounded-lg shadow-lg">
                <h1 class="text-4xl font-bold text-stone-900 mb-6">Our Goal</h1>
                <p class="text-lg leading-relaxed">
                    "At <span class="font-semibold"><a class="transition duration-300 ease-in-out hover:bg-yellow-800 text-xl rounded" href="https://www.facebook.com/systechintegration">Systech Integration & Security Solutions, Inc.</a></span>, we envision a future where 
                    <span class="text-yellow-600 font-semibold">innovation and excellence</span> redefine industry standards. 
                    Our goal is to <span class="text-yellow-600 font-semibold">empower individuals and businesses</span> by 
                    providing cutting-edge solutions, fostering creativity, and driving 
                    <span class="text-yellow-600 font-semibold">sustainable growth</span>. 
                    Through collaboration, integrity, and relentless pursuit of excellence, we aim to be the leading force shaping a brighter, more connected tomorrow."
                </p>
            </div>
        </main>
    </div>
    </div>
</body>
</html>
