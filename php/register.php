<?php
$conn = new mysqli('localhost', 'root', '', 'student_demo');

// Validate inputs
$student_id = $_POST['student_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$project_title = $_POST['project_title'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$time_slot = $_POST['time_slot'];

// Check if student is already registered
$result = $conn->query("SELECT * FROM registrations WHERE student_id = '$student_id'");
if ($result->num_rows > 0) {
    echo "You are already registered! Do you want to update your registration?";
} else {
    // Register the student
    $stmt = $conn->prepare("INSERT INTO registrations (student_id, first_name, last_name, project_title, email, phone_number, time_slot) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssi", $student_id, $first_name, $last_name, $project_title, $email, $phone_number, $time_slot);
    $stmt->execute();

    // Update the time slot availability
    $conn->query("UPDATE time_slots SET seats_remaining = seats_remaining - 1 WHERE id = '$time_slot'");

     // Redirect to the display page
     header("Location: display.php");
     exit(); // Ensure no further code is executed after redirect
 
}

// Validate first name and last name
if (!preg_match("/^[A-Za-z\s-]+$/", $first_name) || !preg_match("/^[A-Za-z\s-]+$/", $last_name)) {
    die("Invalid name. Names can only contain letters, spaces, or hyphens.");
}

// Validate student ID
if (!preg_match("/^\d{8}$/", $student_id)) {
    die("Invalid Student ID. It must be exactly 8 numeric digits.");
}

// Validate email
if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]{1,20}(\.[a-zA-Z0-9-]{1,20}){1,3}$/", $email)) {
    die("Invalid email address.");
}

// Validate phone number
if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phone_number)) {
    die("Invalid phone number. Format must be 999-999-9999.");
}

?>
