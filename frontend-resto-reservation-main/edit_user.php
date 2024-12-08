<?php
session_start();
include 'db.php';

// Ensure only admin can access this page
if (!isset($_SESSION['username']) || $_SESSION['role'] = 'user') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if ($id === null) {
    header("Location: user_crud.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Prepare and bind statement to update user
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $role, $id);
    $stmt->execute();

    header("Location: user_crud.php");
    exit;
}

// Prepare and bind statement to fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle the case where the user is not found
if (!$user) {
    echo "User not found!";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
        <label>Role:</label>
        <select name="role">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select><br>
        <button type="submit">Update User</button>
    </form>
    <a href="user_crud.php">Back to User Management</a>
</body>
</html>
