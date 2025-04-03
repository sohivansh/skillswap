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

// Get database connection
$conn = get_db_connection();

// Get all users and their skills (excluding current user)
$sql = "SELECT u.id, u.username, GROUP_CONCAT(
            CONCAT(s.skill_name, 
                CASE 
                    WHEN s.teach = 1 THEN ' (Teaching)'
                    WHEN s.learn = 1 THEN ' (Learning)'
                END
            ) SEPARATOR ', '
        ) as skills
        FROM users u
        LEFT JOIN skills s ON u.id = s.user_id
        WHERE u.id != ?
        GROUP BY u.id, u.username
        ORDER BY u.username";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

include "./includes/header.php";
?>

<div class="container mt-5">
    <h2 class="mb-4">Find Swaps</h2>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($user['username']); ?></h5>
                        <p class="card-text">
                            <strong>Skills:</strong><br>
                            <?php echo $user['skills'] ? htmlspecialchars($user['skills']) : 'No skills listed'; ?>
                        </p>
                        <form method="POST" action="request_swap.php">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-primary">Request</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include "./includes/footer.php"; ?> 