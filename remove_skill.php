<?php
require_once "./includes/functions.php";

// Check if user is logged in
if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

// Validate input
if (!isset($_POST['skill_id']) || !is_numeric($_POST['skill_id'])) {
    header("Location: profile.php?error=Invalid skill ID");
    exit();
}

$skill_id = (int)$_POST['skill_id'];
$user_id = $_SESSION['user_id'];

// Connect to database
$conn = get_db_connection();

// Delete the skill from user_skills table first (due to foreign key constraint)
$stmt = $conn->prepare("DELETE FROM user_skills WHERE skill_id = ? AND user_id = ?");
$stmt->bind_param("ii", $skill_id, $user_id);

if ($stmt->execute()) {
    // Now delete from skills table
    $stmt = $conn->prepare("DELETE FROM skills WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $skill_id, $user_id);
    
    if ($stmt->execute()) {
        header("Location: profile.php?success=Skill removed successfully");
    } else {
        header("Location: profile.php?error=Failed to remove skill completely");
    }
} else {
    header("Location: profile.php?error=Failed to remove skill");
}

$stmt->close();
$conn->close(); 