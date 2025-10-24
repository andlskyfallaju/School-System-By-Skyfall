<?php
include 'config.php';

// Get total number of students
$total_students_query = $conn->query("SELECT COUNT(*) AS total FROM students");
$total_students = $total_students_query->fetch_assoc()['total'];

// Get number of students per course
$course_query = $conn->query("SELECT course, COUNT(*) AS count FROM students GROUP BY course");

// Get most popular course
$popular_course_query = $conn->query("
    SELECT course, COUNT(*) AS count 
    FROM students 
    GROUP BY course 
    ORDER BY count DESC 
    LIMIT 1
");
$popular_course = $popular_course_query->num_rows > 0 ? $popular_course_query->fetch_assoc()['course'] : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .stats {
            margin-top: 30px;
            background: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .stats h3 {
            margin-bottom: 10px;
        }
        .stats table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats th, .stats td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .stats th {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 School Management System</h1>
        
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="add_student.php">Add Student</a>
            <a href="view_students.php">View Students</a>
        </div>
        
        <div class="home-section">
            <h2>Welcome to the School Management System</h2>
            <p>Manage student records efficiently with our system.</p>
            
            <a href="add_student.php" class="btn">➕ Add New Student</a>
            <a href="view_students.php" class="btn">👥 View All Students</a>
            <a href="logout.php" class="btn" style="color:red;">Logout</a>

        </div>

        <div class="stats">
            <h2>📊 System Statistics</h2>
            <p><strong>Total Students:</strong> <?php echo $total_students; ?></p>
            <p><strong>Most Popular Course:</strong> <?php echo $popular_course; ?></p>

            <h3>Students per Course:</h3>
            <table>
                <tr>
                    <th>Course</th>
                    <th>Number of Students</th>
                </tr>
                <?php
                if ($course_query->num_rows > 0) {
                    while ($row = $course_query->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['course'] . "</td>";
                        echo "<td>" . $row['count'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' style='text-align:center;'>No data available</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
