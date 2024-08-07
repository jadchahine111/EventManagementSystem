<?php
// Include your configuration file if you create one
// require_once 'config.php';

// Database connection parameters
$servername = "localhost";
$username = "jadchahine";
$password = "jadali123";
$dbname = "evlu";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select the created database
$conn->select_db($dbname);

// Insert a user
$user_first_name = "John";
$user_last_name = "Doe";
$user_email = "john.doe@example.com";
$user_password = password_hash("user_password", PASSWORD_DEFAULT);
$user_phone_number = 1234567890; // Update with the actual phone number
$user_faculty = "Engineering";
$user_major = "Computer Engineering";
$user_file_no = 12345;
$user_code = 1; // Assuming 1 for regular users

// Use prepared statement to prevent SQL injection
$sql_insert_user = $conn->prepare("
    INSERT INTO Users (first_name, last_name, email, password, file_no, phone_number, faculty, major, is_admin, code, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?, 'verified')");

// Check for errors in prepare
if (!$sql_insert_user) {
    die("Error in prepare: " . $conn->error);
}

$sql_insert_user->bind_param("ssssisssi", $user_first_name, $user_last_name, $user_email, $user_password, $user_file_no, $user_phone_number, $user_faculty, $user_major, $user_code);

// Check for errors in bind_param
if ($sql_insert_user->errno) {
    die("Error in bind_param: " . $sql_insert_user->error);
}

if ($sql_insert_user->execute()) {
    echo "User inserted successfully\n";
} else {
    echo "Error inserting user: " . $sql_insert_user->error . "\n";
}

// Close prepared statement
$sql_insert_user->close();

// Insert an organizer
$organizer_type = "individual"; // or "organization"
$organization_name = "Example Organization";
$organizer_email = "org@example.com";
$organizer_password = password_hash("org_password", PASSWORD_DEFAULT);
$organizer_phone_number = 9876543210; // Update with the actual phone number
$organizer_code = 0; // Assuming 0 for organizers

// Use prepared statement to prevent SQL injection
$sql_insert_organizer = $conn->prepare("
    INSERT INTO Organizers (organizer_type, organization_name, email, password, phone_number, code, is_verified, status)
    VALUES (?, ?, ?, ?, ?, ?, 0, 'verified')");

// Check for errors in prepare
if (!$sql_insert_organizer) {
    die("Error in prepare: " . $conn->error);
}

$sql_insert_organizer->bind_param("ssssii", $organizer_type, $organization_name, $organizer_email, $organizer_password, $organizer_phone_number, $organizer_code);

// Check for errors in bind_param
if ($sql_insert_organizer->errno) {
    die("Error in bind_param: " . $sql_insert_organizer->error);
}

if ($sql_insert_organizer->execute()) {
    echo "Organizer inserted successfully\n";
} else {
    echo "Error inserting organizer: " . $sql_insert_organizer->error . "\n";
}

// Close prepared statement
$sql_insert_organizer->close();

// Close connection
$conn->close();
?>
