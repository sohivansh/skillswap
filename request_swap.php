<?php
require_once "./includes/functions.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

$requester_id = $_SESSION['user_id'];
$requested_id = $_POST['user_id'] ?? 0;

// Validate input
if (!$requested_id) {
    header("Location: swaps.php?error=Invalid request");
    exit();
}

// Get database connection
$conn = get_db_connection();

// Check if request already exists
$check_sql = "SELECT id FROM swap_requests 
              WHERE requester_id = ? AND requested_id = ? AND status = 'Pending'";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $requester_id, $requested_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    $check_stmt->close();
    $conn->close();
    header("Location: swaps.php?error=Request already sent");
    exit();
}

// Create new request
$sql = "INSERT INTO swap_requests (requester_id, requested_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $requester_id, $requested_id);

if ($stmt->execute()) {
    header("Location: swaps.php?success=Request sent successfully");
} else {
    header("Location: swaps.php?error=Failed to send request");
}

$stmt->close();
$conn->close();
exit(); 