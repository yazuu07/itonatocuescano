<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $contact_number = $_POST['contact_number']; // Ensure this matches the database column

    try {
        $stmt = $pdo->prepare("UPDATE admin1 SET user = ?, email = ?, role = ?, contact_number = ? WHERE id = ?");
        $stmt->execute([$username, $email, $role, $contact_number, $id]);

        // Redirect back to dashboard
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error updating user: " . $e->getMessage());
    }
}
?>
