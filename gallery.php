<?php
session_start();
require 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if user parameter is set
if (!isset($_GET['user'])) {
    echo "User not specified.";
    exit();
}

$username = $_GET['user'];

// Fetch user details from the database
$stmt = $pdo->prepare("SELECT * FROM admin1 WHERE user = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

// Assign user_id from fetched user details
$user_id = $user['id'];

// Fetch user's images with location, uploaded_at fields
$stmt = $pdo->prepare("SELECT image_path, location, uploaded_at FROM uploads WHERE user_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$user_id]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?>'s Gallery</title>
    <link rel="stylesheet" href="/whitemanBLACK/CSS/fonts.css">
    <script src="https://cdn.tailwindcss.com"></script>
<style>
body {
    background: linear-gradient(to right, #B8860b, #000);
}
.calendar {
    background: white;
    padding: 10px;
    border: 1px solid black;
    border-radius: 10px;
    text-align: center;
    position: absolute;
    top: 7.5px;
    right: 40px;
    width: 150px;
}
.calendar h2 {
    margin: 0;
    font-size: 14px;
}
.calendar input {
    font-size: 12px;
    margin-top: 5px;
    padding: 3px;
    width: 100%;
}
.calendar input:hover {
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
}
aside li a:hover {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
}    
/* Styling for the image overlay (this is the text displayed over the image) */
.image-container {
    position: relative;
    display: inline-block;
    width: 100%;
    border-radius: 10px;
    border: 1px solid black;
}
.image-container img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}
.image-container:hover {
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
}
.image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    font-size: 14px;
    padding: 8px;
    text-align: center;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    word-wrap: break-word; /* Ensures long text wraps */
}
/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
}
.modal img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
}
.modal .close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 30px;
    color: white;
    background: rgba(0, 0, 0, 0.5);
    border: none;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
}
    </style>
</head>
<body class="bg-gray-100 flex">
<!-- Sidebar Navigation -->
    <aside class="w-64 bg-stone-900 text-white min-h-screen p-6">
    <h2 class="text-2xl font-bold font-mono mb-9">Admin Dashboard</h2>
        <ul>
            <li class="mt-3"><a href="Admin_dashboard.php" class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Home</a></li>
            <li class="mt-6"><a href="/whitemanBLACK/about/Company_mission.php" class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Mission</a></li>
            <li class="mt-6"><a href="/whitemanBLACK/about/Company_vision.php" class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Vision</a></li>
            <li class="mt-6"><a href="/whitemanBLACK/about/Company_goal.php" class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Goal</a></li>
            <li class="mt-6"><a href="logout.php" class="transition duration-300 ease-in-out hover:bg-red-600 text-xl block rounded">Logout</a></li>
        </ul>
    </aside>
<!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-semibold mb-6"><?php echo htmlspecialchars($username); ?>'s Gallery</h1>
    <!-- Calendar in Top Right -->
        <div class="calendar">
            <h2>Select a Date</h2>
            <input type="date" id="date-picker">
        </div>
    <!-- Gallery Section -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Uploaded Images</h2>
            <?php if (count($images) > 0): ?>
                <div class="grid grid-cols-2 gap-10">
                    <!-- In Grid -->
                    <div>
                        <h3 class="text-lg font-bold mb-3">In</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($images as $image): ?>
                                <?php if ($image['location'] === 'In'): ?>
                                    <img class="image-container" src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                                         alt="In Image" 
                                         class="rounded shadow" 
                                         onclick="openModal('<?php echo htmlspecialchars($image['image_path']); ?>')">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Out Grid -->
                    <div>
                        <h3 class="text-lg font-bold mb-3">Out</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($images as $image): ?>
                                <?php if ($image['location'] === 'Out'): ?>
                                    <img class="image-container" src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                                         alt="In Image" 
                                         class="rounded shadow" 
                                         onclick="openModal('<?php echo htmlspecialchars($image['image_path']); ?>')">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Overtime Grid -->
                    <div>
                        <h3 class="text-lg font-bold mb-3">Overtime</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($images as $image): ?>
                                <?php if ($image['location'] === 'Overtime'): ?>
                                    <img class="image-container" src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                                         alt="In Image" 
                                         class="rounded shadow" 
                                         onclick="openModal('<?php echo htmlspecialchars($image['image_path']); ?>')">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Out Grid -->
                    <div>
                        <h3 class="text-lg font-bold mb-3">Undertime</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($images as $image): ?>
                                <?php if ($image['location'] === 'Undertime'): ?>
                                    <img class="image-container" src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                                         alt="In Image" 
                                         class="rounded shadow" 
                                         onclick="openModal('<?php echo htmlspecialchars($image['image_path']); ?>')">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
            <?php else: ?>
                <p class="text-gray-600">No images uploaded by <?php echo htmlspecialchars($username); ?>.</p>
            <?php endif; ?>
            <!-- Download Button -->
        <div class="excel mt-5">
    <a href="gallery.php?user=<?php echo urlencode($username); ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
        Download Excel File
    </a> </div>
    </main>
<!-- Modal for full-size image -->
    <div class="modal" id="modal">
        <button class="close-btn" onclick="closeModal()">×</button>
        <img id="modal-image" src="" alt="Full Image">
    </div>
<script>
        // JavaScript to set the current date in the calendar
        document.addEventListener('DOMContentLoaded', function() {
            const datePicker = document.getElementById('date-picker');
            const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
            datePicker.value = today; // Set the date picker to today's date
        });
        // JavaScript to filter images by selected date
        document.getElementById('date-picker').addEventListener('change', function() {
            const selectedDate = this.value; // Get selected date from the input
            const images = document.querySelectorAll('.image-container');

            images.forEach(function(image) {
                const imageDate = image.getAttribute('data-uploaded-at>').split(' ')[0]; // Extract date from uploaded_at
                if (imageDate === selectedDate) {
                    image.style.display = 'inline-block'; // Show image if it matches the selected date
                } else {
                    image.style.display = 'none'; // Hide image if it doesn't match
                }
            });
        });
        // Function to open modal with full-size image
        function openModal(imagePath) {
            const modal = document.getElementById('modal');
            const modalImage = document.getElementById('modal-image');
            modal.style.display = 'flex';
            modalImage.src = imagePath;
        }
        // Function to close modal
        function closeModal(imagePath) {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }
        
</script>
</body>
</html>