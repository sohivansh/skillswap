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

$user_id = $_SESSION['user_id'];
$request_id = $_POST['request_id'] ?? 0;
$action = $_POST['action'] ?? '';

// Validate input
if (!$request_id || !in_array($action, ['accept', 'reject'])) {
    header("Location: requests.php?error=Invalid request");
    exit();
}

// Check if user owns this request
$check_sql = "SELECT * FROM swap_requests WHERE id = ? AND requested_id = ? AND status = 'Pending'";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $request_id, $user_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: requests.php?error=Invalid request");
    exit();
}

// Update request status
$new_status = $action === 'accept' ? 'Accepted' : 'Rejected';
$sql = "UPDATE swap_requests SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_status, $request_id);

if ($stmt->execute()) {
    header("Location: requests.php?success=Request " . strtolower($new_status));
} else {
    header("Location: requests.php?error=Failed to " . $action . " request");
}
exit(); 