<?php
include 'config.php';
include 'auth_check.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    
    if ($stmt->execute()) {
        header("Location: view_students.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
}

$conn->close();
header("Location: view_students.php");
exit();
?>


