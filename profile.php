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
$user_data = get_user_data($user_id);

$error_message = $_GET['error'] ?? "";
$success_message = $_GET['success'] ?? "";

// Handle skill form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['skill_name'])) {
    $skill_name = sanitize_input($_POST['skill_name']);
    $skill_type = $_POST['skill_type'] ?? '';
    
    $teach = ($skill_type === 'teach') ? 1 : 0;
    $learn = ($skill_type === 'learn') ? 1 : 0;
    
    $sql = "INSERT INTO skills (user_id, skill_name, teach, learn) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $user_id, $skill_name, $teach, $learn);
    
    if ($stmt->execute()) {
        $success_message = "Skill added successfully";
    } else {
        $error_message = "Error adding skill";
    }
}

// Get user's skills
$skills_sql = "SELECT * FROM skills WHERE user_id = ? ORDER BY skill_name";
$skills_stmt = $conn->prepare($skills_sql);
$skills_stmt->bind_param("i", $user_id);
$skills_stmt->execute();
$skills = $skills_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $bio = $_POST['bio'] ?? '';
    $bio = sanitize_input($bio);
    
    $sql = "UPDATE users SET bio = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $bio, $user_id);
    
    if ($stmt->execute()) {
        $success_message = "Profile updated successfully";
        $user_data = get_user_data($user_id); // Refresh user data
    } else {
        $error_message = "Error updating profile";
    }
}

// Add this at the top of profile.php after your session and other includes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_skill'])) {
    $skill_id = (int)$_POST['skill_id'];
    $user_id = $_SESSION['user_id'];
    
    $conn = get_db_connection();
    
    
    // Then delete from skills
    $stmt = $conn->prepare("DELETE FROM skills WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $skill_id, $user_id);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    // Redirect to refresh the page
    header("Location: profile.php?success=Skill removed successfully");
    exit();
}

include "./includes/header.php";
?>

<div class="container mt-5">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-6">
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-4"><?php echo htmlspecialchars($user_data['username']); ?></h2>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
                    
                    <!-- Bio Section -->
                    <form method="POST">
                        <div class="mb-3">
                            <label for="bio" class="form-label"><strong>Bio:</strong></label>
                            <textarea class="form-control" name="bio" id="bio" rows="3"><?php echo htmlspecialchars($user_data['bio'] ?? ''); ?></textarea>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Bio</button>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </form>
                </div>
            </div>

            <!-- Add Skill Form -->
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Add New Skill</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="skill_name" class="form-label">Skill Name</label>
                            <input type="text" class="form-control" id="skill_name" name="skill_name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label d-block">I want to:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="skill_type" id="teach" value="teach" required>
                                <label class="form-check-label" for="teach">Teach</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="skill_type" id="learn" value="learn">
                                <label class="form-check-label" for="learn">Learn</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Skill</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Skills Display -->
        <div class="col-md-6">
            <!-- Skills Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">My Skills</h5>
                </div>
                <div class="card-body">
                    <?php
                    $user_skills = get_user_skills($user_id);
                    if ($user_skills && count($user_skills) > 0): ?>
                        <div class="row g-3">
                            <?php foreach ($user_skills as $skill): ?>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-1"><?php echo htmlspecialchars($skill['skill_name']); ?></h6>
                                                <div>
                                                    <?php if ($skill['teach']): ?>
                                                        <span class="badge bg-success">Teaching</span>
                                                    <?php endif; ?>
                                                    <?php if ($skill['learn']): ?>
                                                        <span class="badge bg-info">Learning</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <form method="POST" onsubmit="return confirm('Are you sure you want to remove this skill?');">
                                                <input type="hidden" name="skill_id" value="<?php echo $skill['id']; ?>">
                                                <input type="hidden" name="remove_skill" value="1">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No skills added yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./includes/footer.php"; ?>