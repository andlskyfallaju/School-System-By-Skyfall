<?php
include 'config.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="students_list.csv"');

$output = fopen("php://output", "w");

// Add CSV header
fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Course', 'Address', 'Gender', 'Parent Number', 'Date of Birth', 'Registered Date']);

// Fetch data
$query = $conn->query("SELECT * FROM students ORDER BY created_at DESC");

while ($row = $query->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['student_name'],
        $row['email'],
        $row['phone'],
        $row['course'],
        $row['address'],
        $row['gender'],
        $row['parent_number'],
        $row['date_of_birth'],
        $row['created_at']
    ]);
}

fclose($output);
$conn->close();
exit;
?>
