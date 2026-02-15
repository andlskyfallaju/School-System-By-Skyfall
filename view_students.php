<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function searchTable() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toUpperCase();
            let table = document.getElementById('studentTable');
            let tr = table.getElementsByTagName('tr');
            
            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < td.length - 1; j++) {
                    if (td[j]) {
                        let txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
        
        function confirmDelete(id, name) {
            if (confirm('Are you sure you want to delete ' + name + "?")) {
                window.location.href = "delete_student.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>All Students</h1>
        
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="add_student.php">Add Student</a>
            <a href="view_students.php">View Students</a>
        </div>
        
        <div class="search-box">
            <input type="text" id="searchInput" onkeyup="searchTable()" 
                   placeholder="🔍 Search by name, email, phone, or course...">
        </div>
        
        <?php
        $sql = "SELECT * FROM students ORDER BY created_at DESC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;'>";
            echo "<p style='color: #666;'>Total Students: <strong>" . $result->num_rows . "</strong></p>";
            echo "<a href='export_students.php' style='background: #28a745; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none;'>⬇️ Download CSV</a>";
            echo "</div>";

            echo "<table id='studentTable'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Phone</th>";
            echo "<th>Course</th>";
            echo "<th>Address</th>";
            echo "<th>Gender</th>";
            echo "<th>Parent Number</th>";
            echo "<th>DOB</th>";
            echo "<th>Registered</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['student_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['course'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['parent_number'] . "</td>";
                echo "<td>" . $row['date_of_birth'] . "</td>";
                echo "<td>" . date('M d, Y', strtotime($row['created_at'])) . "</td>";
                echo "<td>";
                echo '<a href="edit_student.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>';
                if ($_SESSION['role'] === 'admin') {
                    echo "<a href='#' class='delete-btn' onclick='confirmDelete(\"" . $row['id'] . "\", \"" . $row['student_name'] . "\")'>Delete</a>";
}
                echo "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<div style='text-align: center; padding: 50px; color: #999;'>";
            echo "<h2>No students registered yet</h2>";
            echo "<p>Click 'Add Student' to register your first student!</p>";
            echo "</div>";
        }
        
        $conn->close();
        ?>
    </div>
</body>
</html>
