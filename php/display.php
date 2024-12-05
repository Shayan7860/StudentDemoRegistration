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

// Begin HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Registered Students</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Project Title</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Time Slot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['student_id']) ?></td>
                            <td><?= htmlspecialchars($row['first_name'] . " " . $row['last_name']) ?></td>
                            <td><?= htmlspecialchars($row['project_title']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone_number']) ?></td>
                            <td><?= htmlspecialchars($row['date_time']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No students have registered yet.</p>
        <?php endif; ?>

        <!-- Back to Registration Button -->
        <a href="../index.php" class="button">Back to Registration</a>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
