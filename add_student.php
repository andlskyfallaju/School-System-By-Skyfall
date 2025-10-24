<?php
// Include database connection
include 'config.php';
include 'auth_check.php';

// Initialize variables
$successMessage = "";
$errorMessage = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $name = $_POST['student_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);
    $address = $conn->real_escape_string($_POST['address']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $parent_number = $conn->real_escape_string($_POST['parent_number']);
    $id = $conn->real_escape_string($_POST['id']);


    // Validate data
    if (empty($name) || empty($email) || empty($phone) || empty($course)) {
        $errorMessage = "All fields are required!";
    } else {
        // Prepare SQL to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO students (student_name, email, phone, course, date_of_birth, address, gender, parent_number, id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $email, $phone, $course, $date_of_birth, $address, $gender, $parent_number, $id);
        
        // Execute the query
        if ($stmt->execute()) {
            $successMessage = "✓ Student registered successfully!";
        } else {
            $errorMessage = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            let name = document.getElementById('student_name').value;
            let email = document.getElementById('email').value;
            let phone = document.getElementById('phone').value;
            let phone = document.getElementById('address').value;
            let phone = document.getElementById('gender').value;
            let phone = document.getElementById('parent_number').value;
            let phone = document.getElementById('id').value;
            
            if (name.trim() === "") {
                alert("Please enter student name");
                return false;
            }
            
            if (email.trim() === "") {
                alert("Please enter email");
                return false;
            }
            
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email");
                return false;
            }
            
            if (phone.trim() === "") {
                alert("Please enter phone number");
                return false;
            }

             if (address.trim() === "") {
                alert("Please enter home address");
                return false;
            }

            if (gender.trim() === "") {
                alert("Please enter gender");
                return false;
            }

            if (parent_number.trim() === "") {
                alert("Please enter parent's number");
                return false;
            }

            if (id.trim() === "") {
                alert("Please enter student ID");
                return false;
            }
            
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Add New Student</h1>
        
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="add_student.php">Add Student</a>
            <a href="view_students.php">View Students</a>
        </div>
        
        <?php if ($successMessage): ?>
            <div class="success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        
        <?php if ($errorMessage): ?>
            <div class="error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="id">Student ID:</label>
                <input type="text" name="id" required placeholder="Enter student ID">
            </div>

            <div class="form-group">
                <label for="student_name">Student Name:</label>
                <input type="text" id="student_name" name="student_name" required placeholder="Enter full name">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Enter email address">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required placeholder="Enter phone number">
            </div>
            
            <div class="form-group">
                <label for="course">Course:</label>
                <select id="course" name="course">
                    <option value="">Select Course</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Data Science">Data Science</option>
                    <option value="Web Development">Web Development</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" name="date_of_birth" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" required placeholder="Enter your home address">
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="parent_number">Parent's Number:</label>
                <input type="text" id="parent_number" name="parent_number" required placeholder="Enter parent's phone number">
            </div>
            
            <button type="submit">Register Student</button>
        </form>
    </div>
</body>
</html>
