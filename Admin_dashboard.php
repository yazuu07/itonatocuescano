<?php
session_start();

// Restrict access to only admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'db.php';

// Fetch users from the database
try {
    $stmt = $pdo->query("SELECT id, user, email, role, contact_number FROM admin1");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_id'])) {
    $deleteUserId = $_POST['delete_user_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM admin1 WHERE id = ?");
        $stmt->execute([$deleteUserId]);
        header("Location: Admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting user: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/fonts.css">
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
                    <li class="py-3"><a href="Admin_dashboard.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Home</a></li>
                    <li class="py-3"><a href="about/Company_mission.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Mission</a></li>
                    <li class="py-3"><a href="about/Company_vision.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Vision</a></li>
                    <li class="py-3"><a href="about/Company_goal.php"class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Our Goal</a></li>
                    <li class="py-3"><a href="logout.php" class="transition duration-300 ease-in-out hover:bg-yellow-700 text-xl block rounded">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="ml-64 p-8 w-full">
            <h2 class="text-3xl text-white font-bold mb-6">User Management</h2>
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-lg rounded-lg border border-gray-200">
                    <thead class="bg-stone-900 text-white text-lg">
                        <tr>
                            <th class="py-4 px-6 text-left">Username</th>
                            <th class="py-4 px-6 text-left">Email</th>
                            <th class="py-4 px-6 text-left">Role</th>
                            <th class="py-4 px-6 text-left">Contact Number</th>
                            <th class="py-4 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-4 px-6">
                                <a href="gallery.php?user=<?php echo urlencode($user['user']); ?>" class="text-black-600 hover:underline">
                                    <?php echo htmlspecialchars($user['user']); ?>
                                </a>
                            </td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($user['role']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($user['contact_number']); ?></td>
                            <td class="py-4 px-6 flex space-x-3">
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-gray-500" 
                                    onclick="editUser('<?php echo $user['id']; ?>', '<?php echo $user['user']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['role']; ?>', '<?php echo $user['contact_number']; ?>')">
                                    Edit
                                </button>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-red-700">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-bold mb-4">Edit User</h3>
            <form id="editForm" method="POST" action="update_user.php">
                <input type="hidden" id="editUserId" name="id">
                <label class="block text-gray-700">Username:</label>
                <input type="text" id="editUsername" name="username" required class="w-full border p-2 rounded mb-2">

                <label class="block text-gray-700">Email:</label>
                <input type="email" id="editEmail" name="email" required class="w-full border p-2 rounded mb-2">

                <label class="block text-gray-700">Role:</label>
                <input type="text" id="editRole" name="role" required class="w-full border p-2 rounded mb-2">

                <label class="block text-gray-700">Contact Number:</label>
                <input type="text" id="editContact" name="contact_number" required class="w-full border p-2 rounded mb-4">

                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 rounded hover:bg-red-700" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-green-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editUser(id, username, email, role, contact) {
            document.getElementById("editUserId").value = id;
            document.getElementById("editUsername").value = username;
            document.getElementById("editEmail").value = email;
            document.getElementById("editRole").value = role;
            document.getElementById("editContact").value = contact;
            document.getElementById("editModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("editModal").classList.add("hidden");
        }
    </script>
</body>
</html>
