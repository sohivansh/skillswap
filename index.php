<?php include "./includes/header.php"?>
    <!-- Main content container -->
    <div class="container mt-4">
        <!-- Hero Section -->
        <div class="container-fluid bg-light py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-4">SkillSwap</h1>
                        <p class="lead mb-4">Connect, Learn, and Grow Together</p>
                        <p class="text-muted mb-4">Exchange your skills with others in our community. Whether you're a programmer, artist, musician, or chef - there's always something to learn and teach.</p>
                        <a href="signup.php" class="btn btn-primary btn-lg me-2">Get Started</a>
                        <a href="#how-it-works" class="btn btn-outline-secondary btn-lg">Learn More</a>
                    </div>
                    <div class="col-lg-6">
                        <img src="./images/learning-illustration.svg" alt="Learning Together" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="container py-5" id="how-it-works">
            <h2 class="text-center mb-5">How It Works</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-person-plus fs-1 text-primary mb-3"></i>
                            <h3 class="card-title h4">Create Profile</h3>
                            <p class="card-text">Share your skills and what you'd like to learn from others.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-search fs-1 text-primary mb-3"></i>
                            <h3 class="card-title h4">Find Matches</h3>
                            <p class="card-text">Connect with people who want to learn your skills and teach you theirs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-arrow-repeat fs-1 text-primary mb-3"></i>
                            <h3 class="card-title h4">Start Learning</h3>
                            <p class="card-text">Schedule sessions and begin your skill exchange journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Skills Section -->
        <div class="container-fluid bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-5">Popular Skills</h2>
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                            <i class="bi bi-code-square text-primary me-3 fs-4"></i>
                            <span>Programming</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                            <i class="bi bi-music-note-beamed text-primary me-3 fs-4"></i>
                            <span>Music</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                            <i class="bi bi-palette text-primary me-3 fs-4"></i>
                            <span>Art & Design</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                            <i class="bi bi-translate text-primary me-3 fs-4"></i>
                            <span>Languages</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="mb-4">Ready to Start Learning?</h2>
                    <p class="lead mb-4">Join our community of learners and start exchanging skills today!</p>
                    <a href="signup.php" class="btn btn-primary btn-lg">Sign Up Now</a>
                </div>
            </div>
        </div>
    </div>
<?php include "./includes/footer.php"?>