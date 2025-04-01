<?php
require_once __DIR__ . "/functions.php";

// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Skill swap - Exchange Learning</title>
        <meta name="Skill swap" content="Let's learn something new">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/styles.css">
        <link rel="stylesheet" href="./css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
    <body id="bootstrap-overrides">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <?php if (is_logged_in()): ?>
                    <span class="navbar-brand text-muted">SkillSwap</span>
                <?php else: ?>
                    <a class="navbar-brand" href="index.php">SkillSwap</a>
                <?php endif; ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <?php if (!is_logged_in()): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" 
                                   href="index.php">Home</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'swaps.php') ? 'active' : ''; ?>" 
                               href="swaps.php">Find Swaps</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'requests.php') ? 'active' : ''; ?>" 
                               href="requests.php">Requests</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if (is_logged_in()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>" 
                                   href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($current_page == 'signup.php') ? 'active' : ''; ?>" 
                                   href="signup.php">Sign up</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Main content container -->
        <div class="container mt-4">
        <!-- Load Bootstrap JS at the end of body -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>