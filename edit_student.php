<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_system"; // change to your actual database name

include 'auth_check.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("Student ID not provided.");
}

$id = $_GET['id'];

// Fetch existing student data
$sql = "SELECT * FROM students WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Student not found.");
}

$row = $result->fetch_assoc();

// If form submitted, update record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $course = $conn->real_escape_string($_POST['course']);
    $date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);
    $address = $conn->real_escape_string($_POST['address']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $parent_number = $conn->real_escape_string($_POST['parent_number']);
    
    $update = "UPDATE students 
               SET student_name='$name', email='$email', phone='$phone', course='$course', date_of_birth='$date_of_birth', address='$address', gender='$gender', parent_number='$parent_number'
               WHERE id='$id'";

    if ($conn->query($update) === TRUE) {
        echo "<script>alert('Record updated successfully'); window.location='view_students.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Student</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    form {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        width: 400px;
    }
    input, select, button {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        background: #007bff;
        border: none;
        color: white;
        cursor: pointer;
    }
    button:hover {
        background: #0056b3;
    }
</style>
</head>
<body>

<form method="POST">
    <h2>Edit Student</h2>
    <label>ID:</label>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" required>

    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $row['student_name']; ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo $row['phone']; ?>" required>

    <label for="course">Course:</label>
                <select id="course" name="course">
                    <option value="">Select Course</option>
                    <option value="Computer Science" <?php if($row['course'] == 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                    <option value="Information Technology" <?php if($row['course'] == 'Information Technology') echo 'selected'; ?>>Information Technology</option>
                    <option value="Software Engineering" <?php if($row['course'] == 'Software Engineering') echo 'selected'; ?>>Software Engineering</option>
                    <option value="Data Science" <?php if($row['course'] == 'Data Science') echo 'selected'; ?>>Data Science</option>
                    <option value="Web Development" <?php if($row['course'] == 'Web Development') echo 'selected'; ?>>Web Development</option>
                </select>

    <label>Date of Birth:</label>
    <input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" required>

    <label>Address:</label>
    <input type="text" name="address" value="<?php echo $row['address']; ?>" required>

    <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="">Select Gender</option>
                    <option value="Male" <?php if($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                </select>

    <label>Parent's Number:</label>
    <input type="text" name="parent_number" value="<?php echo $row['parent_number']; ?>" required>

    <button type="submit">Update</button>
</form>

</body>
</html>

