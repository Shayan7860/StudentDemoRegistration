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

    echo "Registration successful!";
}
?>
