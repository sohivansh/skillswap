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

// Get all requests with user details
$sql = "SELECT r.*, 
        u_from.username as requester_name, u_from.email as requester_email,
        u_to.username as requested_name, u_to.email as requested_email
        FROM swap_requests r
        JOIN users u_from ON r.requester_id = u_from.id
        JOIN users u_to ON r.requested_id = u_to.id
        WHERE r.requester_id = ? OR r.requested_id = ?
        ORDER BY r.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include "./includes/header.php";
?>

<div class="container mt-5">
    <h2 class="mb-4">Swap Requests</h2>
    <div class="row">
        <?php foreach ($requests as $request): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <?php if ($request['requester_id'] == $user_id): ?>
                            <!-- Outgoing Request -->
                            <h5 class="card-title">Request to: <?php echo htmlspecialchars($request['requested_name']); ?></h5>
                            <p class="card-text">
                                Hi, I think our skills match! Please contact me at 
                                <?php echo htmlspecialchars($request['requester_email']); ?>
                            </p>
                        <?php else: ?>
                            <!-- Incoming Request -->
                            <h5 class="card-title">Request from: <?php echo htmlspecialchars($request['requester_name']); ?></h5>
                            <p class="card-text">
                                Hi, I think our skills match! Please contact me at 
                                <?php echo htmlspecialchars($request['requester_email']); ?>
                            </p>
                        <?php endif; ?>
                        <p class="text-muted">
                            <small>Sent on: <?php echo date('M d, Y', strtotime($request['created_at'])); ?></small>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($requests)): ?>
            <div class="col-12">
                <p class="text-muted">No requests found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "./includes/footer.php"; ?> 