<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT user, email, contact_number FROM admin1 WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];

    $stmt = $pdo->prepare("UPDATE admin1 SET user = ?, email = ?, contact_number = ? WHERE id = ?");
    if ($stmt->execute([$username, $email, $contact_number, $id])) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <h1>Edit User</h1>
    <form action="edit_user.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $user['user']; ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>

        <label>Contact Number:</label>
        <input type="text" name="contact_number" value="<?php echo $user['contact_number']; ?>" required><br>

        <button type="submit">Save</button>
    </form>
</body>
</html>
