<?php
require_once 'config.php';

// Sanitize user input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Register new user
function register_user($username, $email, $password) {
    global $conn;
    
    // Sanitize inputs
    $username = sanitize_input($username);
    $email = sanitize_input($email);
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if username or email already exists
    $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        return ["success" => false, "message" => "Username or email already exists"];
    }
    
    // Insert new user
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Registration successful"];
    } else {
        return ["success" => false, "message" => "Registration failed: " . $conn->error];
    }
}

// Login user
function login_user($email, $password) {
    global $conn;
    
    // Sanitize email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    // Get user data with prepared statement
    $sql = "SELECT id, username, password FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['last_activity'] = time();
            
            return ["success" => true, "message" => "Login successful"];
        }
    }
    
    return ["success" => false, "message" => "Invalid email or password"];
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Get user data
function get_user_data($user_id) {
    global $conn;
    
    $sql = "SELECT id, username, email, bio, created_at 
            FROM users 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get user skills
function get_user_skills($user_id) {
    $conn = get_db_connection();
    
    $sql = "SELECT s.id, s.skill_name, s.teach, s.learn 
            FROM skills s 
            WHERE s.user_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $skills = $result->fetch_all(MYSQLI_ASSOC);
    
    $stmt->close();
    $conn->close();
    
    return $skills;
}

// Add skill to user
function add_user_skill($user_id, $skill_id, $proficiency_level, $is_teaching = false, $is_learning = false) {
    global $conn;
    
    // Convert boolean values to integers
    $is_teaching = $is_teaching ? 1 : 0;
    $is_learning = $is_learning ? 1 : 0;
    
    // Simple insert query
    $sql = "INSERT INTO user_skills (user_id, skill_id, proficiency_level, is_teaching, is_learning) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisii", $user_id, $skill_id, $proficiency_level, $is_teaching, $is_learning);
    
    return $stmt->execute();
}

// Get all skills
function get_all_skills() {
    global $conn;
    
    $sql = "SELECT id, name, category FROM skills ORDER BY name";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get all categories
function get_all_categories() {
    global $conn;
    
    $sql = "SELECT DISTINCT category FROM skills ORDER BY category";
    $result = $conn->query($sql);
    return array_column($result->fetch_all(MYSQLI_ASSOC), 'category');
}

// Get skill name by ID
function get_skill_name($skill_id) {
    global $conn;
    
    $sql = "SELECT name FROM skills WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $skill_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ? $result['name'] : '';
}

// Search for available swaps
function search_swaps($skill_id = '', $category = '', $proficiency = '', $location = '') {
    global $conn;
    
    $sql = "SELECT DISTINCT u.id as user_id, u.username, s.id as skill_id, s.name as skill_name, 
            s.category, us.proficiency_level, us.is_teaching, us.is_learning
            FROM users u
            JOIN user_skills us ON u.id = us.user_id
            JOIN skills s ON us.skill_id = s.id
            WHERE 1=1";
    
    $params = [];
    $types = "";
    
    if (!empty($skill_id)) {
        $sql .= " AND s.id = ?";
        $params[] = $skill_id;
        $types .= "i";
    }
    
    if (!empty($category)) {
        $sql .= " AND s.category = ?";
        $params[] = $category;
        $types .= "s";
    }
    
    if (!empty($proficiency)) {
        $sql .= " AND us.proficiency_level = ?";
        $params[] = $proficiency;
        $types .= "s";
    }
    
    // Add location filter if implemented
    if (!empty($location)) {
        // This would need to be implemented based on how you store location data
        // For now, we'll just ignore it
    }
    
    $sql .= " AND us.is_teaching = 1 ORDER BY u.username";
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function get_db_connection() {
    $host = 'localhost:3308';
    $username = 'root';
    $password = '';
    $database = 'skillswap';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?> 