<?php
include 'auth_check.php';
include 'config.php';

// Only admin can access this page
if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Only admin can create new users.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($conn->real_escape_string($_POST['password']));
    $role = $conn->real_escape_string($_POST['role']);

    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        $msg = "⚠️ Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($conn->query($sql)) {
            $msg = "✅ User created successfully!";
        } else {
            $msg = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add User</title>
<style>
body { font-family: Arial; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
form { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 350px; }
input, select, button , .btn{ width: 100%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc; }
button, .btn{ background: #28a745; color: white; border: none; cursor: pointer; }
button:hover { background: #218838; }
p { font-size: 14px; color: #333; }
</style>
</head>
<body>
    <button onclick="window.location.href='index.php'" 
        class="btn" 
        style="position: absolute; width:120px; margin:5px; top: 20px; right: 20px; padding: 10px 30px; cursor: pointer;">
    🏠 Home
</button>

<form method="POST">
    <h2>Add New User</h2>
    <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>
    
    <label>Username (e.g. R25016):</label>
    <input type="text" name="username" required>
    
    <label>Password:</label>
    <input type="password" name="password" required>
    
    <label>Role:</label>
    <select name="role" required>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
        <option value="student">Student</option>
    </select>
    
    <button type="submit">Create User</button>
</form>
</body>
</html>
