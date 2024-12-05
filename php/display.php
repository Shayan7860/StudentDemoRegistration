<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'student_demo');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch registered students
$result = $conn->query("SELECT r.student_id, r.first_name, r.last_name, r.project_title, r.email, r.phone_number, t.date_time 
                        FROM registrations r 
                        JOIN time_slots t ON r.time_slot = t.id");

if ($result->num_rows > 0) {
    echo "<h1>Registered Students</h1>";
    echo "<table border='1'>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Project Title</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Time Slot</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['first_name']} {$row['last_name']}</td>
                <td>{$row['project_title']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone_number']}</td>
                <td>{$row['date_time']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No students have registered yet.</p>";
}
$conn->close();
?>
