<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Demo Registration</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <h1>Student Demo Registration</h1>
    <form method="POST" action="php/register.php">
        <label for="student_id">Student ID (8 digits):</label>
        <input type="text" id="student_id" name="student_id" required pattern="\d{8}" title="Student ID must be exactly 8 numeric digits">

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required pattern="^[A-Za-z\s-]+$" title="Name can only contain letters, spaces, or hyphens">

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required pattern="^[A-Za-z\s-]+$" title="Name can only contain letters, spaces, or hyphens">

        <label for="project_title">Project Title:</label>
        <input type="text" id="project_title" name="project_title" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]{1,20}(\.[a-zA-Z0-9-]{1,20}){1,3}$" title="Enter a valid email address with a proper domain">

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required pattern="\d{3}-\d{3}-\d{4}" title="Phone number must be in the format 999-999-9999">

        <label for="time_slot">Select a Time Slot:</label>
        <select id="time_slot" name="time_slot" required>
            <?php
// Fetch available slots from the database
$conn = new mysqli('localhost', 'root', '', 'student_demo');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, date_time, seats_remaining FROM time_slots WHERE seats_remaining > 0");
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Display available slots
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['date_time']} ({$row['seats_remaining']} seats remaining)</option>";
}
?>
        </select>

        <button type="submit">Register</button>
    </form>

    <a href="php/display.php" class="button">View Registered Students</a>
</body>
</html>
